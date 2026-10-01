<?php
namespace App\Providers;

use App\Models\FinancialTransaction;
use App\Models\InternalRequest;
use App\Models\Player;
use App\Models\PlayerGame;
use App\Models\Staff;
use App\Models\Subscription;
use App\Models\TrainerTimeSlot;
use App\Models\User;
use App\Policies\FinancialTransaction\FinancialTransactionPolicy;
use App\Policies\InternalRequests\InternalRequestPolicy;
use App\Policies\Player\PlayerPolicy;
use App\Policies\PlayerGame\PlayerGamePolicy;
use App\Policies\Role\RolePolicy;
use App\Policies\Subscription\SubscriptionPolicy;
use App\Policies\Trainer\TrainerPolicy;
use App\Policies\TrainerTime\TrainerTimeSlotPolicy;
use App\Policies\Users\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

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
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(TrainerTimeSlot::class, TrainerTimeSlotPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(PlayerGame::class, PlayerGamePolicy::class);
        Gate::policy(InternalRequest::class, InternalRequestPolicy::class);
        Gate::policy(FinancialTransaction::class, FinancialTransactionPolicy::class);
    }
}
