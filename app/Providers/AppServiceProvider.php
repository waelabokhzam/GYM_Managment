<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Player;
use App\Models\Staff;
use App\Policies\Player\PlayerPolicy;
use App\Policies\Trainer\TrainerPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Player::class, PlayerPolicy::class);
        Gate::policy(Staff::class, TrainerPolicy::class);
    }
}
