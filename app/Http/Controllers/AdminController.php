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
        $filters = [];

        if ($request->input('name')) {
            $filters[] = ['name', 'LIKE', "%{$request->input('name')}%"];
        }

        if ($request->input('status')) {
            $filters[] = ['status', '=', $request->input('status')];
        }

        $paginatedClients = Client::where($filters)
            ->paginate(10)
            ->appends(\Request::except('page'));

        return view('admin.clients', [
            'page' => 'clients',
            'pagination' => $paginatedClients->links(),
            'clients' => $paginatedClients->toJson(),
            'filters' => collect([
                'name' => $request->input('name'),
                'status' => $request->input('status') ?? '',
            ])->toJson()
        ]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills']);
    }
}
