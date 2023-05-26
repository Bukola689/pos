<?php

namespace App\Providers;

use App\Repository\Admin\Category\CategoryRepository;
use App\Repository\Admin\Category\ICategoryRepository;
use App\Repository\Admin\Company\CompanyRepository;
use App\Repository\Admin\Company\ICompanyRepository;
use App\Repository\Admin\User\IUserRepository;
use App\Repository\Admin\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(ICompanyRepository::class, CompanyRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
