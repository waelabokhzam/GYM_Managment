@extends('layout.app')

@section('title', 'إضافة لعبة')
@section('page-title', 'إضافة لعبة جديدة')

@section('content')
    <div class="mx-auto max-w-4xl">

        {{-- Header --}}
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('games.index') }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                title="العودة">
                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div>
                <h2 class="text-xl font-extrabold">
                    إضافة لعبة جديدة
                </h2>

                <p class="text-sm text-[var(--color-text-muted)]">
                    أدخل بيانات اللعبة وحدد أوقات التدريب التي تتوفر فيها.
                </p>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST"
            action="{{ route('games.store') }}"
            enctype="multipart/form-data"
            class="space-y-6 rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 sm:p-7">

            @csrf

            {{-- Validation Errors --}}
            @include('game.partials.form-errors')

            {{-- Game Name --}}
            <div>
                <label for="name" class="mb-2 block text-sm font-bold">
                    اسم اللعبة
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="مثال: ألعاب الحديد"
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition placeholder:text-[var(--color-text-muted)] focus:border-[#D46417]">

                @error('name')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
        <label for="image" class="mb-2 block text-sm font-bold">
            صورة اللعبة / الكلاس
        </label>

        <input
            id="image"
            name="image"
            type="file"
            accept="image/*"
            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#D46417] file:text-white hover:file:bg-[#b95714] cursor-pointer outline-none transition">

        @error('image')
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
                    placeholder="اكتب وصفًا مختصرًا عن اللعبة أو النشاط الرياضي..."
                    class="w-full resize-y rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm leading-7 text-[var(--color-text)] outline-none transition placeholder:text-[var(--color-text-muted)] focus:border-[#D46417]">{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Time Slots --}}
            <div>

                {{-- Section Header --}}
                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <label class="block text-sm font-bold">
                            أوقات التدريب
                        </label>

                        <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                            حدد جميع الفترات التي تتوفر فيها هذه اللعبة.
                        </p>
                    </div>

                    <span
                        class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">
                        <i class="fa-solid fa-list-check"></i>
                        اختيار متعدد
                    </span>

                </div>

                @if ($timeSlots->isEmpty())

                    {{-- No Time Slots --}}
                    <div
                        class="rounded-xl border border-dashed border-[var(--color-border)] bg-[var(--color-background)] px-5 py-10 text-center">

                        <div
                            class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-[#D46417]/10 text-xl text-[#D46417]">
                            <i class="fa-regular fa-clock"></i>
                        </div>

                        <h3 class="text-sm font-bold">
                            لا توجد أوقات تدريب
                        </h3>

                        <p class="mt-2 text-xs leading-6 text-[var(--color-text-muted)]">
                            لا يمكن ربط اللعبة بأي فترة حاليًا.
                            <br>
                            قم بإضافة وقت تدريب أولًا.
                        </p>

                        @can('create', App\Models\TimeSlot::class)
                            <a href="{{ route('timeslots.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-4 py-2.5 text-xs font-bold text-white transition hover:bg-[#b95714]">
                                <i class="fa-solid fa-plus"></i>
                                إضافة وقت تدريب
                            </a>
                        @endcan

                    </div>

                @else

                    {{-- Time Slots Grid --}}
                    <div class="grid gap-3 sm:grid-cols-2">

                        @foreach ($timeSlots as $timeSlot)

                            @php
                                $startTime = \Carbon\Carbon::parse($timeSlot->start_time)->format('H:i');
                                $endTime = \Carbon\Carbon::parse($timeSlot->end_time)->format('H:i');

                                $genderLabel = match ($timeSlot->gender_type) {
                                    'women_only' => 'نساء فقط',
                                    'mixed' => 'مختلط',
                                    default => $timeSlot->gender_type,
                                };

                                $isChecked = in_array(
                                    $timeSlot->id,
                                    old('time_slots', [])
                                );
                            @endphp

                            <label
                                class="group flex cursor-pointer items-start gap-3 rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4 transition hover:border-[#D46417]/60 hover:bg-[#D46417]/5">

                                {{-- Checkbox --}}
                                <input
                                    type="checkbox"
                                    name="time_slots[]"
                                    value="{{ $timeSlot->id }}"
                                    @checked($isChecked)
                                    class="mt-1 h-4 w-4 shrink-0 rounded border-[var(--color-border)] text-[#D46417] focus:ring-2 focus:ring-[#D46417]/30">

                                {{-- Time Slot Information --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-2">

                                        <div class="min-w-0">

                                            @if (isset($timeSlot->name) && $timeSlot->name)
                                                <h3 class="truncate text-sm font-bold">
                                                    {{ $timeSlot->name }}
                                                </h3>
                                            @else
                                                <h3 class="text-sm font-bold">
                                                    الفترة التدريبية
                                                </h3>
                                            @endif

                                        </div>

                                        <span
                                            class="shrink-0 rounded-md bg-[#D46417]/10 px-2 py-1 text-[10px] font-bold text-[#D46417]">
                                            #{{ $timeSlot->id }}
                                        </span>

                                    </div>

                                    {{-- Time --}}
                                    <div
                                        class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-[var(--color-text-muted)]">

                                        <span class="inline-flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock text-[#D46417]"></i>

                                            {{ $startTime }} - {{ $endTime }}
                                        </span>

                                        <span class="text-[var(--color-border)]">
                                            |
                                        </span>

                                        {{-- Gender --}}
                                        <span class="inline-flex items-center gap-1.5">

                                            <i class="fa-solid fa-users text-[#D46417]"></i>

                                            {{ $genderLabel }}

                                        </span>

                                    </div>

                                    {{-- Days --}}
                                    @if (!empty($timeSlot->days))

                                        <div class="mt-3 flex flex-wrap gap-1.5">

                                            @foreach ((array) $timeSlot->days as $day)

                                                <span
                                                    class="rounded-md bg-[var(--color-surface)] px-2 py-1 text-[10px] font-medium text-[var(--color-text-muted)]">
                                                    {{ $day }}
                                                </span>

                                            @endforeach

                                        </div>

                                    @endif

                                </div>

                            </label>

                        @endforeach

                    </div>

                    {{-- Time Slots Validation --}}
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

                    <p class="mt-3 flex items-center gap-2 text-xs text-[var(--color-text-muted)]">
                        <i class="fa-solid fa-circle-info text-[#D46417]"></i>
                        يمكنك اختيار أكثر من فترة تدريب لنفس اللعبة.
                    </p>

                @endif

            </div>

            {{-- Form Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-5 sm:flex-row sm:justify-end">

                <a href="{{ route('games.index') }}"
                    class="rounded-xl border border-[var(--color-border)] px-6 py-3 text-center text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">
                    إلغاء
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95714]">

                    <i class="fa-solid fa-check me-2"></i>

                    حفظ اللعبة

                </button>

            </div>

        </form>

    </div>
@endsection
