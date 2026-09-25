<?php

namespace App\Reports;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Support\Carbon;

class GuestsByCountryReport
{
    private const LISTED_COUNTRIES_LIMIT = 6;
    private const OTHER_COUNTRIES = 'Inne';
    private const MISSING_COUNTRY = 'Brak';

    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function forYear(int $year): array
    {
        $stays = [];
        $countryLabels = [];
        $countryTotals = [];

        /** @var Client $client */
        foreach ($this->clientRepository->findSettledDepartingInYear($year) as $client) {
            $people = $this->peopleCount($client);
            if (0 === $people) {
                continue;
            }

            $country = trim((string) $client->country);
            $countryKey = '' === $country ? self::MISSING_COUNTRY : mb_strtolower($country);
            $countryLabels[$countryKey] ??= '' === $country ? self::MISSING_COUNTRY : $country;
            $countryTotals[$countryKey] = ($countryTotals[$countryKey] ?? 0) + $people;

            $stays[] = [$countryKey, Carbon::parse($client->departure_date)->month, $people];
        }

        $listedCountries = $this->listedCountries($countryTotals);
        $series = new MonthlySeries();
        foreach ($listedCountries as $countryKey) {
            $series->declare($countryKey, $countryLabels[$countryKey]);
        }

        foreach ($stays as [$countryKey, $month, $people]) {
            if (!in_array($countryKey, $listedCountries, true)) {
                $countryKey = self::OTHER_COUNTRIES;
                $countryLabels[$countryKey] = self::OTHER_COUNTRIES;
            }

            $series->add($countryKey, $countryLabels[$countryKey], $month, $people);
        }

        return [
            'year' => $year,
            'series' => $series->toArray(
                fn (array $first, array $second) => $this->seriesRank($first['key']) <=> $this->seriesRank($second['key'])
            ),
        ];
    }

    private function peopleCount(Client $client): int
    {
        return $client->clientItems
            ->filter(fn ($clientItem) => 'Osoby' === $clientItem->serviceCategory?->name)
            ->sum('count');
    }

    private function listedCountries(array $countryTotals): array
    {
        $namedCountryTotals = array_diff_key($countryTotals, [self::MISSING_COUNTRY => 0]);
        arsort($namedCountryTotals);

        $listedCountries = array_slice(array_keys($namedCountryTotals), 0, self::LISTED_COUNTRIES_LIMIT);
        if (isset($countryTotals[self::MISSING_COUNTRY])) {
            $listedCountries[] = self::MISSING_COUNTRY;
        }

        return $listedCountries;
    }

    private function seriesRank(string $key): int
    {
        return match ($key) {
            self::OTHER_COUNTRIES => 1,
            self::MISSING_COUNTRY => 2,
            default => 0,
        };
    }
}
