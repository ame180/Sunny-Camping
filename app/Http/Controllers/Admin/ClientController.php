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
        return view('admin.clients.client_input_form', ['page' => 'clients', 'nav_items' =>
            config('constants.admin_nav_items'), 'mode' => 'PUT']);
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
        return view('admin.clients.client_input_form', ['page' => 'clients', 'nav_items' =>
            config('constants.admin_nav_items'), 'mode' => 'PATCH', 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        if ($this->clientRepository->update($id, $request->all())) {
            return true;
        }
        return response('', 406);
    }

    public function delete($id)
    {
        $this->clientRepository->delete($id);
    }

    public function paginatedJson(Request $request)
    {
        return $this->clientRepository->paginate($request->toArray())->toJson();
    }

    public function findJson($id)
    {
        return $this->clientRepository->find($id)->toJson();
    }
}
