<?php


namespace App\Http\Controllers;


class HomeController extends Controller
{

    public function home($year = 2020)
    {
        return view('home', ['year' => $year]);
    }
}
