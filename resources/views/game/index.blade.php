@extends('layout.app')

@section('title', 'الألعاب الرياضية')
@section('page-title', 'الألعاب الرياضية')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm text-[var(--color-text-muted)]">
                    إدارة الألعاب والأنشطة الرياضية في النادي
                </p>
            </div>

            @can('create', App\Models\Game::class)
                <a href="{{ route('games.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95714]">

                    <i class="fa-solid fa-plus"></i>
                    إضافة لعبة

                </a>
            @endcan

        </div>

        {{-- Success --}}
        @if (session('success'))

            <div
                class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-semibold text-emerald-400">
                {{ session('success') }}
            </div>

        @endif

        {{-- Search --}}
        <div
            class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4 sm:p-6">

            <form method="GET"
                action="{{ route('games.index') }}"
                class="flex flex-col gap-3 sm:flex-row">

                <label for="search" class="sr-only">
                    البحث عن لعبة
                </label>

                <div class="relative flex-1">

                    <i
                        class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]">
                    </i>

                    <input
                        id="search"
                        name="search"
                        type="search"
                        value="{{ request('search') }}"
                        placeholder="ابحث باسم اللعبة..."
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] py-3 pe-11 ps-4 text-sm text-[var(--color-text)] outline-none transition placeholder:text-[var(--color-text-muted)] focus:border-[#D46417]">

                </div>

                <button type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#b95714]">
                    بحث
                </button>

                @if (request('search'))

                    <a href="{{ route('games.index') }}"
                        class="rounded-xl border border-[var(--color-border)] px-6 py-3 text-center text-sm font-semibold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">
                        مسح
                    </a>

                @endif

            </form>

        </div>

        {{-- Empty --}}
        @if ($games->isEmpty())

            <div
                class="rounded-2xl border border-dashed border-[var(--color-border)] bg-[var(--color-surface)] px-6 py-16 text-center">

                <i class="fa-solid fa-dumbbell mb-4 text-3xl text-[#D46417]"></i>

                <h2 class="text-lg font-bold">
                    لا توجد ألعاب
                </h2>

                <p class="mt-2 text-sm text-[var(--color-text-muted)]">
                    أضف لعبة جديدة لتظهر هنا.
                </p>

            </div>

        @else

            {{-- Games --}}
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">

                @foreach ($games as $game)

                    <article
                        class="flex flex-col rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 transition hover:border-[#D46417]/60">

                        {{-- Game Header --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">

                                    <i class="fa-solid fa-dumbbell"></i>

                                </div>

                                <h2 class="truncate text-lg font-bold">
                                    {{ $game->name }}
                                </h2>

                            </div>

                            <span class="text-xs text-[var(--color-text-muted)]">
                                #{{ $game->id }}
                            </span>

                        </div>

                        {{-- Description --}}
                        <p
                            class="mt-4 line-clamp-3 text-sm leading-7 text-[var(--color-text-muted)]">

                            {{ $game->description }}

                        </p>

                        {{-- Time Slots --}}
                        <div class="mt-5">

                            <div class="mb-2 flex items-center gap-2">

                                <i class="fa-regular fa-clock text-xs text-[#D46417]"></i>

                                <span class="text-xs font-bold">
                                    أوقات التدريب
                                </span>

                                <span
                                    class="rounded-md bg-[#D46417]/10 px-1.5 py-0.5 text-[10px] font-bold text-[#D46417]">
                                    {{ $game->timeSlots->count() }}
                                </span>

                            </div>

                            @if ($game->timeSlots->isEmpty())

                                <span class="text-xs text-[var(--color-text-muted)]">
                                    لا توجد أوقات مرتبطة
                                </span>

                            @else

                                <div class="flex flex-wrap gap-2">

                                    @foreach ($game->timeSlots->take(4) as $timeSlot)

                                        @php
                                            $timeSlotLabel =
                                                $timeSlot->name ??
                                                \Carbon\Carbon::parse($timeSlot->start_time)->format('H:i') .
                                                    ' - ' .
                                                    \Carbon\Carbon::parse($timeSlot->end_time)->format('H:i');
                                        @endphp

                                        <span
                                            class="inline-flex items-center gap-1 rounded-lg border border-[var(--color-border)] bg-[var(--color-background)] px-2.5 py-1.5 text-[10px] font-semibold text-[var(--color-text-muted)]">

                                            <i class="fa-regular fa-clock text-[#D46417]"></i>

                                            {{ $timeSlotLabel }}

                                        </span>

                                    @endforeach

                                    @if ($game->timeSlots->count() > 4)

                                        <span
                                            class="inline-flex items-center rounded-lg bg-[#D46417]/10 px-2.5 py-1.5 text-[10px] font-bold text-[#D46417]">

                                            +{{ $game->timeSlots->count() - 4 }}

                                        </span>

                                    @endif

                                </div>

                            @endif

                        </div>

                        {{-- Actions --}}
                        <div
                            class="mt-5 flex items-center justify-between border-t border-[var(--color-border)] pt-4">

                            <a href="{{ route('games.show', $game) }}"
                                class="text-sm font-bold text-[#D46417] hover:underline">

                                عرض التفاصيل

                                <i class="fa-solid fa-arrow-left ms-1 text-xs"></i>

                            </a>

                            @can('update', $game)

                                <a href="{{ route('games.edit', $game) }}"
                                    class="text-[var(--color-text-muted)] transition hover:text-[#D46417]"
                                    title="تعديل">

                                    <i class="fa-solid fa-pen-to-square"></i>

                                </a>

                            @endcan

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>
@endsection