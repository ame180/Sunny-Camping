<?php

namespace Tests\Feature;

use App\Models\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class PaymentsReportTest extends ReportTestCase
{
    private const PAYMENTS_URL = '/api/reports/payments?year=' . self::REPORT_YEAR;

    #[Test]
    public function unauthenticatedRequestRedirectsToLogin()
    {
        $this->withoutMix();
        $response = $this->get(self::PAYMENTS_URL);

        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function allPaymentTypesAreListedEvenWithoutData()
    {
        $response = $this->getReport(self::PAYMENTS_URL);

        $response->assertOk();
        $this->assertSame(['T', 'F', 'B', 'N', 'K', 'Inne'], collect($response->json('series'))->pluck('key')->all());
    }

    #[Test]
    #[DataProvider('paymentTypeCases')]
    public function clientIsBucketedByPaymentFlags(array $flags, string $expectedPaymentType, float $expectedAmount)
    {
        $this->createSettledClient('2025-07-01', '2025-07-05', array_merge(['paid' => 100, 'climate_paid' => 8], $flags));

        $values = $this->seriesValuesByKey($this->getReport(self::PAYMENTS_URL));

        $this->assertEquals($this->monthValues([7 => $expectedAmount]), $values[$expectedPaymentType]);
        $this->assertEquals($expectedAmount, collect($values)->flatten()->sum());
    }

    public static function paymentTypeCases(): array
    {
        return [
            'terminal only excludes climate' => [['terminal' => true], 'T', 100],
            'invoice only' => [['invoice' => true], 'F', 100],
            'voucher only' => [['voucher' => true], 'B', 100],
            'cash register only' => [['cash_register' => true], 'K', 100],
            'unregistered only includes climate' => [['unregistered' => true], 'N', 108],
            'terminal with cash register is mixed' => [['terminal' => true, 'cash_register' => true], 'Inne', 100],
            'unregistered within mixed includes climate' => [['terminal' => true, 'unregistered' => true], 'Inne', 108],
            'no flags is mixed' => [[], 'Inne', 100],
        ];
    }

    #[Test]
    public function paymentsAreAttributedToDepartureMonthForSettledClientsOfTheYear()
    {
        $this->createSettledClient('2025-07-30', '2025-08-02', ['terminal' => true, 'paid' => 50]);
        $this->createSettledClient('2024-12-30', '2025-01-01', ['terminal' => true, 'paid' => 20]);
        $this->createSettledClient('2025-07-01', '2025-07-02', ['terminal' => true, 'paid' => 300, 'status' => Client::STATUS_UNSETTLED]);
        $this->createSettledClient('2024-07-01', '2024-07-02', ['terminal' => true, 'paid' => 4000]);

        $values = $this->seriesValuesByKey($this->getReport(self::PAYMENTS_URL));

        $this->assertEquals($this->monthValues([1 => 20, 8 => 50]), $values['T']);
    }
}
