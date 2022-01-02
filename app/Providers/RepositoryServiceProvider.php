<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\IUserRepo;
use App\Repository\UserRepo;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepo::class, UserRepo::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
