<?php


namespace App\Http\Controllers;

use App\Repositories\ClientRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\ValuesRepositoryInterface;

class AdminController extends Controller
{
    public function __construct(ClientRepositoryInterface $clientsRepository, ValuesRepositoryInterface $valuesRepository)
    {
        $this->clientRepository = $clientsRepository;
        $this->valuesRepository = $valuesRepository;
    }

    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard', 'nav_items' =>
            $this->valuesRepository->getByType('admin_nav_item')]);
    }

    public function clients(Request $request)
    {
        $clients = $this->clientRepository->all();
        return view('admin.clients', ['page' => 'clients', 'nav_items' =>
            $this->valuesRepository->getByType('admin_nav_item'), 'clients' => $clients]);
    }

    public function bills()
    {
        return view('admin.dashboard', ['page' => 'bills', 'nav_items' =>
            $this->valuesRepository->getByType('admin_nav_item')]);
    }
}
