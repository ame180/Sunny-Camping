<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Reports\PaymentsByTypeReport;
use App\Reports\RevenueByCategoryReport;
use App\Repositories\ClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function years(ClientRepository $clientRepository): JsonResponse
    {
        return response()->json($clientRepository->findSettledDepartureYears());
    }

    public function revenue(Request $request, RevenueByCategoryReport $report): JsonResponse
    {
        return response()->json($report->forYear($this->requestedYear($request)));
    }

    public function payments(Request $request, PaymentsByTypeReport $report): JsonResponse
    {
        return response()->json($report->forYear($this->requestedYear($request)));
    }

    private function requestedYear(Request $request): int
    {
        return $request->integer('year', now()->year);
    }
}
