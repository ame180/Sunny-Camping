<?php

namespace App\Reports;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Support\Carbon;

class RevenueByCategoryReport
{
    private const UNCATEGORIZED = 'Inne';

    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function forYear(int $year): array
    {
        $series = new MonthlySeries();
        $categoryOrder = [];

        /** @var Client $client */
        foreach ($this->clientRepository->findSettledDepartingInYear($year) as $client) {
            if (0 === $client->days) {
                continue;
            }

            $month = Carbon::parse($client->departure_date)->month;

            foreach ($client->clientItems as $clientItem) {
                $category = $clientItem->serviceCategory->name ?? self::UNCATEGORIZED;
                $categoryOrder[$category] ??= $clientItem->serviceCategory->id ?? PHP_INT_MAX;

                $series->add($category, $category, $month, $client->getItemPrice($clientItem));
            }
        }

        return [
            'year' => $year,
            'series' => $series->toArray(
                fn (array $first, array $second) => $categoryOrder[$first['key']] <=> $categoryOrder[$second['key']]
            ),
        ];
    }
}
