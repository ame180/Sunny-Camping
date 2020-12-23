<?php


namespace App\Repository;

use App\Models\Client;
use Illuminate\Http\Request;

interface ClientRepositoryInterface
{
    public function all();

    public function add(Request $request);
    // TODO: Change Request to array?
}
