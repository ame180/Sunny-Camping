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

    public function delete(Request $request, $id)
    {
        $this->clientRepository->delete($id);
        return redirect()->route('admin.clients');
    }
}
