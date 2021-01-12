<?php


namespace App\Http\Controllers;

use App\Repositories\ClientRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\ValuesRepositoryInterface;

class AdminController extends Controller
{
    public function __construct(ClientRepositoryInterface $clientsRepository)
    {
        $this->clientRepository = $clientsRepository;
    }

    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard', 'nav_items' =>
            config('constants.admin_nav_items')]);
    }

    public function clients(Request $request)
    {
        $clients = $this->clientRepository->all();
        return view('admin.clients', ['page' => 'clients', 'nav_items' =>
            config('constants.admin_nav_items'), 'clients' => $clients]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills', 'nav_items' =>
            config('constants.admin_nav_items')]);
    }
}
