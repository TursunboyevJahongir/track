<?php

namespace App\Providers;

use App\Core\Contracts\{CoreRepositoryContract, CoreServiceContract};
use App\Core\Repositories\CoreRepository;
use App\Core\Services\CoreService;
use App\Repositories\{
    ResourceRepository,
    SmsRepository,
    UserRepository
};
use App\Contracts\{
    ResourceRepositoryContract,
    ResourceServiceContract,
    SmsRepositoryContract,
    SmsServiceContract,
    UserRepositoryContract,
    UserServiceContract
};
use App\Services\{
    ResourceService,
    UserService
};
use App\Services\Sms\SmsService;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Profiler\Profile;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        $this->app->bind(CoreServiceContract::class, CoreService::class);
        $this->app->bind(CoreRepositoryContract::class, CoreRepository::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(SmsServiceContract::class, SmsService::class);
        $this->app->bind(ResourceServiceContract::class, ResourceService::class);
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(ResourceRepositoryContract::class, ResourceRepository::class);
        $this->app->bind(SmsRepositoryContract::class, SmsRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerTheme(mix('css/app.css'));
        });
    }
}
