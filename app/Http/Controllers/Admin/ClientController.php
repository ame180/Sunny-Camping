<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\ValuesRepositoryInterface;

class ClientController extends Controller
{
    public function __construct(ClientRepositoryInterface $clientsRepository)
    {
        $this->clientRepository = $clientsRepository;
    }

    public function addClient()
    {
        return view('admin.clients.add', ['page' => 'clients', 'nav_items' =>
            config('constants.admin_nav_items'), 'inputs' => config('constants.client_inputs')]);
    }

    public function add(Request $request)
    {
        if ($this->clientRepository->add($request->all())) {
            return true;
        }
        return response('', 406);
    }

    public function edit($id)
    {
        $client = $this->clientRepository->find($id);
        return view('admin.clients.edit', ['page' => 'clients', 'nav_items' =>
            config('constants.admin_nav_items'), 'inputs' => config('constants.client_inputs'),
            'client' => $client]);
    }

    public function update(Request $request, $id)
    {
        if ($this->clientRepository->update($id, $request->all()))
            return redirect()->route('admin.clients');
        return redirect()->route('admin.clients.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        $this->clientRepository->delete($id);
    }

    public function getAllJson(Request $request)
    {
        return $this->clientRepository->paginate($request->toArray())->toJson();
    }
}
