<?php

namespace Tests\Feature;

use App\Models\Client;
use PHPUnit\Framework\Attributes\Test;

class RevenueReportTest extends ReportTestCase
{
    private const REVENUE_URL = '/api/reports/revenue?year=' . self::REPORT_YEAR;

    #[Test]
    public function unauthenticatedRequestRedirectsToLogin()
    {
        $this->withoutMix();
        $response = $this->get(self::REVENUE_URL);

        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function revenueIsSplitByCategoryWithDiscountOnPeopleOnly()
    {
        $people = $this->createCategory('Osoby');
        $climate = $this->createCategory('Klimatyczne');
        $electricity = $this->createCategory('Prąd');
        $client = $this->createSettledClient('2025-07-01', '2025-07-05', ['discount' => 10]);
        $this->createClientItem($client, $people, 20, 2);
        $this->createClientItem($client, $climate, 2, 2);
        $this->createClientItem($client, $electricity, 12, 1, ['days' => 2]);
        $this->createClientItem($client, null, 5);

        $response = $this->getReport(self::REVENUE_URL);

        $response->assertOk();
        $response->assertJsonPath('year', self::REPORT_YEAR);
        $this->assertSame(['Osoby', 'Klimatyczne', 'Prąd', 'Inne'], collect($response->json('series'))->pluck('key')->all());
        $this->assertEquals([
            'Osoby' => $this->monthValues([7 => 144]),
            'Klimatyczne' => $this->monthValues([7 => 16]),
            'Prąd' => $this->monthValues([7 => 24]),
            'Inne' => $this->monthValues([7 => 20]),
        ], $this->seriesValuesByKey($response));
    }

    #[Test]
    public function revenueIsAttributedToDepartureMonth()
    {
        $electricity = $this->createCategory('Prąd');
        $this->createClientItem($this->createSettledClient('2025-07-30', '2025-08-02'), $electricity, 10);
        $this->createClientItem($this->createSettledClient('2024-12-30', '2025-01-01'), $electricity, 10);

        $response = $this->getReport(self::REVENUE_URL);

        $this->assertEquals(['Prąd' => $this->monthValues([1 => 20, 8 => 30])], $this->seriesValuesByKey($response));
    }

    #[Test]
    public function unsettledClientsAndOtherYearsAreExcluded()
    {
        $electricity = $this->createCategory('Prąd');
        $this->createClientItem($this->createSettledClient('2025-07-01', '2025-07-02'), $electricity, 10);
        $this->createClientItem(
            $this->createSettledClient('2025-07-01', '2025-07-02', ['status' => Client::STATUS_UNSETTLED]),
            $electricity,
            100
        );
        $this->createClientItem($this->createSettledClient('2024-07-01', '2024-07-02'), $electricity, 1000);

        $response = $this->getReport(self::REVENUE_URL);

        $this->assertEquals(['Prąd' => $this->monthValues([7 => 10])], $this->seriesValuesByKey($response));
    }

    #[Test]
    public function yearDefaultsToCurrentYear()
    {
        $response = $this->getReport('/api/reports/revenue');

        $response->assertOk();
        $response->assertJsonPath('year', now()->year);
    }

    #[Test]
    public function yearsListSettledDepartureYearsNewestFirst()
    {
        $this->createSettledClient('2023-07-01', '2023-07-02');
        $this->createSettledClient('2025-07-01', '2025-07-02');
        $this->createSettledClient('2025-08-01', '2025-08-02');
        $this->createSettledClient('2024-07-01', '2024-07-02', ['status' => Client::STATUS_UNSETTLED]);

        $response = $this->getReport('/api/reports/years');

        $response->assertOk();
        $response->assertExactJson([2025, 2023]);
    }
}
