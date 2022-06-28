<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Request;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Client::class);
    }

    public function paginatedSearch(array $filters = []): LengthAwarePaginator
    {
        $paginatedClients = $this->model;

        if (isset($filters['query'])) {
            $searchQuery = $filters['query'];
            $paginatedClients = $paginatedClients->where(function ($query) use ($searchQuery) {
                return $query
                    ->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhere('id', '=', "$searchQuery");
            });
        }

        if (isset($filters['status'])) {
            $paginatedClients = $paginatedClients->where('status', '=', $filters['status']);
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

    public function findAllRegisteredClients(): Collection
    {
        return $this->model
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

    public function findAllClientNames(): Collection
    {
        return $this->getQueryBuilder()
            ->select('name')
            ->get();
    }
}
