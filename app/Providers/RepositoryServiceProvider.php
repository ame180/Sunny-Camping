<?php

namespace App\Providers;

use App\Repositories\ClientRepositoryInterface;
use App\Repositories\Eloquent\ClientRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
    }
}
