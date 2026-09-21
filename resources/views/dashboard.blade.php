@extends('layout.app')

@section('title', 'لوحة التحكم')

@section('page-title', 'لوحة التحكم')

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">
        أهلاً بك في نظام إدارة النادي
    </h1>

    <p class="mt-2 text-sm text-[var(--color-text-muted)] sm:text-base">
        يمكنك إدارة الأعضاء والاشتراكات والمدربين والحضور من هنا.
    </p>

</div>


{{-- =====================================================
     Dashboard Cards
====================================================== --}}

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


    {{-- الأعضاء --}}

    <div
        class="
            group
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
            p-5
            transition-all
            duration-300
            hover:-translate-y-1
            hover:border-[#D46417]/50
            hover:shadow-lg
            hover:shadow-[#D46417]/5
        "
    >

        <div class="flex items-start justify-between">

            <div
                class="
                    flex
                    h-12
                    w-12
                    items-center
                    justify-center
                    rounded-xl
                    bg-[#D46417]/15
                    text-[#D46417]
                    transition
                    duration-300
                    group-hover:bg-[#D46417]
                    group-hover:text-white
                "
            >
                <i class="fa-solid fa-users text-lg"></i>
            </div>

            <span
                class="
                    text-xs
                    font-medium
                    text-[var(--color-text-muted)]
                "
            >
                النادي
            </span>

        </div>

        <div class="mt-5">

            <h3 class="text-lg font-bold">
                الأعضاء
            </h3>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إدارة أعضاء النادي
            </p>

        </div>

    </div>


    {{-- الاشتراكات --}}

    <div
        class="
            group
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
            p-5
            transition-all
            duration-300
            hover:-translate-y-1
            hover:border-[#D46417]/50
            hover:shadow-lg
            hover:shadow-[#D46417]/5
        "
    >

        <div class="flex items-start justify-between">

            <div
                class="
                    flex
                    h-12
                    w-12
                    items-center
                    justify-center
                    rounded-xl
                    bg-[#D46417]/15
                    text-[#D46417]
                    transition
                    duration-300
                    group-hover:bg-[#D46417]
                    group-hover:text-white
                "
            >
                <i class="fa-solid fa-id-card text-lg"></i>
            </div>

            <span
                class="
                    text-xs
                    font-medium
                    text-[var(--color-text-muted)]
                "
            >
                النادي
            </span>

        </div>

        <div class="mt-5">

            <h3 class="text-lg font-bold">
                الاشتراكات
            </h3>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                متابعة اشتراكات اللاعبين
            </p>

        </div>

    </div>


    {{-- المدربون --}}

    <div
        class="
            group
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
            p-5
            transition-all
            duration-300
            hover:-translate-y-1
            hover:border-[#D46417]/50
            hover:shadow-lg
            hover:shadow-[#D46417]/5
        "
    >

        <div class="flex items-start justify-between">

            <div
                class="
                    flex
                    h-12
                    w-12
                    items-center
                    justify-center
                    rounded-xl
                    bg-[#D46417]/15
                    text-[#D46417]
                    transition
                    duration-300
                    group-hover:bg-[#D46417]
                    group-hover:text-white
                "
            >
                <i class="fa-solid fa-person-running text-lg"></i>
            </div>

            <span
                class="
                    text-xs
                    font-medium
                    text-[var(--color-text-muted)]
                "
            >
                النادي
            </span>

        </div>

        <div class="mt-5">

            <h3 class="text-lg font-bold">
                المدربون
            </h3>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إدارة مدربي النادي
            </p>

        </div>

    </div>


    {{-- الحضور --}}

    <div
        class="
            group
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
            p-5
            transition-all
            duration-300
            hover:-translate-y-1
            hover:border-[#D46417]/50
            hover:shadow-lg
            hover:shadow-[#D46417]/5
        "
    >

        <div class="flex items-start justify-between">

            <div
                class="
                    flex
                    h-12
                    w-12
                    items-center
                    justify-center
                    rounded-xl
                    bg-[#D46417]/15
                    text-[#D46417]
                    transition
                    duration-300
                    group-hover:bg-[#D46417]
                    group-hover:text-white
                "
            >
                <i class="fa-solid fa-fingerprint text-lg"></i>
            </div>

            <span
                class="
                    text-xs
                    font-medium
                    text-[var(--color-text-muted)]
                "
            >
                النادي
            </span>

        </div>

        <div class="mt-5">

            <h3 class="text-lg font-bold">
                الحضور
            </h3>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                متابعة حضور اللاعبين
            </p>

        </div>

    </div>

</div>

@endsection
