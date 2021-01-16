<?php


namespace App\Http\Controllers;

use App\Repositories\ClientRepositoryInterface;

class AdminController extends Controller
{
    /**
     * @var ClientRepositoryInterface
     */
    private $clientsRepository;

    public function __construct(ClientRepositoryInterface $clientsRepository)
    {
        $this->clientsRepository = $clientsRepository;
    }

    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard', 'nav_items' =>
            config('constants.admin_nav_items')]);
    }

    public function clients()
    {
        $clients = $this->clientsRepository->all();
        return view('admin.clients', ['page' => 'clients', 'nav_items' =>
            config('constants.admin_nav_items'), 'clients' => $clients]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills', 'nav_items' =>
            config('constants.admin_nav_items')]);
    }
}
