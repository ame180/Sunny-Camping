<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard']);
    }

    public function clients(Request $request)
    {
        $paginatedClients = $this->clientRepository->paginatedSearch($request->query());

        return view('admin.clients', [
            'page' => 'clients',
            'pagination' => $paginatedClients->links(),
            'clients' => $paginatedClients->toJson(),
            'filters' => collect($request->query())->toJson(),
        ]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills']);
    }
}
