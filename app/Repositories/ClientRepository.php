<?php

namespace App\Repositories;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Request;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Client::class);
    }

    public function getCurrentSeasonBaseQuery(): Builder
    {
        return $this->model->where(function (Builder $query) {
            return $query
                ->whereYear('arrival_date', '=', Carbon::now()->year)
                ->orWhereNull('arrival_date');
        });
    }

    public function paginatedSearch(array $filters = []): LengthAwarePaginator
    {
        $paginatedClients = $this->getCurrentSeasonBaseQuery();

        if (isset($filters['query'])) {
            $searchQuery = $filters['query'];
            $paginatedClients = $paginatedClients->where(function ($query) use ($searchQuery) {
                return $query
                    ->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhere('car_registration', 'LIKE', "%$searchQuery%")
                    ->orWhere('id', '=', "$searchQuery");
            });
        }

        if (isset($filters['status'])) {
            $paginatedClients = $paginatedClients->where('status', '=', $filters['status']);
        }

        if (isset($filters['departure_date'])) {
            $paginatedClients = $paginatedClients->where('departure_date', '=', $filters['departure_date']);
        }

        if (isset($filters['token_number'])) {
            $paginatedClients = $paginatedClients->where('token_number', '=', $filters['token_number']);
        }

        foreach (['unregistered', 'cash_register', 'terminal', 'voucher', 'invoice'] as $code) {
            if (isset($filters[$code])) {
                $paginatedClients = $paginatedClients->where($code, '=', true);
            }
        }

        return $paginatedClients
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(Request::except('page'));
    }

    public function findCurrentRegisteredClients(): Collection
    {
        return $this->getCurrentSeasonBaseQuery()
            ->where(function ($query) {
                return $query
                    ->where('cash_register', '=', true)
                    ->orWhere('terminal', '=', true)
                    ->orWhere('voucher', '=', true)
                    ->orWhere('invoice', '=', true);
            })
            ->where('unregistered', '=', false)
            ->whereNotNull('arrival_date')
            ->whereNotNull('departure_date')
            ->get();
    }

    public function findCurrentClientNames(): Collection
    {
        return $this->getCurrentSeasonBaseQuery()
            ->select('name')
            ->get();
    }

    public function findCurrentAssignedTokens(): Collection
    {
        return $this->getCurrentSeasonBaseQuery()
            ->select('token_number')
            ->distinct()
            ->whereNotNull('token_number')
            ->get();
    }
}
