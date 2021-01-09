<?php


namespace App\Http\Controllers;

use App\Repositories\ClientRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public static $nav_items = ['dashboard' => 'Podsumowanie', 'clients' => 'Klienci', 'bills' => 'Rachunki'];

    /**
     * @var ClientRepositoryInterface
     */

    public function __construct(ClientRepositoryInterface $clientsRepository)
    {
        $this->clientRepository = $clientsRepository;
    }

    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard', 'nav_items' => self::$nav_items]);
    }

    public function clients(Request $request)
    {
        $clients = $this->clientRepository->all();
        return view('admin.clients', ['page' => 'clients', 'nav_items' => self::$nav_items, 'clients' => $clients]);
    }

    public function bills()
    {
        return view('admin.dashboard', ['page' => 'bills', 'nav_items' => self::$nav_items]);
    }
}
