<?php

namespace App\Repositories;

use App\Models\Client;
use Request;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Client::class);
    }

    public function paginatedSearch(array $filters = [])
    {
        $paginatedClients = $this->model->replicate();

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
            if (isset($filters[$code]))
            $paginatedClients = $paginatedClients->where($code, '=', true);
        }

        return $paginatedClients
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(Request::except('page'));
    }
}
