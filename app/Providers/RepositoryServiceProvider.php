<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\CollectionRepositoryInterface;
use App\Repositories\CollectionRepository;
use App\Models\User;
use App\Models\Collection;
use App\Services\Impact\ImpactCalculatorStrategy;
use App\Services\Impact\CO2Calculator;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, fn($app) => new UserRepository(new User()));
        $this->app->bind(CollectionRepositoryInterface::class, fn($app) => new CollectionRepository(new Collection()));

        // Strategy default
        $this->app->bind(ImpactCalculatorStrategy::class, CO2Calculator::class);

        // Scheduler singleton (attach observers aquí o en boot)
        $this->app->singleton(\App\Services\CollectionScheduler::class, function ($app) {
            $scheduler = new \App\Services\CollectionScheduler();
            $scheduler->attach($app->make(\App\Services\Observers\EmailNotifier::class));
            $scheduler->attach($app->make(\App\Services\Observers\SMSNotifier::class));
            $scheduler->attach($app->make(\App\Services\Observers\DatabaseLogger::class));
            return $scheduler;
        });

        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return new UserRepository(new \App\Models\User());
        });

        $this->app->bind(CollectionRepositoryInterface::class, function ($app) {
            return new CollectionRepository(new \App\Models\Collection());
        });

        // Default strategy binding (opcional)
        $this->app->bind(ImpactCalculatorStrategy::class, CO2Calculator::class);
    }

    public function boot() {}
}
