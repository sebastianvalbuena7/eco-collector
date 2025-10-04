<?php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\CollectionRepositoryInterface;
use App\Repositories\CollectionRepository;
use App\Models\User;
use App\Models\Collection;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // bind interfaces to concrete implementations
        $this->app->bind(UserRepositoryInterface::class, function($app){
            return new UserRepository(new User());
        });

        $this->app->bind(CollectionRepositoryInterface::class, function($app){
            return new CollectionRepository(new Collection());
        });

        // si ya tienes RepositoryServiceProvider y prefieres usarlo, entonces regístralo en config/app.php
    }

    public function boot()
    {
        //
    }
}
