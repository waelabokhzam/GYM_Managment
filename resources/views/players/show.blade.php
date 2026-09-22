@extends('layout.app')

@section('title', 'بيانات اللاعب')

@section('page-title', 'بيانات اللاعب')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <a
                href="{{ route('players.index') }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417]/50 hover:text-[#D46417]"
            >
                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div>

                <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">
                    بيانات اللاعب
                </h1>

                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                    عرض التفاصيل الكاملة للاعب.
                </p>

            </div>

        </div>


        <div class="flex items-center gap-2">

            @can('update', $player)

                <a
                    href="{{ route('players.edit', $player) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95310]"
                >
                    <i class="fa-solid fa-pen"></i>
                    تعديل
                </a>

            @endcan


            @can('delete', $player)

                <form
                    action="{{ route('players.destroy', $player) }}"
                    method="POST"
                    onsubmit="return confirm('هل أنت متأكد من حذف هذا اللاعب؟');"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-xl border border-red-500/20 px-5 py-3 text-sm font-bold text-red-500 transition hover:bg-red-500/10"
                    >
                        <i class="fa-solid fa-trash"></i>
                        حذف
                    </button>

                </form>

            @endcan

        </div>

    </div>


    {{-- Player Profile --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="border-b border-[var(--color-border)] bg-[#D46417]/5 p-6">

            <div class="flex flex-col items-center gap-5 sm:flex-row">

                <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-full bg-[#D46417]/15 text-3xl font-extrabold text-[#D46417]">

                    {{ mb_substr($player->user->fullname ?? '-', 0, 1) }}

                </div>

                <div class="text-center sm:text-right">

                    <h2 class="text-2xl font-extrabold">
                        {{ $player->user->fullname }}
                    </h2>

                    <div class="mt-2 flex flex-wrap items-center justify-center gap-2 sm:justify-start">

                        <span class="rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">
                            {{ $player->unique_number }}
                        </span>

                        <span class="rounded-lg bg-green-500/10 px-3 py-1.5 text-xs font-bold text-green-600 dark:text-green-400">
                            <i class="fa-solid fa-user-check ml-1"></i>
                            لاعب
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Account Information --}}
        <div class="p-6">

            <div class="mb-5 flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">
                    <i class="fa-solid fa-user-lock"></i>
                </div>

                <div>

                    <h3 class="font-extrabold">
                        معلومات الحساب
                    </h3>

                    <p class="text-sm text-[var(--color-text-muted)]">
                        بيانات الحساب المرتبط باللاعب.
                    </p>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Fullname --}}
                <div class="rounded-xl border border-[var(--color-border)] p-4">

                    <p class="text-xs font-semibold text-[var(--color-text-muted)]">
                        الاسم الكامل
                    </p>

                    <p class="mt-2 font-bold">
                        {{ $player->user->fullname }}
                    </p>

                </div>


                {{-- Username --}}
                <div class="rounded-xl border border-[var(--color-border)] p-4">

                    <p class="text-xs font-semibold text-[var(--color-text-muted)]">
                        اسم المستخدم
                    </p>

                    <p class="mt-2 font-bold text-[#D46417]">
                        {{ $player->user->username }}
                    </p>

                </div>


                {{-- Phone --}}
                <div class="rounded-xl border border-[var(--color-border)] p-4">

                    <p class="text-xs font-semibold text-[var(--color-text-muted)]">
                        رقم الهاتف
                    </p>

                    <p class="mt-2 font-bold">
                        {{ $player->user->phone }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Physical Information --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="border-b border-[var(--color-border)] p-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>

                <div>

                    <h3 class="font-extrabold">
                        المعلومات الرياضية والجسدية
                    </h3>

                    <p class="text-sm text-[var(--color-text-muted)]">
                        المعلومات الخاصة باللاعب.
                    </p>

                </div>

            </div>

        </div>


        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Unique Number --}}
            <div class="rounded-xl border border-[var(--color-border)] p-4">

                <p class="text-xs text-[var(--color-text-muted)]">
                    رقم اللاعب
                </p>

                <p class="mt-2 font-extrabold text-[#D46417]">
                    {{ $player->unique_number }}
                </p>

            </div>


            {{-- Gender --}}
            <div class="rounded-xl border border-[var(--color-border)] p-4">

                <p class="text-xs text-[var(--color-text-muted)]">
                    الجنس
                </p>

                <p class="mt-2 font-bold">

                    @if($player->gender === 'male')

                        <span class="text-blue-600 dark:text-blue-400">
                            <i class="fa-solid fa-mars ml-1"></i>
                            ذكر
                        </span>

                    @else

                        <span class="text-pink-600 dark:text-pink-400">
                            <i class="fa-solid fa-venus ml-1"></i>
                            أنثى
                        </span>

                    @endif

                </p>

            </div>


            {{-- Height --}}
            <div class="rounded-xl border border-[var(--color-border)] p-4">

                <p class="text-xs text-[var(--color-text-muted)]">
                    الطول
                </p>

                <p class="mt-2 font-bold">
                    {{ $player->height ? $player->height . ' سم' : 'غير محدد' }}
                </p>

            </div>


            {{-- Weight --}}
            <div class="rounded-xl border border-[var(--color-border)] p-4">

                <p class="text-xs text-[var(--color-text-muted)]">
                    الوزن
                </p>

                <p class="mt-2 font-bold">
                    {{ $player->weight ? $player->weight . ' كغ' : 'غير محدد' }}
                </p>

            </div>


            {{-- Occupation --}}
            <div class="rounded-xl border border-[var(--color-border)] p-4 sm:col-span-2">

                <p class="text-xs text-[var(--color-text-muted)]">
                    المهنة
                </p>

                <p class="mt-2 font-bold">
                    {{ $player->occupation ?: 'غير محددة' }}
                </p>

            </div>


            {{-- Health Status --}}
            <div class="rounded-xl border border-[var(--color-border)] p-4 sm:col-span-2">

                <p class="text-xs text-[var(--color-text-muted)]">
                    الحالة الصحية
                </p>

                <p class="mt-2 whitespace-pre-line font-bold">
                    {{ $player->health_status ?: 'لا توجد ملاحظات صحية' }}
                </p>

            </div>

        </div>

    </div>


    {{-- Account Dates --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>

                <div>

                    <p class="text-xs text-[var(--color-text-muted)]">
                        تاريخ إنشاء الحساب
                    </p>

                    <p class="mt-1 font-bold">
                        {{ $player->created_at?->format('Y-m-d H:i') ?? '-' }}
                    </p>

                </div>

            </div>

        </div>


        <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <div>

                    <p class="text-xs text-[var(--color-text-muted)]">
                        آخر تحديث
                    </p>

                    <p class="mt-1 font-bold">
                        {{ $player->updated_at?->format('Y-m-d H:i') ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection