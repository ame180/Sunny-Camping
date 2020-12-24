<?php


namespace App\Http\Controllers\Admin;


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
        $this->clientRepository->add($request);
        return redirect()->route('admin.clients');
    }

    public function delete(Request $request, $id)
    {
        $this->clientRepository->delete($id);
        return redirect()->route('admin.clients');
    }
}
