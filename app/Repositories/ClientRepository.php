<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientItem;
use Illuminate\Database\Eloquent\Model;
use Request;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Client;
    }

    public function getPaginatedSearch(?string $query = null, ?string $status = null)
    {
        $paginatedClients = $this->model->replicate();

        if ($query) {
            $searchQuery = $query;
            $paginatedClients = $paginatedClients->where(function ($query) use ($searchQuery) {
                return $query
                    ->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhere('id', '=', "$searchQuery");
            });
        }

        if ($status) {
            $paginatedClients = $paginatedClients->where('status', '=', $status);
        }

        return $paginatedClients
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(Request::except('page'));
    }
}
