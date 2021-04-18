<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard']);
    }

    public function clients()
    {
        return view('admin.clients', ['page' => 'clients']);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills']);
    }
}
