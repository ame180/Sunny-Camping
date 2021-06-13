<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard']);
    }

    public function clients(Request $request)
    {
        $name = $request->input('name');

        if ($name) {
            $paginatedClients = Client::where([['name', 'LIKE', "%$name%"]])->paginate(10);
        } else {
            $paginatedClients = Client::paginate(10);
        }

        $paginatedClients->appends(\Request::except('page'));

        return view('admin.clients', [
            'page' => 'clients',
            'pagination' => $paginatedClients->links(),
            'clients' => $paginatedClients->toJson(),
        ]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills']);
    }
}
