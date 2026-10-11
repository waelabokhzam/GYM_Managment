<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'نظام إدارة النادي الرياضي')
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- تطبيق الثيم قبل ظهور الصفحة --}}
    <script>
        (() => {
            const theme = localStorage.getItem('gym-theme');

            if (theme === 'light') {
                document.documentElement.classList.add('light');
            }
        })();
    </script>

    @stack('styles')
    <style>

        /*
        Notification
        */

        /* Notifications Dropdown */
@keyframes notifications-dropdown-enter {
    from {
        opacity: 0;
        transform: translateY(-7px) scale(0.985);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

#notifications-panel.notifications-panel-open {
    animation: notifications-dropdown-enter 180ms ease-out;
}

@media (prefers-reduced-motion: reduce) {
    #notifications-panel.notifications-panel-open {
        animation: none;
    }
}
        /*
    |--------------------------------------------------------------------------
    | Sidebar Scrollbar
    |--------------------------------------------------------------------------
    */

        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 9999px;
            transition: background 0.3s ease;
        }

        .sidebar-scroll:hover {
            scrollbar-color: rgba(212, 100, 23, 0.55) transparent;
        }

        .sidebar-scroll:hover::-webkit-scrollbar-thumb {
            background: rgba(212, 100, 23, 0.55);
        }

        .sidebar-scroll:hover::-webkit-scrollbar-thumb:hover {
            background: #D46417;
        }

        @keyframes notification-enter {
            0% {
                opacity: 0;
                transform: translate(-50%, -20px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translate(-50%, 0) scale(1);
            }
        }

        @keyframes notification-exit {
            0% {
                opacity: 1;
                transform: translate(-50%, 0) scale(1);
            }

            100% {
                opacity: 0;
                transform: translate(-50%, -20px) scale(0.95);
            }
        }

        #success-notification {
            animation:
                notification-enter 0.45s ease-out forwards;
        }

        #success-notification.notification-hide {
            animation:
                notification-exit 0.45s ease-in forwards;
        }
    </style>
</head>

<body class="min-h-screen bg-[var(--color-background)] text-[var(--color-text)]">
    @if (session('success'))
        <div id="success-notification"
            class="
            fixed
            top-5
            left-1/2
            z-[9999]
            flex
            -translate-x-1/2
            items-center
            gap-3
            rounded-2xl
            border
            border-[#D46417]/30
            bg-[var(--color-surface)]
            px-5
            py-3
            text-sm
            font-semibold
            text-[var(--color-text)]
            shadow-2xl
            backdrop-blur-md
            transition-all
            duration-500
        "
            role="alert">

            {{-- Icon --}}

            <div
                class="
                flex
                h-8
                w-8
                shrink-0
                items-center
                justify-center
                rounded-full
                bg-[#D46417]/10
                text-[#D46417]
            ">
                <i class="fa-solid fa-check"></i>
            </div>


            {{-- Message --}}

            <span>
                {{ session('success') }}
            </span>


            {{-- Close Button --}}

            <button type="button" onclick="hideSuccessNotification()"
                class="
                mr-2
                flex
                h-7
                w-7
                items-center
                justify-center
                rounded-lg
                text-[var(--color-text-muted)]
                transition
                hover:bg-red-500/10
                hover:text-red-400
            "
                aria-label="إغلاق">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>

        </div>
    @endif
    <div class="min-h-screen">

        {{-- =====================================================
         SIDEBAR OVERLAY
    ====================================================== --}}

        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black/60 backdrop-blur-sm lg:hidden"></div>


        {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

        <aside id="sidebar"
            class="
            fixed
            inset-y-0
            right-0
            z-50
            flex
            w-72
            translate-x-full
            flex-col
            border-l
            border-[var(--color-border)]
            bg-[var(--color-surface)]
            transition-transform
            duration-300
            lg:translate-x-0
        ">

            {{-- Logo --}}

            <div
                class="
                flex
                h-20
                shrink-0
                items-center
                justify-center
                border-b
                border-[var(--color-border)]
                px-5
            ">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

                    <div
                        class="
                        flex
                        h-11
                        w-11
                        items-center
                        justify-center
                        rounded-xl
                        bg-[#D46417]
                        text-white
                        shadow-lg
                        shadow-[#D46417]/20
                    ">
                        <i class="fa-solid fa-dumbbell"></i>
                    </div>

                    <div class="text-right">

                        <div class="text-lg font-extrabold">
                            GYM
                            <span class="text-[#D46417]">
                                MANAGEMENT
                            </span>
                        </div>

                        <div class="text-[10px] text-[var(--color-text-muted)]">
                            نظام إدارة النادي
                        </div>

                    </div>

                </a>

            </div>


            {{-- Navigation --}}

            <nav class="sidebar-scroll flex-1 overflow-y-auto p-4">

                {{-- الرئيسية --}}

                <div
                    class="
                    mb-2
                    px-3
                    text-[10px]
                    font-bold
                    text-[var(--color-text-muted)]
                ">
                    الرئيسية
                </div>
                @can('')
                    <a href="{{ route('dashboard') }}"
                        class="
                    mb-1
                    flex
                    items-center
                    gap-3
                    rounded-xl
                    px-4
                    py-3
                    text-sm
                    transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                ">

                        <i class="fa-solid fa-chart-line w-5 text-center"></i>

                        <span>
                            لوحة التحكم
                        </span>

                    </a>
                @endcan

                {{-- النادي --}}

                <div
                    class="
                    mb-2
                    mt-6
                    px-3
                    text-[10px]
                    font-bold
                    text-[var(--color-text-muted)]
                ">
                    النادي
                </div>


                @can('players.view')
                    <a href="{{ route('players.index') }}"
                        class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                    {{ request()->routeIs('players.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                    ">
                        <i class="fa-solid fa-users w-5 text-center"></i>
                        <span>اللاعبين</span>
                    </a>
                @endcan


                @can('subscriptions.view')
                    <a href="{{ route('subscriptions.index') }}"
                        class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                        {{ request()->routeIs('subscriptions.*')
                            ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                            : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                    ">
                        <i class="fa-solid fa-id-card w-5 text-center"></i>
                        <span>الاشتراكات</span>
                    </a>
                @endcan


                @can('trainers.view')
                    <a href="{{ route('trainers.index') }}"
                        class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                        {{ request()->routeIs('trainers.*')
                            ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                            : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                    ">
                        <i class="fa-solid fa-person-running w-5 text-center"></i>
                        <span>المدربون</span>
                    </a>
                @endcan
                @can('sports.view')
                    <a href="{{ route('games.index') }}"
                        class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                    {{ request()->routeIs('games.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                    ">
                        <i class="fa-solid fa-dumbbell w-5 text-center"></i>
                        <span>الرياضات</span>
                    </a>
                @endcan

                @can('training_periods.view')
                    <a href="{{ route('timeslots.index') }}"
                        class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                    {{ request()->routeIs('timeslots.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                    ">
                        <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                        <span>الفترات التدريبية</span>
                    </a>
                @endcan

                @can('training_periods.view')
                    <div
                        class="
                            mb-2
                            mt-6
                            px-3
                            text-[10px]
                            font-bold
                            text-[var(--color-text-muted)]
                        ">
                        إدارة الفترات
                    </div>


                    <a href="{{ route('trainer-game-time-slots.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                        {{ request()->routeIs('trainer-game-time-slots.*')
                            ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                            : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}">

                        <i class="fa-solid fa-user-clock w-5 text-center"></i>

                        <span>
                            تعيينات المدربين
                        </span>

                    </a>
                @endcan


                @can('players.view')
                    <div
                        class="
            mb-2
            mt-6
            px-3
            text-[10px]
            font-bold
            text-[var(--color-text-muted)]
        ">
                        إدارة ألعاب اللاعبين
                    </div>

                    <a href="{{ route('player-games.index') }}"
                        class="
            mb-1
            flex
            items-center
            gap-3
            rounded-xl
            px-4
            py-3
            text-sm
            transition
            {{ request()->routeIs('player-games.*')
                ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
        ">
                        <i class="fa-solid fa-dumbbell w-5 text-center"></i>
                        <span>ربط اللاعبين بالألعاب</span>
                    </a>
                @endcan

                @can('payments.view')
                    <a href="{{ route('receipts.index') }}"
                        class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                    {{ request()->routeIs('receipts.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                    ">
                        <i class="fa-solid fa-money-bill-wave w-5 text-center"></i>
                        <span>الدفعات</span>
                    </a>
                @endcan

                @can('attendance.view')
                    <div
                        class="
                            mb-2
                            mt-6
                            px-3
                            text-[10px]
                            font-bold
                            text-[var(--color-text-muted)]
                        ">
                        إدارة الحضور
                    </div>

                    <a href="{{ route('attendances.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                        {{ request()->routeIs('attendances.*')
                            ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                            : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}">

                        <i class="fa-solid fa-fingerprint w-5 text-center"></i>

                        <span>
                            الحضور والانصراف
                        </span>

                    </a>
                @endcan

                @can('internal_requests.view')
                    <div
                        class="
            mb-2
            mt-6
            px-3
            text-[10px]
            font-bold
            text-[var(--color-text-muted)]
        ">
                        الإدارة الداخلية
                    </div>

                    <a href="{{ route('internal-requests.index') }}"
                        class="
            mb-1
            flex
            items-center
            gap-3
            rounded-xl
            px-4
            py-3
            text-sm
            transition
            {{ request()->routeIs('internal-requests.*')
                ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
        ">
                        <i class="fa-solid fa-screwdriver-wrench w-5 text-center"></i>
                        <span>طلبات الشراء والصيانة</span>
                    </a>
                @endcan


                {{-- الملاحظات والشكاوى --}}
                @can('feedback.view')
                    {{-- يمكنك إزالة شرط الـ can إذا لم تكن تستخدم Spatie Permissions للملاحظات --}}
                    <a href="{{ route('feedback.index') }}"
                        class="mb-1 flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition
        {{ request()->routeIs('feedback.*')
            ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
            : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}">

                        <i class="fa-solid fa-comment-dots w-5 text-center"></i>
                        <span>الملاحظات والشكاوى</span>
                    </a>
                @endcan

                @can('financial_transactions.view')
                    <a href="{{ route('financial-transactions.index') }}"
                        class="mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
        {{ request()->routeIs('financial-transactions.*')
            ? 'bg-[#D46417] text-white'
            : 'hover:bg-[var(--color-surface-hover)]' }}">

                        <i class="fa-solid fa-money-bill-transfer w-5 text-center"></i>

                        <span>
                            المعاملات المالية
                        </span>

                    </a>
                @endcan

                {{-- التقارير --}}

                {{-- @can('reports.view')

                <div
                    class="
                        mb-2
                        mt-6
                        px-3
                        text-[10px]
                        font-bold
                        text-[var(--color-text-muted)]
                    "
                >
                    التقارير
                </div>

                <a
                    href="#"
                    class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                    {{ request()->routeIs('reports.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                    "
                >
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                    <span>التقارير</span>
                </a>

            @endcan --}}


                {{-- الإدارة --}}

                @can('users.view')
                    <div
                        class="
                        mb-2
                        mt-6
                        px-3
                        text-[10px]
                        font-bold
                        text-[var(--color-text-muted)]
                    ">
                        الإدارة
                    </div>

                    <a href="{{ route('users.index') }}"
                        class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                    {{ request()->routeIs('users.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                    ">
                        <i class="fa-solid fa-user-lock w-5 text-center"></i>
                        <span>المستخدمون و الصلاحيات</span>
                    </a>
                @endcan


                @can('roles.manage')
                    <a href="{{ route('roles.index') }}"
                        class="
                        mb-1
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                    {{ request()->routeIs('roles.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]' }}
                    ">
                        <i class="fa-solid fa-user-lock w-5 text-center"></i>
                        <span>الأدوار والصلاحيات</span>
                    </a>
                @endcan

            </nav>


            {{-- User --}}

            <div class="border-t border-[var(--color-border)] p-4">

                <div class="flex items-center gap-3">

                    <div
                        class="
                        flex
                        h-10
                        w-10
                        shrink-0
                        items-center
                        justify-center
                        rounded-full
                        bg-[#D46417]
                        font-bold
                        text-white
                    ">
                        {{ mb_substr(auth()->user()->fullname, 0, 1) }}
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="truncate text-sm font-bold">
                            {{ auth()->user()->fullname }}
                        </div>

                        <div class="text-[11px] text-[var(--color-text-muted)]">
                            {{ auth()->user()->getRoleNames()->first() ?? 'بدون دور' }}
                        </div>

                    </div>

                </div>


                {{-- Logout --}}

                <form method="POST" action="{{ route('logout') }}" class="mt-3">

                    @csrf

                    <button type="submit"
                        class="
                        flex
                        w-full
                        items-center
                        gap-3
                        rounded-xl
                        px-4
                        py-3
                        text-sm
                        text-[var(--color-text-muted)]
                        transition
                        hover:bg-red-500/10
                        hover:text-red-400
                    ">

                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>

                        <span>
                            تسجيل الخروج
                        </span>

                    </button>

                </form>

            </div>

        </aside>


        {{-- =====================================================
         MAIN
    ====================================================== --}}

        <main class="min-h-screen lg:mr-72">

            {{-- TOPBAR --}}

            <header
                class="
                sticky
                top-0
                z-30
                flex
                h-20
                items-center
                justify-between
                border-b
                border-[var(--color-border)]
                bg-[var(--color-surface)]/95
                px-4
                backdrop-blur
                sm:px-6
            ">

                <div class="flex items-center gap-3">

                    {{-- Mobile Sidebar Button --}}

                    <button id="sidebar-toggle" type="button"
                        class="
                        flex
                        h-10
                        w-10
                        items-center
                        justify-center
                        rounded-xl
                        border
                        border-[var(--color-border)]
                        text-[var(--color-text)]
                        transition
                        hover:border-[#D46417]
                        hover:text-[#D46417]
                        lg:hidden
                    ">

                        <i class="fa-solid fa-bars"></i>

                    </button>


                    <div>

                        <h1 class="text-lg font-extrabold sm:text-xl">
                            @yield('page-title', 'لوحة التحكم')
                        </h1>

                        <p class="hidden text-xs text-[var(--color-text-muted)] sm:block">
                            نظام إدارة النادي الرياضي
                        </p>

                    </div>

                </div>




                <div class="flex min-w-0 items-center gap-2 sm:gap-3">

                    {{-- Notifications --}}
                    @auth
                        @php
                            $topbarNotifications = auth()->user()->notifications()->latest()->take(8)->get();

                            $unreadNotificationsCount = auth()->user()->unreadNotifications()->count();
                        @endphp

                        <div id="notifications-wrapper" class="relative">

                            <button id="notifications-toggle" type="button" aria-label="الإشعارات"
                                aria-controls="notifications-panel" aria-expanded="false"
                                class="relative flex h-10 w-10 items-center justify-center
                       rounded-xl border border-[var(--color-border)]
                       text-[var(--color-text)] transition
                       hover:border-[#D46417] hover:text-[#D46417]
                       focus:outline-none focus:ring-2 focus:ring-[#D46417]/30">
                                <i class="fa-regular fa-bell text-lg"></i>

                                @if ($unreadNotificationsCount > 0)
                                    <span id="notifications-badge"
                                        class="absolute -right-1 -top-1 flex min-h-[19px]
                               min-w-[19px] items-center justify-center
                               rounded-full border-2 border-[var(--color-surface)]
                               bg-[#D46417] px-1 text-[9px] font-extrabold text-white">
                                        {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                                    </span>
                                @endif
                            </button>

                            {{-- Dropdown --}}
                            <div id="notifications-panel"
                                class="absolute left-0 top-full z-[100] mt-3 hidden
                       w-[min(22rem,calc(100vw-2rem))]
                       overflow-hidden rounded-2xl
                       border border-[var(--color-border)]
                       bg-[var(--color-surface)]
                       shadow-2xl shadow-black/15"
                                aria-label="قائمة الإشعارات">
                                {{-- Header --}}
                                <div
                                    class="flex items-center justify-between gap-3
                            border-b border-[var(--color-border)] p-4">

                                    <div class="flex min-w-0 items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center
                                    justify-center rounded-xl bg-[#D46417]/10
                                    text-[#D46417]">
                                            <i class="fa-regular fa-bell text-lg"></i>
                                        </div>

                                        <div>
                                            <h3 class="text-sm font-extrabold text-[var(--color-text)]">
                                                الإشعارات
                                            </h3>
                                            <p class="mt-1 text-[11px] text-[var(--color-text-muted)]">
                                                لديك {{ $unreadNotificationsCount }} إشعار غير مقروء
                                            </p>
                                        </div>
                                    </div>

                                    <button type="button" id="notifications-close" aria-label="إغلاق الإشعارات"
                                        class="flex h-8 w-8 shrink-0 items-center justify-center
                               rounded-lg text-[var(--color-text-muted)]
                               transition hover:bg-[var(--color-surface-hover)]
                               hover:text-[var(--color-text)]">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>

                                {{-- Notification List --}}
                                <div class="max-h-[min(26rem,60vh)] overflow-y-auto">

                                    @forelse ($topbarNotifications as $notification)
                                        @php
                                            $data = $notification->data;
                                            $isUnread = is_null($notification->read_at);

                                            $isExpiring = ($data['type'] ?? '') === 'subscription_expiring';
                                        @endphp

                                        <form method="POST"
                                            action="{{ route('notifications.open', $notification->id) }}">
                                            @csrf

                                            <button type="submit"
                                                class="group flex w-full items-start gap-3 border-b
                                       border-[var(--color-border)]/70 p-4 text-right
                                       transition hover:bg-[var(--color-surface-hover)]
                                       {{ $isUnread ? 'bg-[#D46417]/[0.045]' : '' }}">
                                                <span
                                                    class="flex h-10 w-10 shrink-0 items-center
                                           justify-center rounded-xl
                                           {{ $isExpiring ? 'bg-amber-500/10 text-amber-500' : 'bg-[#D46417]/10 text-[#D46417]' }}">
                                                    <i
                                                        class="fa-solid
                                        {{ $isExpiring ? 'fa-clock' : 'fa-id-card' }}">
                                                    </i>
                                                </span>

                                                <span class="min-w-0 flex-1">
                                                    <span class="flex items-start justify-between gap-2">
                                                        <span
                                                            class="text-xs font-extrabold leading-5
                                                     text-[var(--color-text)]">
                                                            {{ $data['title'] ?? 'إشعار جديد' }}
                                                        </span>

                                                        @if ($isUnread)
                                                            <span
                                                                class="mt-1 h-2 w-2 shrink-0
                                                         rounded-full bg-[#D46417]"></span>
                                                        @endif
                                                    </span>

                                                    <span
                                                        class="mt-1 block break-words text-[11px]
                                                 leading-5 text-[var(--color-text-muted)]">
                                                        {{ $data['message'] ?? 'لديك إشعار جديد.' }}
                                                    </span>

                                                    <span
                                                        class="mt-2 block text-[10px]
                                                 text-[var(--color-text-muted)]">
                                                        <i class="fa-regular fa-clock ml-1"></i>
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>
                                                </span>
                                            </button>
                                        </form>
                                    @empty
                                        <div class="px-5 py-10 text-center">
                                            <div
                                                class="mx-auto flex h-14 w-14 items-center
                                        justify-center rounded-2xl
                                        bg-[var(--color-surface-hover)]
                                        text-[var(--color-text-muted)]">
                                                <i class="fa-regular fa-bell-slash text-xl"></i>
                                            </div>

                                            <p class="mt-3 text-sm font-bold text-[var(--color-text)]">
                                                لا توجد إشعارات
                                            </p>

                                            <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                                                ستظهر إشعاراتك الجديدة هنا.
                                            </p>
                                        </div>
                                    @endforelse

                                </div>

                                {{-- Footer --}}
                                @if ($unreadNotificationsCount > 0)
                                    <form method="POST" action="{{ route('notifications.read-all') }}"
                                        class="border-t border-[var(--color-border)] p-3">
                                        @csrf

                                        <button type="submit"
                                            class="w-full rounded-xl px-3 py-2.5 text-xs
                                   font-bold text-[#D46417] transition
                                   hover:bg-[#D46417]/10">
                                            <i class="fa-solid fa-check-double ml-1"></i>
                                            تحديد الكل كمقروء
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endauth

                    {{-- معلومات المستخدم --}}
                    @auth
                        <div class="hidden items-center gap-2 sm:flex">

                            <div
                                class="flex h-9 w-9 items-center justify-center
                       rounded-full bg-[#D46417] text-sm font-bold text-white">
                                {{ mb_substr(auth()->user()->fullname, 0, 1) }}
                            </div>

                            <div class="text-right">
                                <div class="text-[10px] text-[var(--color-text-muted)]">
                                    اسم المستخدم
                                </div>

                                <div class="text-sm font-bold text-[var(--color-text)]">
                                    {{ auth()->user()->username }}
                                </div>
                            </div>
                        </div>
                    @endauth

                    {{-- Theme Button --}}
                    <button id="theme-toggle" type="button"
                        class="flex h-10 w-10 shrink-0 items-center justify-center
               rounded-xl border border-[var(--color-border)]
               text-[var(--color-text)] transition
               hover:border-[#D46417] hover:text-[#D46417]"
                        title="تبديل المظهر">
                        <i id="theme-icon" class="fa-solid fa-sun"></i>
                    </button>

                </div>




            </header>


            {{-- CONTENT --}}

            <section class="p-4 sm:p-6">

                @yield('content')

            </section>

        </main>

    </div>


    <script>
        /*
                    |--------------------------------------------------------------------------
                    | Theme
                    |--------------------------------------------------------------------------
                    */

        const themeToggle =
            document.getElementById('theme-toggle');

        const themeIcon =
            document.getElementById('theme-icon');


        function updateThemeIcon() {

            const isLight =
                document.documentElement.classList.contains('light');

            themeIcon.className =
                isLight ?
                'fa-solid fa-moon' :
                'fa-solid fa-sun';
        }


        updateThemeIcon();


        themeToggle?.addEventListener('click', () => {

            const html =
                document.documentElement;

            const isLight =
                html.classList.toggle('light');

            localStorage.setItem(
                'gym-theme',
                isLight ? 'light' : 'dark'
            );

            updateThemeIcon();

        });


        /*
        |--------------------------------------------------------------------------
        | Mobile Sidebar
        |--------------------------------------------------------------------------
        */

        const sidebar =
            document.getElementById('sidebar');

        const sidebarToggle =
            document.getElementById('sidebar-toggle');

        const sidebarOverlay =
            document.getElementById('sidebar-overlay');


        sidebarToggle?.addEventListener('click', () => {

            sidebar.classList.remove('translate-x-full');

            sidebarOverlay.classList.remove('hidden');

        });


        sidebarOverlay?.addEventListener('click', () => {

            sidebar.classList.add('translate-x-full');

            sidebarOverlay.classList.add('hidden');

        });

        /*
        |--------------------------------------------------------------------------
        | Success Notification
        |--------------------------------------------------------------------------
        */

        const successNotification =
            document.getElementById('success-notification');


        function hideSuccessNotification() {

            if (!successNotification) {
                return;
            }

            successNotification.classList.add('notification-hide');

            setTimeout(() => {
                successNotification.remove();
            }, 450);
        }


        if (successNotification) {

            setTimeout(() => {
                hideSuccessNotification();
            }, 5000);

        }

        /*
|--------------------------------------------------------------------------
| Notifications Dropdown
|--------------------------------------------------------------------------
*/

const notificationsToggle =
    document.getElementById('notifications-toggle');

const notificationsPanel =
    document.getElementById('notifications-panel');

const notificationsWrapper =
    document.getElementById('notifications-wrapper');

const notificationsClose =
    document.getElementById('notifications-close');

function openNotifications() {
    if (!notificationsPanel || !notificationsToggle) {
        return;
    }

    notificationsPanel.classList.remove('hidden');

    // إعادة تشغيل الحركة عند كل فتح.
    notificationsPanel.classList.remove('notifications-panel-open');

    void notificationsPanel.offsetWidth;

    notificationsPanel.classList.add('notifications-panel-open');

    notificationsToggle.setAttribute('aria-expanded', 'true');
}

function closeNotifications() {
    if (!notificationsPanel || !notificationsToggle) {
        return;
    }

    notificationsPanel.classList.add('hidden');
    notificationsPanel.classList.remove('notifications-panel-open');

    notificationsToggle.setAttribute('aria-expanded', 'false');
}

notificationsToggle?.addEventListener('click', (event) => {
    event.stopPropagation();

    if (notificationsPanel.classList.contains('hidden')) {
        openNotifications();
    } else {
        closeNotifications();
    }
});

notificationsClose?.addEventListener('click', closeNotifications);

document.addEventListener('click', (event) => {
    if (
        notificationsWrapper &&
        !notificationsWrapper.contains(event.target)
    ) {
        closeNotifications();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeNotifications();
        notificationsToggle?.focus();
    }
});
    </script>

    @stack('scripts')

</body>

</html>
