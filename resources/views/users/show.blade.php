@extends('layout.app')

@section('title', 'تفاصيل المستخدم')
@section('page-title', 'تفاصيل المستخدم')

@section('content')

@php
    $role = $user->roles->first()?->name;
@endphp

<div class="mx-auto max-w-5xl space-y-6">


    {{-- Header --}}
    <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

            <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-[#D46417] text-2xl font-bold text-white">

                {{ mb_substr($user->fullname, 0, 1) }}

            </div>

            <div class="flex-1">

                <h2 class="text-2xl font-extrabold">
                    {{ $user->fullname }}
                </h2>

                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                    {{ $user->username }}
                </p>

            </div>


            @switch($role)

                @case('admin')

                    <span class="rounded-xl bg-red-500/10 px-4 py-2 text-sm font-bold text-red-500">
                        أدمن
                    </span>

                    @break

                @case('reception')

                    <span class="rounded-xl bg-blue-500/10 px-4 py-2 text-sm font-bold text-blue-500">
                        موظف استقبال
                    </span>

                    @break

                @case('trainer')

                    <span class="rounded-xl bg-[#D46417]/10 px-4 py-2 text-sm font-bold text-[#D46417]">
                        مدرب
                    </span>

                    @break

                @case('player')

                    <span class="rounded-xl bg-green-500/10 px-4 py-2 text-sm font-bold text-green-500">
                        لاعب
                    </span>

                    @break

            @endswitch

        </div>

    </div>


    {{-- Basic information --}}
    <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

        <h3 class="mb-6 text-lg font-extrabold">
            المعلومات الأساسية
        </h3>

        <div class="grid gap-5 md:grid-cols-3">

            <div class="rounded-2xl bg-[var(--color-background)] p-5">

                <p class="text-xs text-[var(--color-text-muted)]">
                    الاسم الكامل
                </p>

                <p class="mt-2 font-bold">
                    {{ $user->fullname }}
                </p>

            </div>


            <div class="rounded-2xl bg-[var(--color-background)] p-5">

                <p class="text-xs text-[var(--color-text-muted)]">
                    اسم المستخدم
                </p>

                <p class="mt-2 font-bold">
                    {{ $user->username }}
                </p>

            </div>


            <div class="rounded-2xl bg-[var(--color-background)] p-5">

                <p class="text-xs text-[var(--color-text-muted)]">
                    رقم الهاتف
                </p>

                <p class="mt-2 font-bold">
                    {{ $user->phone }}
                </p>

            </div>

        </div>

    </div>


    {{-- Staff --}}
    @if (in_array($role, ['admin', 'reception', 'trainer']) && $user->staff)

        <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

            <h3 class="mb-6 text-lg font-extrabold">
                بيانات الموظف
            </h3>

            <div class="grid gap-5 md:grid-cols-3">

                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        نوع الأجر
                    </p>

                    <p class="mt-2 font-bold">

                        {{ $user->staff->salary_type === 'fixed'
                            ? 'راتب ثابت'
                            : 'نسبة'
                        }}

                    </p>

                </div>


                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        الأجر الأساسي
                    </p>

                    <p class="mt-2 font-bold">
                        {{ number_format($user->staff->base_salary, 2) }}
                    </p>

                </div>


                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        الدور
                    </p>

                    <p class="mt-2 font-bold">

                        @switch($user->staff->role)

                            @case('admin')
                                أدمن
                                @break

                            @case('reception')
                                موظف استقبال
                                @break

                            @case('trainer')
                                مدرب
                                @break

                        @endswitch

                    </p>

                </div>

            </div>

        </div>

    @endif


    {{-- Player --}}
    @if ($role === 'player' && $user->player)

        <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

            <h3 class="mb-6 text-lg font-extrabold">
                بيانات اللاعب
            </h3>

            <div class="grid gap-5 md:grid-cols-3">

                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        الرقم الخاص
                    </p>

                    <p class="mt-2 font-bold">
                        {{ $user->player->unique_number }}
                    </p>

                </div>


                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        الجنس
                    </p>

                    <p class="mt-2 font-bold">
                        {{ $user->player->gender === 'male' ? 'ذكر' : 'أنثى' }}
                    </p>

                </div>


                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        المهنة
                    </p>

                    <p class="mt-2 font-bold">
                        {{ $user->player->occupation ?: '—' }}
                    </p>

                </div>


                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        الطول
                    </p>

                    <p class="mt-2 font-bold">
                        {{ $user->player->height ? $user->player->height . ' سم' : '—' }}
                    </p>

                </div>


                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        الوزن
                    </p>

                    <p class="mt-2 font-bold">
                        {{ $user->player->weight ? $user->player->weight . ' كغ' : '—' }}
                    </p>

                </div>


                <div class="rounded-2xl bg-[var(--color-background)] p-5">

                    <p class="text-xs text-[var(--color-text-muted)]">
                        الحالة الصحية
                    </p>

                    <p class="mt-2 font-bold">
                        {{ $user->player->health_status ?: '—' }}
                    </p>

                </div>

            </div>

        </div>

    @endif


    {{-- Actions --}}
    <div class="flex justify-end gap-3">

        <a
            href="{{ route('users.index') }}"
            class="rounded-xl border border-[var(--color-border)] px-6 py-3 text-sm font-bold"
        >
            رجوع
        </a>

        @can('users.edit')

            <a
                href="{{ route('users.edit', $user) }}"
                class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white hover:bg-[#b95412]"
            >
                <i class="fa-solid fa-pen ml-1"></i>
                تعديل
            </a>

        @endcan

    </div>

</div>

@endsection