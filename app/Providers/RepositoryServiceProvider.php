<?php

namespace App\Providers;

use App\Repositories\ClientRepositoryInterface;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\ValuesRepository;
use App\Repositories\ValuesRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ValuesRepositoryInterface::class, ValuesRepository::class);
    }
}
