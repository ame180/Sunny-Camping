<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Repositories\ClientRepository;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard']);
    }

    public function clients()
    {
        $paginatedClients = Client::paginate(10);

        return view('admin.clients', [
            'page' => 'clients',
            'pagination' => $paginatedClients->links(),
            'clients' => $paginatedClients->toJson(),
        ]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills']);
    }
}
