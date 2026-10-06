@extends('layout.app')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white">
                لوحة التحكم
            </h1>

            <p class="text-sm mt-1 text-[#BFAEA8]">
                نظرة شاملة على حالة النادي والإيرادات والاشتراكات واللاعبين
            </p>
        </div>

        {{-- Date Filter --}}
        <form method="GET"
              action="{{ route('dashboard') }}"
              class="flex flex-col sm:flex-row gap-2">

            <div>
                <label class="block text-xs mb-1 text-[#BFAEA8]">
                    من تاريخ
                </label>

                <input
                    type="date"
                    name="from"
                    value="{{ $filters['from'] }}"
                    class="dashboard-input"
                >
            </div>

            <div>
                <label class="block text-xs mb-1 text-[#BFAEA8]">
                    إلى تاريخ
                </label>

                <input
                    type="date"
                    name="to"
                    value="{{ $filters['to'] }}"
                    class="dashboard-input"
                >
            </div>

            <div class="flex items-end">
                <button type="submit" class="dashboard-button">
                    <i class="fa-solid fa-filter ml-2"></i>
                    تطبيق
                </button>
            </div>

        </form>

    </div>


    {{-- =========================================================
        MAIN KPI CARDS
    ========================================================== --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Players --}}
        <div class="dashboard-card">
            <div class="dashboard-card-icon orange">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>
                <p class="dashboard-label">
                    إجمالي اللاعبين
                </p>

                <h2 class="dashboard-number">
                    {{ number_format($kpis['total_players']) }}
                </h2>

                <p class="dashboard-sub">
                    +{{ number_format($kpis['new_players']) }}
                    لاعب جديد خلال الفترة
                </p>
            </div>
        </div>


        {{-- Active subscriptions --}}
        <div class="dashboard-card">
            <div class="dashboard-card-icon green">
                <i class="fa-solid fa-id-card"></i>
            </div>

            <div>
                <p class="dashboard-label">
                    الاشتراكات الفعالة
                </p>

                <h2 class="dashboard-number">
                    {{ number_format($kpis['active_subscriptions']) }}
                </h2>

                <p class="dashboard-sub warning">
                    {{ number_format($kpis['expiring_subscriptions']) }}
                    تنتهي خلال 7 أيام
                </p>
            </div>
        </div>


        {{-- Games --}}
        <div class="dashboard-card">
            <div class="dashboard-card-icon blue">
                <i class="fa-solid fa-dumbbell"></i>
            </div>

            <div>
                <p class="dashboard-label">
                    الألعاب
                </p>

                <h2 class="dashboard-number">
                    {{ number_format($kpis['total_games']) }}
                </h2>

                <p class="dashboard-sub">
                    {{ number_format($kpis['total_time_slots']) }}
                    فترة تدريب
                </p>
            </div>
        </div>


        {{-- Trainers --}}
        <div class="dashboard-card">
            <div class="dashboard-card-icon purple">
                <i class="fa-solid fa-person-chalkboard"></i>
            </div>

            <div>
                <p class="dashboard-label">
                    الكادر التدريبي
                </p>

                <p class="dashboard-sub">
                    {{ number_format($kpis['total_trainers']) }}
                    مدرب
                </p>

                <p class="dashboard-sub">
                    {{ number_format($kpis['total_reception']) }}
                    استقبال
                </p>
            </div>
        </div>

    </div>


    {{-- =========================================================
        FINANCIAL KPI
    ========================================================== --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Receipts --}}
        <div class="dashboard-card">
            <div class="dashboard-card-icon green">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>

            <div>
                <p class="dashboard-label">
                    إجمالي المقبوضات
                </p>

                <h2 class="dashboard-number text-green-400">
                    {{ number_format($kpis['receipts_total'], 2) }}
                </h2>

                <p class="dashboard-sub">
                    {{ number_format($kpis['receipts_count']) }}
                    إيصال
                </p>
            </div>
        </div>


        {{-- Financial income --}}
        <div class="dashboard-card">
            <div class="dashboard-card-icon blue">
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>

            <div>
                <p class="dashboard-label">
                    الدخل المالي
                </p>

                <h2 class="dashboard-number text-blue-400">
                    {{ number_format($kpis['financial_income'], 2) }}
                </h2>

                <p class="dashboard-sub">
                    حركات دخل
                </p>
            </div>
        </div>


        {{-- Expenses --}}
        <div class="dashboard-card">
            <div class="dashboard-card-icon red">
                <i class="fa-solid fa-arrow-trend-down"></i>
            </div>

            <div>
                <p class="dashboard-label">
                    المصروفات
                </p>

                <h2 class="dashboard-number text-red-400">
                    {{ number_format($kpis['financial_expense'], 2) }}
                </h2>

                <p class="dashboard-sub">
                    المصروفات المسجلة
                </p>
            </div>
        </div>


        {{-- Net --}}
        <div class="dashboard-card">
            <div class="dashboard-card-icon orange">
                <i class="fa-solid fa-chart-line"></i>
            </div>

            <div>
                <p class="dashboard-label">
                    صافي الحركة المالية
                </p>

                <h2 class="dashboard-number
                    {{ $kpis['net_profit'] >= 0
                        ? 'text-green-400'
                        : 'text-red-400' }}">
                    {{ number_format($kpis['net_profit'], 2) }}
                </h2>

                <p class="dashboard-sub">
                    بعد خصم المصروفات
                </p>
            </div>
        </div>

    </div>


    {{-- =========================================================
        SUBSCRIPTION / REQUEST KPI
    ========================================================== --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="mini-stat">
            <div>
                <span>اشتراكات جديدة</span>
                <strong>{{ number_format($registrationTypes['new']) }}</strong>
            </div>

            <i class="fa-solid fa-user-plus"></i>
        </div>

        <div class="mini-stat">
            <div>
                <span>التجديدات</span>
                <strong>{{ number_format($registrationTypes['renew']) }}</strong>
            </div>

            <i class="fa-solid fa-rotate"></i>
        </div>

        <div class="mini-stat">
            <div>
                <span>اشتراكات منتهية</span>
                <strong>{{ number_format($kpis['expired_subscriptions']) }}</strong>
            </div>

            <i class="fa-solid fa-calendar-xmark"></i>
        </div>

        <div class="mini-stat">
            <div>
                <span>طلبات معلقة</span>
                <strong>{{ number_format($kpis['pending_requests']) }}</strong>
            </div>

            <i class="fa-solid fa-clock"></i>
        </div>

    </div>


    {{-- =========================================================
        FINANCE CHART
    ========================================================== --}}

    <div class="dashboard-panel">

        <div class="dashboard-panel-header">
            <div>
                <h3>
                    <i class="fa-solid fa-chart-line text-[#D46417] ml-2"></i>
                    الحركة المالية
                </h3>

                <p>
                    الدخل والمصروفات وصافي الحركة حسب الفترة
                </p>
            </div>
        </div>

        <div class="chart-wrapper">
            <canvas id="financeChart"></canvas>
        </div>

    </div>


    {{-- =========================================================
        PLAYERS + SUBSCRIPTIONS
    ========================================================== --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Players trend --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">
                <div>
                    <h3>
                        <i class="fa-solid fa-users text-[#D46417] ml-2"></i>
                        نمو اللاعبين
                    </h3>

                    <p>
                        عدد اللاعبين الجدد خلال الفترة
                    </p>
                </div>
            </div>

            <div class="chart-wrapper">
                <canvas id="playersChart"></canvas>
            </div>

        </div>


        {{-- Subscription status --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">
                <div>
                    <h3>
                        <i class="fa-solid fa-id-card text-[#D46417] ml-2"></i>
                        حالة الاشتراكات
                    </h3>

                    <p>
                        الفعالة والمنتهية
                    </p>
                </div>
            </div>

            <div class="chart-wrapper small">
                <canvas id="subscriptionStatusChart"></canvas>
            </div>

        </div>

    </div>


    {{-- =========================================================
        SUBSCRIPTION TYPES + REGISTRATION TYPES
    ========================================================== --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Subscription types --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">
                <div>
                    <h3>
                        <i class="fa-solid fa-layer-group text-[#D46417] ml-2"></i>
                        أنواع الاشتراكات
                    </h3>

                    <p>
                        توزيع الاشتراكات حسب النوع
                    </p>
                </div>
            </div>

            <div class="chart-wrapper small">
                <canvas id="subscriptionTypesChart"></canvas>
            </div>

        </div>


        {{-- Registration types --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">
                <div>
                    <h3>
                        <i class="fa-solid fa-user-check text-[#D46417] ml-2"></i>
                        تسجيلات وتجديدات
                    </h3>

                    <p>
                        مقارنة الاشتراكات الجديدة مع التجديد
                    </p>
                </div>
            </div>

            <div class="chart-wrapper small">
                <canvas id="registrationChart"></canvas>
            </div>

        </div>

    </div>


    {{-- =========================================================
        PLAYERS GENDER
    ========================================================== --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="dashboard-panel lg:col-span-1">

            <div class="dashboard-panel-header">
                <div>
                    <h3>
                        <i class="fa-solid fa-venus-mars text-[#D46417] ml-2"></i>
                        توزيع اللاعبين
                    </h3>

                    <p>
                        حسب الجنس
                    </p>
                </div>
            </div>

            <div class="chart-wrapper small">
                <canvas id="genderChart"></canvas>
            </div>

        </div>


        {{-- Quick stats --}}
        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="info-card">
                <div class="info-icon">
                    <i class="fa-solid fa-person"></i>
                </div>

                <div>
                    <span>اللاعبون الذكور</span>
                    <strong>{{ number_format($players['male']) }}</strong>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">
                    <i class="fa-solid fa-person-dress"></i>
                </div>

                <div>
                    <span>اللاعبات الإناث</span>
                    <strong>{{ number_format($players['female']) }}</strong>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>

                <div>
                    <span>إجمالي الاشتراكات</span>
                    <strong>{{ number_format($kpis['subscriptions_count']) }}</strong>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>

                <div>
                    <span>قيمة الاشتراكات</span>
                    <strong>
                        {{ number_format($kpis['subscription_revenue'], 2) }}
                    </strong>
                </div>
            </div>

        </div>

    </div>


    {{-- =========================================================
        POPULAR GAMES
    ========================================================== --}}

    <div class="dashboard-panel">

        <div class="dashboard-panel-header">

            <div>
                <h3>
                    <i class="fa-solid fa-ranking-star text-[#D46417] ml-2"></i>
                    أكثر الألعاب شعبية
                </h3>

                <p>
                    الألعاب حسب عدد اللاعبين المسجلين
                </p>
            </div>

            <span class="panel-badge">
                {{ $popularGames->count() }} ألعاب
            </span>

        </div>

        <div class="overflow-x-auto">

            <table class="dashboard-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>اللعبة</th>
                        <th>عدد اللاعبين</th>
                        <th>النسبة</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($popularGames as $index => $game)

                    @php
                        $percentage = $kpis['total_players'] > 0
                            ? ($game->players_count / $kpis['total_players']) * 100
                            : 0;
                    @endphp

                    <tr>

                        <td>
                            <span class="rank-number">
                                {{ $index + 1 }}
                            </span>
                        </td>

                        <td>
                            <div class="table-title">
                                {{ $game->name }}
                            </div>
                        </td>

                        <td>
                            {{ number_format($game->players_count) }}
                        </td>

                        <td class="min-w-[180px]">

                            <div class="flex items-center gap-3">

                                <div class="progress">
                                    <span style="width: {{ min($percentage, 100) }}%"></span>
                                </div>

                                <small>
                                    {{ number_format($percentage, 1) }}%
                                </small>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="empty-row">
                            لا توجد ألعاب حتى الآن
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
        TIME SLOTS
    ========================================================== --}}

    <div class="dashboard-panel">

        <div class="dashboard-panel-header">

            <div>
                <h3>
                    <i class="fa-solid fa-clock text-[#D46417] ml-2"></i>
                    الفترات التدريبية
                </h3>

                <p>
                    الألعاب المتاحة ضمن كل فترة
                </p>
            </div>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

            @forelse($timeSlotsStats as $slot)

                <div class="slot-card">

                    <div class="flex items-center justify-between">

                        <div class="slot-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>

                        <span class="slot-gender
                            {{ $slot->gender_type === 'women_only'
                                ? 'women'
                                : 'mixed' }}">
                            {{ $slot->gender_type === 'women_only'
                                ? 'نساء'
                                : 'مختلط' }}
                        </span>

                    </div>

                    <h4>
                        {{ $slot->name }}
                    </h4>

                    <div class="slot-time">

                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}

                        <span>إلى</span>

                        {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}

                    </div>

                    <div class="slot-games">

                        <i class="fa-solid fa-dumbbell"></i>

                        {{ $slot->games_count }}

                        {{ $slot->games_count == 1 ? 'لعبة' : 'ألعاب' }}

                    </div>

                </div>

            @empty

                <div class="empty-box">
                    لا توجد فترات تدريبية
                </div>

            @endforelse

        </div>

    </div>


    {{-- =========================================================
        TRAINERS
    ========================================================== --}}

    <div class="dashboard-panel">

        <div class="dashboard-panel-header">

            <div>
                <h3>
                    <i class="fa-solid fa-person-chalkboard text-[#D46417] ml-2"></i>
                    المدربون
                </h3>

                <p>
                    توزيع الألعاب والفترات على المدربين
                </p>
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="dashboard-table">

                <thead>
                    <tr>
                        <th>المدرب</th>
                        <th>عدد التعيينات</th>
                        <th>الألعاب والفترات</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($trainersStats as $trainer)

                    <tr>

                        <td>

                            <div class="flex items-center gap-3">

                                <div class="avatar">
                                    {{ mb_substr(
                                        $trainer->user?->fullname ?? 'م',
                                        0,
                                        1
                                    ) }}
                                </div>

                                <div>

                                    <div class="table-title">
                                        {{ $trainer->user?->fullname ?? 'غير معروف' }}
                                    </div>

                                    <small class="text-[#BFAEA8]">
                                        {{ $trainer->user?->username ?? '' }}
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>
                            <span class="count-badge">
                                {{ $trainer->trainer_game_time_slots_count }}
                            </span>
                        </td>

                        <td>

                            <div class="flex flex-wrap gap-2">

                                @foreach($trainer->trainerGameTimeSlots->take(5) as $assignment)

                                    <span class="assignment-badge">

                                        {{ $assignment->game?->name }}

                                        <small>
                                            {{ $assignment->timeSlot?->name }}
                                        </small>

                                    </span>

                                @endforeach

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3" class="empty-row">
                            لا يوجد مدربون
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
        INTERNAL REQUESTS
    ========================================================== --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <div class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>
                    <h3>
                        <i class="fa-solid fa-list-check text-[#D46417] ml-2"></i>
                        الطلبات الداخلية
                    </h3>

                    <p>
                        حالة طلبات الشراء والصيانة
                    </p>
                </div>

            </div>

            <div class="chart-wrapper small">
                <canvas id="requestsChart"></canvas>
            </div>

        </div>


        {{-- Salary --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>
                    <h3>
                        <i class="fa-solid fa-money-check-dollar text-[#D46417] ml-2"></i>
                        نظام الرواتب
                    </h3>

                    <p>
                        ملخص رواتب الموظفين
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="salary-box">

                    <span>
                        الرواتب الثابتة
                    </span>

                    <strong>
                        {{ number_format($salaryStats['fixed_total'], 2) }}
                    </strong>

                    <small>
                        {{ $salaryStats['fixed_staff'] }}
                        موظف
                    </small>

                </div>

                <div class="salary-box">

                    <span>
                        نظام النسبة
                    </span>

                    <strong>
                        {{ number_format($salaryStats['percentage_staff']) }}
                    </strong>

                    <small>
                        موظف
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        LATEST PLAYERS
    ========================================================== --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <div class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>
                    <h3>
                        <i class="fa-solid fa-user-plus text-[#D46417] ml-2"></i>
                        آخر اللاعبين
                    </h3>

                    <p>
                        آخر الحسابات المضافة
                    </p>
                </div>

            </div>

            <div class="space-y-3">

                @forelse($latestPlayers as $player)

                    <div class="activity-item">

                        <div class="avatar">
                            {{ mb_substr(
                                $player->user?->fullname ?? 'م',
                                0,
                                1
                            ) }}
                        </div>

                        <div class="flex-1 min-w-0">

                            <div class="font-semibold text-white truncate">
                                {{ $player->user?->fullname ?? 'غير معروف' }}
                            </div>

                            <div class="text-xs text-[#BFAEA8]">
                                {{ $player->unique_number }}
                            </div>

                        </div>

                        <div class="text-xs text-[#BFAEA8]">
                            {{ $player->created_at?->diffForHumans() }}
                        </div>

                    </div>

                @empty

                    <div class="empty-box">
                        لا يوجد لاعبين
                    </div>

                @endforelse

            </div>

        </div>


        {{-- Latest subscriptions --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>
                    <h3>
                        <i class="fa-solid fa-id-card text-[#D46417] ml-2"></i>
                        آخر الاشتراكات
                    </h3>

                    <p>
                        آخر الاشتراكات المسجلة
                    </p>
                </div>

            </div>

            <div class="space-y-3">

                @forelse($latestSubscriptions as $subscription)

                    <div class="activity-item">

                        <div class="activity-icon">
                            <i class="fa-solid fa-id-card"></i>
                        </div>

                        <div class="flex-1 min-w-0">

                            <div class="font-semibold text-white truncate">
                                {{ $subscription->player?->user?->fullname ?? 'غير معروف' }}
                            </div>

                            <div class="text-xs text-[#BFAEA8]">

                                @switch($subscription->sub_type)

                                    @case('monthly')
                                        شهري
                                        @break

                                    @case('daily')
                                        يومي
                                        @break

                                    @case('offers')
                                        عروض
                                        @break

                                    @case('special')
                                        خاص
                                        @break

                                    @default
                                        {{ $subscription->sub_type }}

                                @endswitch

                            </div>

                        </div>

                        <div class="text-left">

                            <div class="font-bold text-[#D46417]">
                                {{ number_format($subscription->amount, 2) }}
                            </div>

                            <div class="text-xs text-[#BFAEA8]">
                                {{ $subscription->status === 'active'
                                    ? 'فعال'
                                    : 'منتهي' }}
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="empty-box">
                        لا توجد اشتراكات
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- =========================================================
        LATEST RECEIPTS + TRANSACTIONS
    ========================================================== --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Receipts --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>
                    <h3>
                        <i class="fa-solid fa-receipt text-[#D46417] ml-2"></i>
                        آخر الإيصالات
                    </h3>

                    <p>
                        آخر عمليات الدفع
                    </p>
                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="dashboard-table">

                    <thead>
                        <tr>
                            <th>اللاعب</th>
                            <th>اللعبة</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($latestReceipts as $receipt)

                        <tr>

                            <td>
                                {{ $receipt->player?->user?->fullname ?? 'غير معروف' }}
                            </td>

                            <td>
                                {{ $receipt->game?->name ?? '-' }}
                            </td>

                            <td>
                                <span class="amount-green">
                                    {{ number_format($receipt->amount, 2) }}
                                </span>
                            </td>

                            <td>
                                {{ $receipt->payment_date
                                    ? \Carbon\Carbon::parse($receipt->payment_date)->format('Y-m-d')
                                    : '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="empty-row">
                                لا توجد إيصالات
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Transactions --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">

                <div>
                    <h3>
                        <i class="fa-solid fa-money-bill-transfer text-[#D46417] ml-2"></i>
                        آخر الحركات المالية
                    </h3>

                    <p>
                        آخر العمليات المالية
                    </p>
                </div>

            </div>

            <div class="space-y-3">

                @forelse($latestTransactions as $transaction)

                    <div class="activity-item">

                        <div class="
                            transaction-icon
                            {{ $transaction->transaction_type === 'income'
                                ? 'income'
                                : 'expense' }}
                        ">

                            <i class="
                                fa-solid
                                {{ $transaction->transaction_type === 'income'
                                    ? 'fa-arrow-down'
                                    : 'fa-arrow-up' }}
                            "></i>

                        </div>

                        <div class="flex-1 min-w-0">

                            <div class="font-semibold text-white truncate">
                                {{ $transaction->description }}
                            </div>

                            <div class="text-xs text-[#BFAEA8]">
                                {{ $transaction->approver?->fullname ?? '-' }}
                            </div>

                        </div>

                        <div class="
                            font-bold
                            {{ $transaction->transaction_type === 'income'
                                ? 'text-green-400'
                                : 'text-red-400' }}
                        ">

                            {{ $transaction->transaction_type === 'income'
                                ? '+'
                                : '-' }}

                            {{ number_format($transaction->amount, 2) }}

                        </div>

                    </div>

                @empty

                    <div class="empty-box">
                        لا توجد حركات مالية
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- =========================================================
        INTERNAL REQUESTS TABLE
    ========================================================== --}}

    <div class="dashboard-panel">

        <div class="dashboard-panel-header">

            <div>
                <h3>
                    <i class="fa-solid fa-screwdriver-wrench text-[#D46417] ml-2"></i>
                    آخر الطلبات الداخلية
                </h3>

                <p>
                    آخر طلبات الشراء والصيانة
                </p>
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="dashboard-table">

                <thead>
                    <tr>
                        <th>الموظف</th>
                        <th>التفاصيل</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($latestRequests as $request)

                    <tr>

                        <td>
                            {{ $request->requester?->fullname ?? 'غير معروف' }}
                        </td>

                        <td class="max-w-[350px]">
                            <div class="truncate">
                                {{ $request->details }}
                            </div>
                        </td>

                        <td>

                            @php
                                $statusClasses = [
                                    'pending' => 'pending',
                                    'approved' => 'approved',
                                    'rejected' => 'rejected',
                                    'postponed' => 'postponed',
                                ];

                                $statusLabels = [
                                    'pending' => 'معلق',
                                    'approved' => 'مقبول',
                                    'rejected' => 'مرفوض',
                                    'postponed' => 'مؤجل',
                                ];
                            @endphp

                            <span class="status-badge {{ $statusClasses[$request->status] ?? 'pending' }}">
                                {{ $statusLabels[$request->status] ?? $request->status }}
                            </span>

                        </td>

                        <td>
                            {{ $request->created_at?->format('Y-m-d') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="empty-row">
                            لا توجد طلبات داخلية
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


{{-- =============================================================
    STYLES
============================================================= --}}

@push('styles')

<style>

    .dashboard-card {
        background: linear-gradient(
            145deg,
            rgba(255,255,255,.055),
            rgba(255,255,255,.02)
        );

        border: 1px solid rgba(255,255,255,.07);
        border-radius: 18px;

        padding: 20px;

        display: flex;
        align-items: center;
        gap: 16px;

        transition:
            transform .2s ease,
            border-color .2s ease,
            box-shadow .2s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        border-color: rgba(212,100,23,.4);
        box-shadow: 0 10px 30px rgba(0,0,0,.18);
    }


    .dashboard-card-icon {
        width: 54px;
        height: 54px;

        flex-shrink: 0;

        border-radius: 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 21px;
    }

    .dashboard-card-icon.orange {
        color: #D46417;
        background: rgba(212,100,23,.12);
    }

    .dashboard-card-icon.green {
        color: #22c55e;
        background: rgba(34,197,94,.12);
    }

    .dashboard-card-icon.blue {
        color: #3b82f6;
        background: rgba(59,130,246,.12);
    }

    .dashboard-card-icon.purple {
        color: #a855f7;
        background: rgba(168,85,247,.12);
    }

    .dashboard-card-icon.red {
        color: #ef4444;
        background: rgba(239,68,68,.12);
    }


    .dashboard-label {
        color: #BFAEA8;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .dashboard-number {
        color: white;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.2;
    }

    .dashboard-sub {
        color: #81736f;
        font-size: 11px;
        margin-top: 5px;
    }

    .dashboard-sub.warning {
        color: #f59e0b;
    }


    .dashboard-input {
        background: #101010;
        border: 1px solid rgba(255,255,255,.08);
        color: #BFAEA8;

        border-radius: 10px;
        padding: 9px 12px;

        outline: none;
        min-width: 145px;
    }

    .dashboard-input:focus {
        border-color: #D46417;
        box-shadow: 0 0 0 3px rgba(212,100,23,.10);
    }


    .dashboard-button {
        background: #D46417;
        color: white;

        border: 0;
        border-radius: 10px;

        padding: 10px 18px;

        font-weight: 700;
        cursor: pointer;

        transition: .2s;
    }

    .dashboard-button:hover {
        background: #b95413;
        transform: translateY(-1px);
    }


    .mini-stat {
        background: rgba(255,255,255,.025);
        border: 1px solid rgba(255,255,255,.06);

        border-radius: 14px;
        padding: 16px;

        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .mini-stat span {
        display: block;
        color: #BFAEA8;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .mini-stat strong {
        display: block;
        color: white;
        font-size: 21px;
    }

    .mini-stat > i {
        color: #D46417;
        font-size: 20px;
    }


    .dashboard-panel {
        background: rgba(255,255,255,.025);

        border: 1px solid rgba(255,255,255,.07);

        border-radius: 18px;

        overflow: hidden;
    }


    .dashboard-panel-header {
        padding: 20px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        border-bottom: 1px solid rgba(255,255,255,.05);
    }

    .dashboard-panel-header h3 {
        color: white;
        font-size: 16px;
        font-weight: 800;
    }

    .dashboard-panel-header p {
        color: #81736f;
        font-size: 12px;
        margin-top: 5px;
    }


    .chart-wrapper {
        height: 330px;
        padding: 20px;
    }

    .chart-wrapper.small {
        height: 300px;
    }


    .panel-badge {
        background: rgba(212,100,23,.12);
        color: #D46417;

        border: 1px solid rgba(212,100,23,.25);

        padding: 5px 10px;
        border-radius: 999px;

        font-size: 11px;
        font-weight: 700;
    }


    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-table th {
        color: #81736f;
        font-size: 11px;
        font-weight: 600;

        text-align: right;

        padding: 13px 18px;

        background: rgba(0,0,0,.15);
    }

    .dashboard-table td {
        color: #d8d0cd;

        font-size: 13px;

        padding: 15px 18px;

        border-top: 1px solid rgba(255,255,255,.045);
    }

    .dashboard-table tbody tr {
        transition: background .2s;
    }

    .dashboard-table tbody tr:hover {
        background: rgba(255,255,255,.025);
    }


    .table-title {
        color: white;
        font-weight: 700;
    }


    .rank-number {
        width: 30px;
        height: 30px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background: rgba(212,100,23,.10);
        color: #D46417;

        font-weight: 800;
    }


    .progress {
        flex: 1;
        height: 6px;

        background: rgba(255,255,255,.06);

        border-radius: 999px;

        overflow: hidden;
    }

    .progress span {
        display: block;
        height: 100%;

        background: #D46417;

        border-radius: inherit;
    }


    .slot-card {
        padding: 17px;

        border-radius: 15px;

        background: rgba(255,255,255,.025);
        border: 1px solid rgba(255,255,255,.06);
    }

    .slot-icon {
        width: 38px;
        height: 38px;

        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(212,100,23,.10);
        color: #D46417;
    }

    .slot-card h4 {
        color: white;
        font-weight: 800;
        margin-top: 15px;
    }

    .slot-time {
        color: #BFAEA8;
        font-size: 13px;
        margin-top: 7px;
    }

    .slot-time span {
        color: #625956;
        margin: 0 5px;
    }

    .slot-games {
        color: #D46417;
        font-size: 12px;
        margin-top: 13px;
    }

    .slot-gender {
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 10px;
    }

    .slot-gender.women {
        color: #f472b6;
        background: rgba(244,114,182,.10);
    }

    .slot-gender.mixed {
        color: #60a5fa;
        background: rgba(96,165,250,.10);
    }


    .info-card {
        background: rgba(255,255,255,.025);
        border: 1px solid rgba(255,255,255,.06);

        border-radius: 15px;
        padding: 20px;

        display: flex;
        align-items: center;
        gap: 15px;
    }

    .info-icon {
        width: 45px;
        height: 45px;

        border-radius: 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(212,100,23,.10);
        color: #D46417;
    }

    .info-card span {
        display: block;
        color: #BFAEA8;
        font-size: 12px;
    }

    .info-card strong {
        display: block;
        color: white;
        font-size: 23px;
        margin-top: 4px;
    }


    .avatar {
        width: 38px;
        height: 38px;

        flex-shrink: 0;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(212,100,23,.15);
        color: #D46417;

        font-weight: 800;
    }


    .activity-item {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 12px;

        border-radius: 12px;

        background: rgba(255,255,255,.02);
        border: 1px solid rgba(255,255,255,.04);
    }


    .activity-icon {
        width: 38px;
        height: 38px;

        flex-shrink: 0;

        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(212,100,23,.10);
        color: #D46417;
    }


    .transaction-icon {
        width: 38px;
        height: 38px;

        flex-shrink: 0;

        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .transaction-icon.income {
        color: #22c55e;
        background: rgba(34,197,94,.10);
    }

    .transaction-icon.expense {
        color: #ef4444;
        background: rgba(239,68,68,.10);
    }


    .count-badge {
        display: inline-flex;

        min-width: 30px;
        height: 30px;

        align-items: center;
        justify-content: center;

        border-radius: 9px;

        color: #D46417;
        background: rgba(212,100,23,.10);

        font-weight: 800;
    }


    .assignment-badge {
        display: inline-flex;
        flex-direction: column;

        padding: 5px 9px;

        border-radius: 8px;

        background: rgba(255,255,255,.04);

        color: #ddd5d2;

        font-size: 11px;
    }

    .assignment-badge small {
        color: #81736f;
        margin-top: 2px;
    }


    .amount-green {
        color: #22c55e;
        font-weight: 800;
    }


    .status-badge {
        display: inline-flex;

        padding: 5px 10px;

        border-radius: 999px;

        font-size: 10px;
        font-weight: 700;
    }

    .status-badge.pending {
        color: #f59e0b;
        background: rgba(245,158,11,.10);
    }

    .status-badge.approved {
        color: #22c55e;
        background: rgba(34,197,94,.10);
    }

    .status-badge.rejected {
        color: #ef4444;
        background: rgba(239,68,68,.10);
    }

    .status-badge.postponed {
        color: #60a5fa;
        background: rgba(96,165,250,.10);
    }


    .salary-box {
        padding: 22px;

        border-radius: 14px;

        background: rgba(255,255,255,.025);
        border: 1px solid rgba(255,255,255,.06);
    }

    .salary-box span {
        display: block;
        color: #BFAEA8;
        font-size: 12px;
    }

    .salary-box strong {
        display: block;
        color: #D46417;
        font-size: 25px;
        margin-top: 8px;
    }

    .salary-box small {
        display: block;
        color: #81736f;
        margin-top: 4px;
    }


    .empty-row {
        text-align: center !important;
        color: #81736f !important;
        padding: 30px !important;
    }

    .empty-box {
        padding: 35px;
        text-align: center;
        color: #81736f;
        font-size: 13px;
    }


    @media (max-width: 640px) {

        .dashboard-card {
            padding: 15px;
        }

        .dashboard-card-icon {
            width: 46px;
            height: 46px;
        }

        .dashboard-number {
            font-size: 21px;
        }

        .chart-wrapper {
            height: 270px;
            padding: 12px;
        }

        .chart-wrapper.small {
            height: 260px;
        }

        .dashboard-panel-header {
            padding: 15px;
        }

        .dashboard-table th,
        .dashboard-table td {
            padding: 11px 12px;
            white-space: nowrap;
        }

    }

</style>

@endpush


{{-- =============================================================
    SCRIPTS
============================================================= --}}

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Global Chart Settings
    |--------------------------------------------------------------------------
    */

    Chart.defaults.color = '#BFAEA8';

    Chart.defaults.font.family =
        "'Cairo', 'Tahoma', sans-serif";


    const orange = '#D46417';
    const green = '#22c55e';
    const red = '#ef4444';
    const blue = '#3b82f6';
    const purple = '#a855f7';
    const pink = '#ec4899';

    const gridColor =
        'rgba(255,255,255,0.06)';


    /*
    |--------------------------------------------------------------------------
    | Finance Chart
    |--------------------------------------------------------------------------
    */

    const financeData = @json($financeTrend);

    const financeLabels = financeData.map(item => item.label);

    const financeIncome = financeData.map(item => item.income);

    const financeExpense = financeData.map(item => item.expense);

    const financeNet = financeData.map(item => item.net);


    new Chart(
        document.getElementById('financeChart'),
        {
            type: 'line',

            data: {
                labels: financeLabels,

                datasets: [

                    {
                        label: 'الدخل',
                        data: financeIncome,

                        borderColor: green,
                        backgroundColor: 'rgba(34,197,94,.08)',

                        fill: true,

                        tension: .4,

                        pointRadius: 3,
                        pointHoverRadius: 6
                    },

                    {
                        label: 'المصروفات',
                        data: financeExpense,

                        borderColor: red,
                        backgroundColor: 'rgba(239,68,68,.06)',

                        fill: true,

                        tension: .4,

                        pointRadius: 3,
                        pointHoverRadius: 6
                    },

                    {
                        label: 'الصافي',
                        data: financeNet,

                        borderColor: orange,

                        backgroundColor: 'transparent',

                        borderWidth: 3,

                        tension: .4,

                        pointRadius: 3,
                        pointHoverRadius: 6
                    }

                ]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {
                    legend: {
                        position: 'top',
                        rtl: true,
                        labels: {
                            usePointStyle: true,
                            padding: 18
                        }
                    }
                },

                scales: {

                    y: {
                        beginAtZero: true,

                        grid: {
                            color: gridColor
                        },

                        ticks: {
                            callback: value =>
                                Number(value).toLocaleString()
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }

                }

            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Players Chart
    |--------------------------------------------------------------------------
    */

    const playersData = @json($playersTrend);

    new Chart(
        document.getElementById('playersChart'),
        {
            type: 'line',

            data: {

                labels: playersData.map(
                    item => item.label
                ),

                datasets: [

                    {
                        label: 'اللاعبون الجدد',

                        data: playersData.map(
                            item => item.total
                        ),

                        borderColor: orange,

                        backgroundColor:
                            'rgba(212,100,23,.12)',

                        fill: true,

                        tension: .4,

                        borderWidth: 3,

                        pointRadius: 4
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: gridColor
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }

                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Subscription Status
    |--------------------------------------------------------------------------
    */

    new Chart(
        document.getElementById('subscriptionStatusChart'),
        {
            type: 'doughnut',

            data: {

                labels: [
                    'فعالة',
                    'منتهية'
                ],

                datasets: [

                    {
                        data: [
                            {{ $subscriptionStats['active'] }},
                            {{ $subscriptionStats['expired'] }}
                        ],

                        backgroundColor: [
                            green,
                            red
                        ],

                        borderWidth: 0
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '68%',

                plugins: {

                    legend: {
                        position: 'bottom',
                        rtl: true,
                        labels: {
                            usePointStyle: true,
                            padding: 18
                        }
                    }

                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Subscription Types
    |--------------------------------------------------------------------------
    */

    const subscriptionTypes =
        @json($subscriptionTypes);

    new Chart(
        document.getElementById('subscriptionTypesChart'),
        {
            type: 'doughnut',

            data: {

                labels: subscriptionTypes.map(
                    item => item.label
                ),

                datasets: [

                    {
                        data: subscriptionTypes.map(
                            item => item.total
                        ),

                        backgroundColor: [
                            orange,
                            blue,
                            green,
                            purple
                        ],

                        borderWidth: 0
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '62%',

                plugins: {

                    legend: {
                        position: 'bottom',
                        rtl: true,
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    }

                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Registration Types
    |--------------------------------------------------------------------------
    */

    new Chart(
        document.getElementById('registrationChart'),
        {
            type: 'bar',

            data: {

                labels: [
                    'اشتراكات جديدة',
                    'تجديدات'
                ],

                datasets: [

                    {
                        label: 'العدد',

                        data: [
                            {{ $registrationTypes['new'] }},
                            {{ $registrationTypes['renew'] }}
                        ],

                        backgroundColor: [
                            orange,
                            blue
                        ],

                        borderRadius: 8,

                        maxBarThickness: 55
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: gridColor
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }

                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Gender Chart
    |--------------------------------------------------------------------------
    */

    new Chart(
        document.getElementById('genderChart'),
        {
            type: 'doughnut',

            data: {

                labels: [
                    'ذكور',
                    'إناث'
                ],

                datasets: [

                    {
                        data: [
                            {{ $players['male'] }},
                            {{ $players['female'] }}
                        ],

                        backgroundColor: [
                            blue,
                            pink
                        ],

                        borderWidth: 0
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '65%',

                plugins: {

                    legend: {
                        position: 'bottom',
                        rtl: true,
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    }

                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Internal Requests
    |--------------------------------------------------------------------------
    */

    new Chart(
        document.getElementById('requestsChart'),
        {
            type: 'bar',

            data: {

                labels: [
                    'معلقة',
                    'مقبولة',
                    'مرفوضة',
                    'مؤجلة'
                ],

                datasets: [

                    {
                        label: 'الطلبات',

                        data: [
                            {{ $requestStats['pending'] }},
                            {{ $requestStats['approved'] }},
                            {{ $requestStats['rejected'] }},
                            {{ $requestStats['postponed'] }}
                        ],

                        backgroundColor: [
                            '#f59e0b',
                            green,
                            red,
                            blue
                        ],

                        borderRadius: 8,

                        maxBarThickness: 55
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        grid: {
                            color: gridColor
                        }

                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }

                }

            }

        }
    );

});

</script>

@endpush