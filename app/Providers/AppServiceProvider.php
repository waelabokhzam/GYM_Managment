<?php
namespace App\Providers;

use App\Models\Player;
use App\Models\Staff;
use App\Models\Subscription;
use App\Policies\Player\PlayerPolicy;
use App\Policies\Subscription\SubscriptionPolicy;
use App\Policies\Trainer\TrainerPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(Subscription::class, SubscriptionPolicy::class);
    }
}
