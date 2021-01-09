<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(ClientRepositoryInterface $clientsRepository)
    {
        $this->clientRepository = $clientsRepository;
    }

    public function add(Request $request)
    {
        if ($this->clientRepository->add($request->all()))
            return redirect()->route('admin.clients');
        return view('admin.clients.add', ['page' => 'clients', 'nav_items' => AdminController::$nav_items]);
    }

    public function edit(Request $request, $id)
    {
        $client = $this->clientRepository->find($id);
        return view('admin.clients.edit', ['page' => 'clients', 'nav_items' => AdminController::$nav_items,
            'client' => $client]);
    }

    public function delete($id)
    {
        $this->clientRepository->delete($id);
        return redirect()->route('admin.clients');
    }
}
