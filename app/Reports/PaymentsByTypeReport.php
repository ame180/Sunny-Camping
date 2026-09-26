<?php

namespace App\Reports;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Support\Carbon;

class PaymentsByTypeReport
{
    private const PAYMENT_TYPES = [
        'T' => 'terminal',
        'F' => 'invoice',
        'B' => 'voucher',
        'N' => 'unregistered',
        'K' => 'cash_register',
    ];
    private const MIXED_PAYMENT_TYPE = 'Inne';

    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function forYear(int $year): array
    {
        $series = new MonthlySeries();
        foreach ([...array_keys(self::PAYMENT_TYPES), self::MIXED_PAYMENT_TYPE] as $paymentType) {
            $series->declare($paymentType, $paymentType);
        }

        /** @var Client $client */
        foreach ($this->clientRepository->findSettledDepartingInYear($year) as $client) {
            $paymentType = $this->paymentType($client);
            $amount = $client->unregistered ? $client->paid + $client->climate_paid : $client->paid;

            $series->add($paymentType, $paymentType, Carbon::parse($client->departure_date)->month, $amount);
        }

        return [
            'year' => $year,
            'series' => $series->toArray(),
        ];
    }

    private function paymentType(Client $client): string
    {
        $flaggedTypes = array_keys(array_filter(self::PAYMENT_TYPES, fn (string $flag) => (bool) $client->$flag));

        return 1 === count($flaggedTypes) ? $flaggedTypes[0] : self::MIXED_PAYMENT_TYPE;
    }
}
