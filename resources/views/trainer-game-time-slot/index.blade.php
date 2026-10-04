@extends('layout.app')

@section('title', 'تعيينات المدربين')
@section('page-title', 'تعيينات المدربين')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-extrabold">
                    تعيينات المدربين
                </h2>

                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                    إدارة المدربين المسؤولين عن الألعاب ضمن الفترات التدريبية.
                </p>
            </div>

            <a href="{{ route('trainer-game-time-slots.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95714]">

                <i class="fa-solid fa-user-plus"></i>

                إضافة تعيين
            </a>

        </div>

        {{-- Success --}}
        @if (session('success'))
            <div
                class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-semibold text-emerald-400">

                <i class="fa-solid fa-circle-check me-2"></i>

                {{ session('success') }}

            </div>
        @endif

        {{-- Filters --}}
        <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

            <div class="mb-4 flex items-center gap-2">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#D46417]/10 text-[#D46417]">
                    <i class="fa-solid fa-filter"></i>
                </div>

                <div>
                    <h3 class="text-sm font-bold">
                        تصفية التعيينات
                    </h3>

                    <p class="text-xs text-[var(--color-text-muted)]">
                        ابحث حسب المدرب أو اللعبة أو الفترة.
                    </p>
                </div>
            </div>

            <form method="GET"
                action="{{ route('trainer-game-time-slots.index') }}"
                class="grid gap-3 md:grid-cols-4">

                {{-- Trainer --}}
                <div>
                    <label class="mb-2 block text-xs font-bold">
                        المدرب
                    </label>

                    <select name="staff_id"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-3 text-sm text-[var(--color-text)] outline-none focus:border-[#D46417]">

                        <option value="">
                            جميع المدربين
                        </option>

                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}"
                                @selected(request('staff_id') == $trainer->id)>
                                {{ $trainer->user?->fullname ?? 'بدون اسم' }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Game --}}
                <div>
                    <label class="mb-2 block text-xs font-bold">
                        اللعبة
                    </label>

                    <select name="game_id"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-3 text-sm text-[var(--color-text)] outline-none focus:border-[#D46417]">

                        <option value="">
                            جميع الألعاب
                        </option>

                        @foreach ($games as $game)
                            <option value="{{ $game->id }}"
                                @selected(request('game_id') == $game->id)>
                                {{ $game->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Time Slot --}}
                <div>
                    <label class="mb-2 block text-xs font-bold">
                        الفترة
                    </label>

                    <select name="time_slot_id"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-3 py-3 text-sm text-[var(--color-text)] outline-none focus:border-[#D46417]">

                        <option value="">
                            جميع الفترات
                        </option>

                        @foreach ($timeSlots as $timeSlot)
                            <option value="{{ $timeSlot->id }}"
                                @selected(request('time_slot_id') == $timeSlot->id)>
                                {{ $timeSlot->name }}
                                —
                                {{ \Carbon\Carbon::parse($timeSlot->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($timeSlot->end_time)->format('H:i') }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex items-end gap-2">

                    <button type="submit"
                        class="flex-1 rounded-xl bg-[#D46417] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#b95714]">

                        <i class="fa-solid fa-magnifying-glass me-1"></i>

                        بحث
                    </button>

                    @if (request()->hasAny([
                        'staff_id',
                        'game_id',
                        'time_slot_id',
                    ]))
                        <a href="{{ route('trainer-game-time-slots.index') }}"
                            class="rounded-xl border border-[var(--color-border)] px-4 py-3 text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">

                            <i class="fa-solid fa-xmark"></i>

                        </a>
                    @endif

                </div>

            </form>

        </div>

        {{-- Content --}}
        @if ($assignments->isEmpty())

            <div
                class="rounded-2xl border border-dashed border-[var(--color-border)] bg-[var(--color-surface)] px-6 py-16 text-center">

                <div
                    class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">

                    <i class="fa-solid fa-user-clock"></i>

                </div>

                <h2 class="text-lg font-bold">
                    لا توجد تعيينات
                </h2>

                <p class="mt-2 text-sm text-[var(--color-text-muted)]">
                    لم يتم العثور على أي تعيينات مطابقة للفلاتر الحالية.
                </p>

                <a href="{{ route('trainer-game-time-slots.create') }}"
                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95714]">

                    <i class="fa-solid fa-plus"></i>

                    إضافة أول تعيين
                </a>

            </div>

        @else

            {{-- Desktop Table --}}
            <div
                class="hidden overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] md:block">

                <div class="overflow-x-auto">

                    <table class="w-full text-right">

                        <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">

                            <tr>
                                <th class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                    المدرب
                                </th>

                                <th class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                    اللعبة
                                </th>

                                <th class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                    الفترة
                                </th>

                                <th class="px-5 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                    الوقت
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-[var(--color-text-muted)]">
                                    الإجراءات
                                </th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-[var(--color-border)]">

                            @foreach ($assignments as $assignment)

                                <tr class="transition hover:bg-[#D46417]/5">

                                    {{-- Trainer --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#D46417]/10 text-[#D46417]">

                                                <i class="fa-solid fa-user-tie"></i>

                                            </div>

                                            <div>
                                                <p class="text-sm font-bold">
                                                    {{ $assignment->trainer?->user?->fullname ?? 'غير محدد' }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-[var(--color-text-muted)]">
                                                    {{ $assignment->trainer?->user?->username ?? '-' }}
                                                </p>
                                            </div>

                                        </div>

                                    </td>

                                    {{-- Game --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-2">

                                            <div
                                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#D46417]/10 text-[#D46417]">

                                                <i class="fa-solid fa-dumbbell"></i>

                                            </div>

                                            <span class="text-sm font-bold">
                                                {{ $assignment->game?->name ?? 'غير محدد' }}
                                            </span>

                                        </div>

                                    </td>

                                    {{-- Time Slot --}}
                                    <td class="px-5 py-4">

                                        <p class="text-sm font-bold">
                                            {{ $assignment->timeSlot?->name ?? 'غير محدد' }}
                                        </p>

                                    </td>

                                    {{-- Time --}}
                                    <td class="px-5 py-4">

                                        @if ($assignment->timeSlot)

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">

                                                <i class="fa-regular fa-clock"></i>

                                                {{ \Carbon\Carbon::parse($assignment->timeSlot->start_time)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($assignment->timeSlot->end_time)->format('H:i') }}

                                            </span>

                                        @else
                                            -
                                        @endif

                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center justify-end gap-2">

                                            <a href="{{ route('trainer-game-time-slots.show', $assignment) }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                                                title="عرض">

                                                <i class="fa-solid fa-eye text-xs"></i>

                                            </a>

                                            <a href="{{ route('trainer-game-time-slots.edit', $assignment) }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                                                title="تعديل">

                                                <i class="fa-solid fa-pen text-xs"></i>

                                            </a>

                                            <form method="POST"
                                                action="{{ route('trainer-game-time-slots.destroy', $assignment) }}"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا التعيين؟');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/20 text-red-400 transition hover:bg-red-500/10"
                                                    title="حذف">

                                                    <i class="fa-solid fa-trash text-xs"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Mobile Cards --}}
            <div class="grid gap-4 md:hidden">

                @foreach ($assignments as $assignment)

                    <article
                        class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#D46417]/10 text-[#D46417]">

                                    <i class="fa-solid fa-user-tie"></i>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="truncate text-sm font-bold">
                                        {{ $assignment->trainer?->user?->fullname ?? 'غير محدد' }}
                                    </h3>

                                    <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                                        {{ $assignment->game?->name ?? 'غير محدد' }}
                                    </p>

                                </div>

                            </div>

                            <span
                                class="shrink-0 rounded-lg bg-[#D46417]/10 px-2 py-1 text-[10px] font-bold text-[#D46417]">

                                #{{ $assignment->id }}

                            </span>

                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-3">

                            <div class="rounded-xl bg-[var(--color-background)] p-3">

                                <span class="block text-[10px] text-[var(--color-text-muted)]">
                                    الفترة
                                </span>

                                <strong class="mt-1 block text-xs">
                                    {{ $assignment->timeSlot?->name ?? '-' }}
                                </strong>

                            </div>

                            <div class="rounded-xl bg-[var(--color-background)] p-3">

                                <span class="block text-[10px] text-[var(--color-text-muted)]">
                                    الوقت
                                </span>

                                <strong class="mt-1 block text-xs">
                                    @if ($assignment->timeSlot)
                                        {{ \Carbon\Carbon::parse($assignment->timeSlot->start_time)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($assignment->timeSlot->end_time)->format('H:i') }}
                                    @else
                                        -
                                    @endif
                                </strong>

                            </div>

                        </div>

                        <div class="mt-4 flex gap-2 border-t border-[var(--color-border)] pt-4">

                            <a href="{{ route('trainer-game-time-slots.show', $assignment) }}"
                                class="flex-1 rounded-xl border border-[var(--color-border)] px-3 py-2.5 text-center text-xs font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">

                                <i class="fa-solid fa-eye me-1"></i>
                                التفاصيل

                            </a>

                            <a href="{{ route('trainer-game-time-slots.edit', $assignment) }}"
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] hover:border-[#D46417] hover:text-[#D46417]">

                                <i class="fa-solid fa-pen text-xs"></i>

                            </a>

                        </div>

                    </article>

                @endforeach

            </div>

            {{-- Pagination --}}
            @if ($assignments->hasPages())
                <div>
                    {{ $assignments->links() }}
                </div>
            @endif

        @endif

    </div>
@endsection
