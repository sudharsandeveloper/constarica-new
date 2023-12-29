<?php

namespace App\Providers;

use App\Repository\Interfaces\AreaRepositoryInterface;
use App\Repository\Repositories\AreaRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AreaRepositoryInterface::class, AreaRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
