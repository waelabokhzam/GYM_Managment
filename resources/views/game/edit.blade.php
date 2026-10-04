@extends('layout.app')

@section('title', 'تعديل اللعبة')
@section('page-title', 'تعديل اللعبة')

@section('content')
    <div class="mx-auto max-w-4xl">

        {{-- Header --}}
        <div class="mb-6 flex items-center gap-3">

            <a href="{{ route('games.show', $game) }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                title="العودة">
                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div>
                <h2 class="text-xl font-extrabold">
                    تعديل {{ $game->name }}
                </h2>

                <p class="text-sm text-[var(--color-text-muted)]">
                    حدّث بيانات اللعبة وأوقات التدريب المرتبطة بها.
                </p>
            </div>

        </div>

        @php
            $selectedTimeSlots = old(
                'time_slots',
                $game->timeSlots->pluck('id')->toArray()
            );
        @endphp

        <form method="POST"
            action="{{ route('games.update', $game) }}"
            class="space-y-6 rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 sm:p-7">

            @csrf
            @method('PUT')

            @include('game.partials.form-errors')

            {{-- Name --}}
            <div>

                <label for="name" class="mb-2 block text-sm font-bold">
                    اسم اللعبة
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $game->name) }}"
                    required
                    autofocus
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition focus:border-[#D46417]">

                @error('name')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Description --}}
            <div>

                <label for="description" class="mb-2 block text-sm font-bold">
                    وصف اللعبة
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    required
                    class="w-full resize-y rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm leading-7 text-[var(--color-text)] outline-none transition focus:border-[#D46417]">{{ old('description', $game->description) }}</textarea>

                @error('description')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Time Slots --}}
            <div>

                <div class="mb-3">
                    <label class="block text-sm font-bold">
                        أوقات التدريب
                    </label>

                    <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                        حدد جميع الأوقات التي تتوفر فيها هذه اللعبة.
                    </p>
                </div>

                @if ($timeSlots->isEmpty())

                    <div
                        class="rounded-xl border border-dashed border-[var(--color-border)] bg-[var(--color-background)] px-5 py-8 text-center">

                        <i class="fa-regular fa-clock mb-3 text-2xl text-[var(--color-text-muted)]"></i>

                        <p class="text-sm font-bold">
                            لا توجد أوقات تدريب متاحة
                        </p>

                    </div>

                @else

                    <div class="grid gap-3 sm:grid-cols-2">

                        @foreach ($timeSlots as $timeSlot)

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

                            <label
                                class="flex cursor-pointer items-start gap-3 rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4 transition hover:border-[#D46417]/60">

                                <input
                                    type="checkbox"
                                    name="time_slots[]"
                                    value="{{ $timeSlot->id }}"
                                    class="mt-1 h-4 w-4 shrink-0 rounded border-[var(--color-border)] text-[#D46417] focus:ring-[#D46417]"
                                    {{ in_array($timeSlot->id, $selectedTimeSlots) ? 'checked' : '' }}>

                                <div class="min-w-0 flex-1">

                                    <div class="flex items-center justify-between gap-2">

                                        <h4 class="truncate text-sm font-bold">
                                            {{ $timeSlotLabel }}
                                        </h4>

                                        <span
                                            class="shrink-0 rounded-lg bg-[#D46417]/10 px-2 py-1 text-[10px] font-bold text-[#D46417]">
                                            #{{ $timeSlot->id }}
                                        </span>

                                    </div>

                                    <div
                                        class="mt-2 flex flex-wrap items-center gap-2 text-xs text-[var(--color-text-muted)]">

                                        <span class="inline-flex items-center gap-1">
                                            <i class="fa-regular fa-clock"></i>

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

                                        <div class="mt-2 flex flex-wrap gap-1">

                                            @foreach ((array) $timeSlot->days as $day)

                                                <span
                                                    class="rounded-md bg-[var(--color-surface)] px-2 py-1 text-[10px] text-[var(--color-text-muted)]">
                                                    {{ $day }}
                                                </span>

                                            @endforeach

                                        </div>

                                    @endif

                                </div>

                            </label>

                        @endforeach

                    </div>

                @endif

                @error('time_slots')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

                @error('time_slots.*')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-5 sm:flex-row sm:justify-end">

                <a href="{{ route('games.show', $game) }}"
                    class="rounded-xl border border-[var(--color-border)] px-6 py-3 text-center text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">
                    إلغاء
                </a>

                <button type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#b95714]">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    حفظ التغييرات
                </button>

            </div>

        </form>

    </div>
@endsection