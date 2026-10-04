@extends('layout.app')

@section('title', $game->name)
@section('page-title', 'تفاصيل اللعبة')

@section('content')
    <div class="mx-auto max-w-4xl">

        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between gap-4">

            <a href="{{ route('games.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-[var(--color-text-muted)] transition hover:text-[#D46417]">

                <i class="fa-solid fa-arrow-right"></i>

                العودة للألعاب

            </a>

            @can('update', $game)

                <a href="{{ route('games.edit', $game) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--color-border)] px-4 py-2.5 text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">

                    <i class="fa-solid fa-pen-to-square"></i>

                    تعديل

                </a>

            @endcan

        </div>

        {{-- Game Details --}}
        <article
            class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 sm:p-10">

            {{-- Game Header --}}
            <div
                class="flex flex-col gap-5 border-b border-[var(--color-border)] pb-7 sm:flex-row sm:items-center">

                <div
                    class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#D46417]/15 text-2xl text-[#D46417]">

                    <i class="fa-solid fa-dumbbell"></i>

                </div>

                <div>

                    <span class="text-xs text-[var(--color-text-muted)]">
                        لعبة رقم #{{ $game->id }}
                    </span>

                    <h2 class="mt-1 text-2xl font-extrabold">
                        {{ $game->name }}
                    </h2>

                </div>

            </div>

            {{-- Description --}}
            <div class="pt-7">

                <h3 class="mb-3 text-sm font-bold text-[#D46417]">
                    الوصف
                </h3>

                <p
                    class="whitespace-pre-line text-sm leading-8 text-[var(--color-text-muted)]">

                    {{ $game->description }}

                </p>

            </div>

            {{-- Time Slots --}}
            <div
                class="mt-8 border-t border-[var(--color-border)] pt-7">

                <div class="mb-4 flex items-center justify-between">

                    <div>

                        <h3 class="text-sm font-bold text-[#D46417]">
                            أوقات التدريب
                        </h3>

                        <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                            الأوقات التي تتوفر فيها هذه اللعبة.
                        </p>

                    </div>

                    <span
                        class="rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">

                        {{ $game->timeSlots->count() }} أوقات

                    </span>

                </div>

                @if ($game->timeSlots->isEmpty())

                    <div
                        class="rounded-xl border border-dashed border-[var(--color-border)] bg-[var(--color-background)] px-5 py-8 text-center">

                        <i class="fa-regular fa-clock mb-3 text-2xl text-[var(--color-text-muted)]"></i>

                        <p class="text-sm font-bold">
                            لا توجد أوقات تدريب مرتبطة
                        </p>

                        @can('update', $game)

                            <a href="{{ route('games.edit', $game) }}"
                                class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-[#D46417] hover:underline">

                                <i class="fa-solid fa-plus"></i>

                                إضافة أوقات تدريب

                            </a>

                        @endcan

                    </div>

                @else

                    <div class="grid gap-3 sm:grid-cols-2">

                        @foreach ($game->timeSlots as $timeSlot)

                            @php
                                $timeSlotLabel =
                                    $timeSlot->name ??
                                    \Carbon\Carbon::parse($timeSlot->start_time)->format('H:i') .
                                        ' - ' .
                                        \Carbon\Carbon::parse($timeSlot->end_time)->format('H:i');

                                $genderLabel = match ($timeSlot->gender_type) {
                                    'women_only' => 'نساء فقط',
                                    'mixed' => 'مختلط',
                                    default => $timeSlot->gender_type,
                                };
                            @endphp

                            <div
                                class="rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4">

                                <div class="flex items-start gap-3">

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#D46417]/10 text-[#D46417]">

                                        <i class="fa-regular fa-clock"></i>

                                    </div>

                                    <div class="min-w-0 flex-1">

                                        <div class="flex items-center justify-between gap-2">

                                            <h4 class="text-sm font-bold">
                                                {{ $timeSlotLabel }}
                                            </h4>

                                            <span
                                                class="text-[10px] text-[var(--color-text-muted)]">
                                                #{{ $timeSlot->id }}
                                            </span>

                                        </div>

                                        <div
                                            class="mt-2 flex flex-wrap gap-2 text-xs text-[var(--color-text-muted)]">

                                            <span>
                                                {{ \Carbon\Carbon::parse($timeSlot->start_time)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($timeSlot->end_time)->format('H:i') }}
                                            </span>

                                            <span>•</span>

                                            <span>
                                                {{ $genderLabel }}
                                            </span>

                                        </div>

                                        @if (!empty($timeSlot->days))

                                            <div class="mt-3 flex flex-wrap gap-1">

                                                @foreach ((array) $timeSlot->days as $day)

                                                    <span
                                                        class="rounded-md bg-[var(--color-surface)] px-2 py-1 text-[10px] text-[var(--color-text-muted)]">

                                                        {{ $day }}

                                                    </span>

                                                @endforeach

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>

            {{-- Dates --}}
            <div
                class="mt-8 grid gap-4 border-t border-[var(--color-border)] pt-6 text-xs text-[var(--color-text-muted)] sm:grid-cols-2">

                <div>

                    <span class="mb-1 block">
                        تاريخ الإضافة
                    </span>

                    <strong class="text-[var(--color-text)]">
                        {{ $game->created_at?->format('Y-m-d H:i') }}
                    </strong>

                </div>

                <div>

                    <span class="mb-1 block">
                        آخر تحديث
                    </span>

                    <strong class="text-[var(--color-text)]">
                        {{ $game->updated_at?->format('Y-m-d H:i') }}
                    </strong>

                </div>

            </div>

        </article>

        {{-- Delete --}}
        @can('delete', $game)

            <form
                method="POST"
                action="{{ route('games.destroy', $game) }}"
                class="mt-6 flex justify-end"
                onsubmit="return confirm('هل أنت متأكد من حذف هذه اللعبة؟');">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 text-sm font-bold text-red-400 transition hover:text-red-300">

                    <i class="fa-solid fa-trash"></i>

                    حذف اللعبة

                </button>

            </form>

        @endcan

    </div>
@endsection