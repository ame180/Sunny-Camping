<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\ValuesRepositoryInterface;

class ClientController extends Controller
{
    public function __construct(ClientRepositoryInterface $clientsRepository, ValuesRepositoryInterface $valuesRepository)
    {
        $this->clientRepository = $clientsRepository;
        $this->valuesRepository = $valuesRepository;
    }

    public function add(Request $request)
    {
        if ($this->clientRepository->add($request->all()))
            return redirect()->route('admin.clients');
        return view('admin.clients.add', ['page' => 'clients', 'nav_items' =>
            $this->valuesRepository->getByType('admin_nav_item')]);
    }

    public function edit($id)
    {
        $client = $this->clientRepository->find($id);
        return view('admin.clients.edit', ['page' => 'clients', 'nav_items' =>
            $this->valuesRepository->getByType('admin_nav_item'), 'client' => $client]);
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
        return redirect()->route('admin.clients');
    }
}
