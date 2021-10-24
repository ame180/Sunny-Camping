<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ClientRepository;

class ClientController extends Controller
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientsRepository)
    {
        $this->clientRepository = $clientsRepository;
    }

    public function addClient()
    {
        return view('admin.clients.client_input_form', ['page' => 'clients', 'nav_items' => config('constants.admin_nav_items'), 'mode' => 'POST']);
    }

    public function edit($id)
    {
        if (!$this->clientRepository->find($id)) {
            return response('', 404);
        }

        return view('admin.clients.client_input_form', ['page' => 'clients', 'nav_items' => config('constants.admin_nav_items'), 'mode' => 'PUT', 'id' => $id]);
    }
}
