<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ServiceCategory;
use PHPUnit\Framework\Attributes\Test;

class GuestsReportTest extends ReportTestCase
{
    private const GUESTS_URL = '/api/reports/guests?year=' . self::REPORT_YEAR;

    private ServiceCategory $people;

    public function setUp(): void
    {
        parent::setUp();
        $this->people = $this->createCategory('Osoby');
    }

    #[Test]
    public function unauthenticatedRequestRedirectsToLogin()
    {
        $this->withoutVite();
        $response = $this->get(self::GUESTS_URL);

        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function guestsCountPeopleItemsOnly()
    {
        $client = $this->createGuest('Polska', '2025-07-01', '2025-07-05', 3);
        $this->createClientItem($client, $this->people, 15, 2);
        $this->createClientItem($client, $this->createCategory('Prąd'), 12, 4);

        $response = $this->getReport(self::GUESTS_URL);

        $response->assertOk();
        $this->assertEquals(['polska' => $this->monthValues([7 => 5])], $this->seriesValuesByKey($response));
    }

    #[Test]
    public function countrySpellingVariantsAreGroupedAndBlankCountsAsPoland()
    {
        $this->createGuest('Niemcy', '2025-07-01', '2025-07-05', 2);
        $this->createGuest(' niemcy ', '2025-07-01', '2025-07-05', 1);
        $this->createGuest('Polska', '2025-07-01', '2025-07-05', 2);
        $this->createGuest(null, '2025-07-01', '2025-07-05', 4);
        $this->createGuest('  ', '2025-07-01', '2025-07-05', 1);

        $series = collect($this->getReport(self::GUESTS_URL)->json('series'));

        $this->assertSame(['polska' => 'Polska', 'niemcy' => 'Niemcy'], $series->pluck('label', 'key')->all());
        $this->assertEquals(
            ['polska' => $this->monthValues([7 => 7]), 'niemcy' => $this->monthValues([7 => 3])],
            $series->pluck('values', 'key')->all()
        );
    }

    #[Test]
    public function blankCountryAloneIsLabelledPoland()
    {
        $this->createGuest(null, '2025-07-01', '2025-07-05', 2);

        $series = collect($this->getReport(self::GUESTS_URL)->json('series'));

        $this->assertSame(['polska' => 'Polska'], $series->pluck('label', 'key')->all());
    }

    #[Test]
    public function countriesBeyondTopSixFoldIntoOther()
    {
        foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'] as $index => $country) {
            $this->createGuest($country, '2025-07-01', '2025-07-05', 10 - $index);
        }

        $series = collect($this->getReport(self::GUESTS_URL)->json('series'));

        $this->assertSame(['a', 'b', 'c', 'd', 'e', 'f', 'Inne'], $series->pluck('key')->all());
        $this->assertEquals($this->monthValues([7 => 7]), $series->firstWhere('key', 'Inne')['values']);
    }

    #[Test]
    public function guestsAreAttributedToDepartureMonthForSettledClientsOfTheYear()
    {
        $this->createGuest('Polska', '2025-07-30', '2025-08-02', 2);
        $this->createGuest('Polska', '2024-12-30', '2025-01-01', 3);
        $this->createGuest('Polska', '2025-07-01', '2025-07-02', 30, ['status' => Client::STATUS_UNSETTLED]);
        $this->createGuest('Polska', '2024-07-01', '2024-07-02', 400);

        $values = $this->seriesValuesByKey($this->getReport(self::GUESTS_URL));

        $this->assertEquals(['polska' => $this->monthValues([1 => 3, 8 => 2])], $values);
    }

    private function createGuest(?string $country, string $arrivalDate, string $departureDate, int $people, array $attributes = []): Client
    {
        $client = $this->createSettledClient($arrivalDate, $departureDate, array_merge(['country' => $country], $attributes));
        $this->createClientItem($client, $this->people, 18, $people);

        return $client;
    }
}
