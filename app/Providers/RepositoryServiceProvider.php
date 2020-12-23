<?php

namespace App\Providers;

use App\Repository\ClientRepositoryInterface;
use App\Repository\Eloquent\ClientRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
    }
}
