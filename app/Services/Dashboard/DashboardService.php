<?php

namespace App\Services\Dashboard;

use App\Models\FinancialTransaction;
use App\Models\Game;
use App\Models\InternalRequest;
use App\Models\Player;
use App\Models\Receipt;
use App\Models\Staff;
use App\Models\Subscription;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * جلب جميع بيانات لوحة التحكم.
     */
    public function getDashboardData(
        ?string $from = null,
        ?string $to = null
    ): array {
        $fromDate = $from
            ? Carbon::parse($from)->startOfDay()
            : now()->startOfMonth();

        $toDate = $to
            ? Carbon::parse($to)->endOfDay()
            : now()->endOfDay();

        /*
        |--------------------------------------------------------------------------
        | Basic Counts
        |--------------------------------------------------------------------------
        */

        $totalPlayers = Player::count();

        $totalGames = Game::count();

        $totalTimeSlots = TimeSlot::count();

        $totalTrainers = Staff::query()
            ->where('role', 'trainer')
            ->count();

        $totalReception = Staff::query()
            ->where('role', 'reception')
            ->count();

        $totalStaff = Staff::count();

        /*
        |--------------------------------------------------------------------------
        | Players
        |--------------------------------------------------------------------------
        */

        $newPlayers = Player::query()
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->count();

        $malePlayers = Player::query()
            ->where('gender', 'male')
            ->count();

        $femalePlayers = Player::query()
            ->where('gender', 'female')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Subscriptions
        |--------------------------------------------------------------------------
        */

        $activeSubscriptions = Subscription::query()
            ->where('status', 'active')
            ->count();

        $expiredSubscriptions = Subscription::query()
            ->where('status', 'expired')
            ->count();

        $newSubscriptions = Subscription::query()
            ->where('registration_type', 'new')
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->count();

        $renewedSubscriptions = Subscription::query()
            ->where('registration_type', 'renew')
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->count();

        $subscriptionsCount = Subscription::query()
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Subscriptions Expiring Soon
        |--------------------------------------------------------------------------
        */

        $expiringSubscriptions = Subscription::query()
            ->where('status', 'active')
            ->whereBetween('end_date', [
                now()->startOfDay()->toDateString(),
                now()->addDays(7)->endOfDay()->toDateString(),
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Subscription Revenue
        |--------------------------------------------------------------------------
        */

        $subscriptionRevenue = Subscription::query()
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Receipts
        |--------------------------------------------------------------------------
        */

        $receiptsTotal = Receipt::query()
            ->whereBetween('payment_date', [
                $fromDate,
                $toDate,
            ])
            ->sum('amount');

        $receiptsCount = Receipt::query()
            ->whereBetween('payment_date', [
                $fromDate,
                $toDate,
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Financial Transactions
        |--------------------------------------------------------------------------
        */

        $financialIncome = FinancialTransaction::query()
            ->where('transaction_type', 'income')
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->sum('amount');

        $financialExpense = FinancialTransaction::query()
            ->where('transaction_type', 'expense')
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->sum('amount');

        $financialNet = $financialIncome - $financialExpense;

        /*
        |--------------------------------------------------------------------------
        | Total Cash Flow
        |--------------------------------------------------------------------------
        |
        | receipts = payments related to subscriptions/games
        | financial_transactions = other financial movements
        |
        */

        $totalIncome = $receiptsTotal + $financialIncome;

        $totalExpense = $financialExpense;

        $netProfit = $totalIncome - $totalExpense;

        /*
        |--------------------------------------------------------------------------
        | Internal Requests
        |--------------------------------------------------------------------------
        */

        $pendingRequests = InternalRequest::query()
            ->where('status', 'pending')
            ->count();

        $approvedRequests = InternalRequest::query()
            ->where('status', 'approved')
            ->count();

        $rejectedRequests = InternalRequest::query()
            ->where('status', 'rejected')
            ->count();

        $postponedRequests = InternalRequest::query()
            ->where('status', 'postponed')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Response
        |--------------------------------------------------------------------------
        */

        return [
            /*
            |--------------------------------------------------------------------------
            | KPI
            |--------------------------------------------------------------------------
            */

            'kpis' => [
                'total_players' => $totalPlayers,
                'new_players' => $newPlayers,

                'active_subscriptions' => $activeSubscriptions,
                'expired_subscriptions' => $expiredSubscriptions,
                'expiring_subscriptions' => $expiringSubscriptions,

                'total_games' => $totalGames,
                'total_time_slots' => $totalTimeSlots,

                'total_trainers' => $totalTrainers,
                'total_reception' => $totalReception,
                'total_staff' => $totalStaff,

                'subscription_revenue' => $subscriptionRevenue,

                'receipts_total' => $receiptsTotal,
                'receipts_count' => $receiptsCount,

                'financial_income' => $financialIncome,
                'financial_expense' => $financialExpense,
                'financial_net' => $financialNet,

                'total_income' => $totalIncome,
                'total_expense' => $totalExpense,
                'net_profit' => $netProfit,

                'subscriptions_count' => $subscriptionsCount,

                'pending_requests' => $pendingRequests,
            ],

            /*
            |--------------------------------------------------------------------------
            | Players
            |--------------------------------------------------------------------------
            */

            'players' => [
                'male' => $malePlayers,
                'female' => $femalePlayers,
                'total' => $totalPlayers,
            ],

            'playersTrend' => $this->getPlayersTrend(
                $fromDate,
                $toDate
            ),

            /*
            |--------------------------------------------------------------------------
            | Subscriptions
            |--------------------------------------------------------------------------
            */

            'subscriptionStats' => [
                'active' => $activeSubscriptions,
                'expired' => $expiredSubscriptions,
            ],

            'subscriptionTypes' => $this->getSubscriptionTypes(
                $fromDate,
                $toDate
            ),

            'registrationTypes' => [
                'new' => $newSubscriptions,
                'renew' => $renewedSubscriptions,
            ],

            /*
            |--------------------------------------------------------------------------
            | Finance
            |--------------------------------------------------------------------------
            */

            'financeTrend' => $this->getFinanceTrend(
                $fromDate,
                $toDate
            ),

            'receiptTrend' => $this->getReceiptTrend(
                $fromDate,
                $toDate
            ),

            /*
            |--------------------------------------------------------------------------
            | Games
            |--------------------------------------------------------------------------
            */

            'popularGames' => $this->getPopularGames(),

            'gamesStats' => $this->getGamesStats(),

            /*
            |--------------------------------------------------------------------------
            | Time Slots
            |--------------------------------------------------------------------------
            */

            'timeSlotsStats' => $this->getTimeSlotsStats(),

            /*
            |--------------------------------------------------------------------------
            | Trainers
            |--------------------------------------------------------------------------
            */

            'trainersStats' => $this->getTrainersStats(),

            /*
            |--------------------------------------------------------------------------
            | Staff
            |--------------------------------------------------------------------------
            */

            'salaryStats' => $this->getSalaryStats(),

            /*
            |--------------------------------------------------------------------------
            | Requests
            |--------------------------------------------------------------------------
            */

            'requestStats' => [
                'pending' => $pendingRequests,
                'approved' => $approvedRequests,
                'rejected' => $rejectedRequests,
                'postponed' => $postponedRequests,
            ],

            /*
            |--------------------------------------------------------------------------
            | Latest Data
            |--------------------------------------------------------------------------
            */

            'latestPlayers' => Player::query()
                ->with('user')
                ->latest()
                ->limit(8)
                ->get(),

            'latestSubscriptions' => Subscription::query()
                ->with('player.user')
                ->latest()
                ->limit(8)
                ->get(),

            'latestReceipts' => Receipt::query()
                ->with([
                    'player.user',
                    'game',
                    'receivedBy',
                ])
                ->latest('payment_date')
                ->limit(8)
                ->get(),

            'latestTransactions' => FinancialTransaction::query()
                ->with('approver')
                ->latest()
                ->limit(8)
                ->get(),

            'latestRequests' => InternalRequest::query()
                ->with('requester')
                ->latest()
                ->limit(8)
                ->get(),

            /*
            |--------------------------------------------------------------------------
            | Filters
            |--------------------------------------------------------------------------
            */

            'filters' => [
                'from' => $fromDate->format('Y-m-d'),
                'to' => $toDate->format('Y-m-d'),
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Players Trend
    |--------------------------------------------------------------------------
    */

    private function getPlayersTrend(
        Carbon $fromDate,
        Carbon $toDate
    ): array {
        $rows = Player::query()
            ->selectRaw('YEAR(created_at) as year')
            ->selectRaw('MONTH(created_at) as month')
            ->selectRaw('COUNT(*) as total')
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->groupBy(
                DB::raw('YEAR(created_at)'),
                DB::raw('MONTH(created_at)')
            )
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return $rows->map(function ($row) {
            return [
                'label' => Carbon::create(
                    $row->year,
                    $row->month,
                    1
                )->translatedFormat('M Y'),

                'total' => (int) $row->total,
            ];
        })->values()->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Finance Trend
    |--------------------------------------------------------------------------
    */

    private function getFinanceTrend(
        Carbon $fromDate,
        Carbon $toDate
    ): array {
        $rows = FinancialTransaction::query()
            ->selectRaw('YEAR(created_at) as year')
            ->selectRaw('MONTH(created_at) as month')
            ->selectRaw("
                SUM(
                    CASE
                        WHEN transaction_type = 'income'
                        THEN amount
                        ELSE 0
                    END
                ) as income
            ")
            ->selectRaw("
                SUM(
                    CASE
                        WHEN transaction_type = 'expense'
                        THEN amount
                        ELSE 0
                    END
                ) as expense
            ")
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->groupBy(
                DB::raw('YEAR(created_at)'),
                DB::raw('MONTH(created_at)')
            )
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return $rows->map(function ($row) {
            $income = (float) $row->income;
            $expense = (float) $row->expense;

            return [
                'label' => Carbon::create(
                    $row->year,
                    $row->month,
                    1
                )->translatedFormat('M Y'),

                'income' => $income,
                'expense' => $expense,
                'net' => $income - $expense,
            ];
        })->values()->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Receipts Trend
    |--------------------------------------------------------------------------
    */

    private function getReceiptTrend(
        Carbon $fromDate,
        Carbon $toDate
    ): array {
        $rows = Receipt::query()
            ->selectRaw('YEAR(payment_date) as year')
            ->selectRaw('MONTH(payment_date) as month')
            ->selectRaw('SUM(amount) as total')
            ->selectRaw('COUNT(*) as count')
            ->whereBetween('payment_date', [
                $fromDate,
                $toDate,
            ])
            ->groupBy(
                DB::raw('YEAR(payment_date)'),
                DB::raw('MONTH(payment_date)')
            )
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return $rows->map(function ($row) {
            return [
                'label' => Carbon::create(
                    $row->year,
                    $row->month,
                    1
                )->translatedFormat('M Y'),

                'total' => (float) $row->total,

                'count' => (int) $row->count,
            ];
        })->values()->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Subscription Types
    |--------------------------------------------------------------------------
    */

    private function getSubscriptionTypes(
        Carbon $fromDate,
        Carbon $toDate
    ): array {
        $labels = [
            'special' => 'خاص',
            'offers' => 'عروض',
            'daily' => 'يومي',
            'monthly' => 'شهري',
        ];

        $rows = Subscription::query()
            ->select('sub_type')
            ->selectRaw('COUNT(*) as total')
            ->whereBetween('created_at', [
                $fromDate,
                $toDate,
            ])
            ->groupBy('sub_type')
            ->get();

        return $rows->map(function ($row) use ($labels) {
            return [
                'type' => $row->sub_type,
                'label' => $labels[$row->sub_type]
                    ?? $row->sub_type,
                'total' => (int) $row->total,
            ];
        })->values()->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Popular Games
    |--------------------------------------------------------------------------
    */

    private function getPopularGames()
    {
        return Game::query()
            ->withCount('players')
            ->orderByDesc('players_count')
            ->limit(10)
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Games Statistics
    |--------------------------------------------------------------------------
    */

    private function getGamesStats()
    {
        return Game::query()
            ->withCount([
                'players',
                'timeSlots',
            ])
            ->with([
                'timeSlots',
            ])
            ->orderByDesc('players_count')
            ->limit(10)
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Time Slots Statistics
    |--------------------------------------------------------------------------
    */

    private function getTimeSlotsStats()
    {
        return TimeSlot::query()
            ->withCount('games')
            ->with('games')
            ->orderBy('start_time')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Trainers Statistics
    |--------------------------------------------------------------------------
    */

    private function getTrainersStats()
    {
        return Staff::query()
            ->where('role', 'trainer')
            ->with([
                'user',
                'trainerGameTimeSlots.game',
                'trainerGameTimeSlots.timeSlot',
            ])
            ->withCount('trainerGameTimeSlots')
            ->orderByDesc('trainer_game_time_slots_count')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Salary Statistics
    |--------------------------------------------------------------------------
    */

    private function getSalaryStats(): array
    {
        $fixedSalary = Staff::query()
            ->where('salary_type', 'fixed')
            ->sum('base_salary');

        $percentageStaff = Staff::query()
            ->where('salary_type', 'percentage')
            ->count();

        $fixedStaff = Staff::query()
            ->where('salary_type', 'fixed')
            ->count();

        return [
            'fixed_total' => (float) $fixedSalary,
            'fixed_staff' => $fixedStaff,
            'percentage_staff' => $percentageStaff,
        ];
    }
}
