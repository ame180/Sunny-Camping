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
        $paginatedClients = new Client();

        if ($request->input('query')) {
            $searchQuery = $request->input('query');
            $paginatedClients = $paginatedClients->where(function ($query) use ($searchQuery) {
                return $query
                    ->where('name', 'LIKE', "%$searchQuery%")
                    ->orWhere('id', '=', "$searchQuery");
            });
        }

        if ($request->input('status')) {
            $paginatedClients = $paginatedClients->where('status', '=', $request->input('status'));
        }

        $paginatedClients = $paginatedClients
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(\Request::except('page'));

        return view('admin.clients', [
            'page' => 'clients',
            'pagination' => $paginatedClients->links(),
            'clients' => $paginatedClients->toJson(),
            'filters' => collect([
                'query' => $request->input('query'),
                'status' => $request->input('status') ?? '',
            ])->toJson(),
        ]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills']);
    }
}
