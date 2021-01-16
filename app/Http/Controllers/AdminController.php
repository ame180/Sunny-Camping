<?php


namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard', 'nav_items' =>
            config('constants.admin_nav_items')]);
    }

    public function clients()
    {
        return view('admin.clients', ['page' => 'clients', 'nav_items' =>
            config('constants.admin_nav_items')]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills', 'nav_items' =>
            config('constants.admin_nav_items')]);
    }
}
