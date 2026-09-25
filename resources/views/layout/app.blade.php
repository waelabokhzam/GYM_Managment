<!DOCTYPE html>
<html
    lang="ar"
    dir="rtl"
>
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'نظام إدارة النادي الرياضي')
    </title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

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
            notification-enter
            0.45s
            ease-out
            forwards;
    }

    #success-notification.notification-hide {
        animation:
            notification-exit
            0.45s
            ease-in
            forwards;
    }
</style>
</head>

<body class="min-h-screen bg-[var(--color-background)] text-[var(--color-text)]">
@if (session('success'))

    <div
        id="success-notification"
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
        role="alert"
    >

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
            "
        >
            <i class="fa-solid fa-check"></i>
        </div>


        {{-- Message --}}

        <span>
            {{ session('success') }}
        </span>


        {{-- Close Button --}}

        <button
            type="button"
            onclick="hideSuccessNotification()"
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
            aria-label="إغلاق"
        >
            <i class="fa-solid fa-xmark text-xs"></i>
        </button>

    </div>

@endif
<div class="min-h-screen">

    {{-- =====================================================
         SIDEBAR OVERLAY
    ====================================================== --}}

    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-black/60 backdrop-blur-sm lg:hidden"
    ></div>


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside
        id="sidebar"
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
        "
    >

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
            "
        >

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3"
            >

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
                    "
                >
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
                "
            >
                الرئيسية
            </div>

            <a
                href="{{ route('dashboard') }}"
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
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                "
            >

                <i class="fa-solid fa-chart-line w-5 text-center"></i>

                <span>
                    لوحة التحكم
                </span>

            </a>


            {{-- النادي --}}

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
                النادي
            </div>


            @can('players.view')

                <a
                    href="{{route('players.index')}}"
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
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                    "
                >
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>اللاعبين</span>
                </a>

            @endcan


            @can('subscriptions.view')

                <a
                    href="{{route('subscriptions.index')}}"
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
                            : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                        }}
                    "
                >
                    <i class="fa-solid fa-id-card w-5 text-center"></i>
                    <span>الاشتراكات</span>
                </a>

            @endcan


            @can('trainers.view')

                <a
                    href="{{route('trainers.index')}}"
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
                            : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                        }}
                    "
                >
                    <i class="fa-solid fa-person-running w-5 text-center"></i>
                    <span>المدربون</span>
                </a>

            @endcan


            @can('training_periods.view')

                <a
                    href="{{route('timeslots.index')}}"
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
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                    "
                >
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span>الفترات التدريبية</span>
                </a>

            @endcan


            @can('sports.view')

                <a
                    href="{{route('games.index')}}"
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
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                    "
                >
                    <i class="fa-solid fa-dumbbell w-5 text-center"></i>
                    <span>الرياضات</span>
                </a>

            @endcan


            @can('attendance.view')

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
                    {{ request()->routeIs('attend.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                    "
                >
                    <i class="fa-solid fa-fingerprint w-5 text-center"></i>
                    <span>الحضور</span>
                </a>

            @endcan


            @can('payments.view')

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
                    {{ request()->routeIs('payments.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                    "
                >
                    <i class="fa-solid fa-money-bill-wave w-5 text-center"></i>
                    <span>الدفعات</span>
                </a>

            @endcan


            {{-- التقارير --}}

            @can('reports.view')

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

            @endcan


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
                    "
                >
                    الإدارة
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
                    {{ request()->routeIs('users.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                    "
                >
                    <i class="fa-solid fa-user-shield w-5 text-center"></i>
                    <span>المستخدمون</span>
                </a>

            @endcan


            @can('roles.manage')

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
                    {{ request()->routeIs('roles.*')
                        ? 'bg-[#D46417] text-white shadow-lg shadow-[#D46417]/20'
                        : 'text-[var(--color-text-muted)] hover:bg-[var(--color-surface-hover)] hover:text-[var(--color-text)]'
                    }}
                    "
                >
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
                    "
                >
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

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="mt-3"
            >

                @csrf

                <button
                    type="submit"
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
                    "
                >

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
            "
        >

            <div class="flex items-center gap-3">

                {{-- Mobile Sidebar Button --}}

                <button
                    id="sidebar-toggle"
                    type="button"
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
                    "
                >

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



            <div class="flex items-center gap-3">

                {{-- معلومات المستخدم --}}
                @auth
                    <div class="hidden sm:flex items-center gap-2">

                        {{-- Avatar --}}
                        <div
                            class="flex h-9 w-9 items-center justify-center
                                rounded-full bg-[#D46417]
                                text-sm font-bold text-white"
                        >
                            {{ mb_substr(auth()->user()->fullname, 0, 1) }}
                        </div>

                        {{-- Username --}}
                        <div class="text-right">
                            <div class="text-[10px] text-[var(--color-text-muted)]">
                                user_name
                            </div>

                            <div class="text-sm font-bold text-[var(--color-text)]">
                                {{  auth()->user()->username }}
                            </div>
                        </div>

                    </div>
                @endauth

                {{-- Theme Button --}}
                <button
                    id="theme-toggle"
                    type="button"
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
                    "
                    title="تبديل المظهر"
                >
                    <i
                        id="theme-icon"
                        class="fa-solid fa-sun"
                    ></i>
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
            isLight
                ? 'fa-solid fa-moon'
                : 'fa-solid fa-sun';
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
</script>

@stack('scripts')

</body>
</html>
