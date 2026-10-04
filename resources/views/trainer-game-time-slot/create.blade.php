@extends('layout.app')

@section('title', 'إضافة تعيين مدرب')
@section('page-title', 'إضافة تعيين مدرب')

@section('content')
    <div class="mx-auto max-w-4xl">

        {{-- Header --}}
        <div class="mb-6 flex items-center gap-3">

            <a href="{{ route('trainer-game-time-slots.index') }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]"
                title="العودة">

                <i class="fa-solid fa-arrow-right"></i>

            </a>

            <div>
                <h2 class="text-xl font-extrabold">
                    إضافة تعيين مدرب
                </h2>

                <p class="text-sm text-[var(--color-text-muted)]">
                    حدد الفترة واللعبة والمدرب المسؤول عنها.
                </p>
            </div>

        </div>

        {{-- Form --}}
        <form method="POST"
            action="{{ route('trainer-game-time-slots.store') }}"
            class="space-y-6 rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 sm:p-7">

            @csrf

            @include('trainer-game-time-slot.partials.form-errors')

            {{-- Information --}}
            <div
                class="rounded-xl border border-[#D46417]/20 bg-[#D46417]/5 p-4">

                <div class="flex gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#D46417]/10 text-[#D46417]">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold">
                            تعيين المدرب للعبة
                        </h3>

                        <p class="mt-1 text-xs leading-6 text-[var(--color-text-muted)]">
                            اختر الفترة أولًا، وسيتم عرض الألعاب المرتبطة بهذه الفترة فقط.
                            بعد ذلك اختر المدرب المسؤول عن اللعبة.
                        </p>
                    </div>

                </div>

            </div>

            {{-- Time Slot --}}
            <div>

                <label for="time_slot_id" class="mb-2 block text-sm font-bold">
                    الفترة التدريبية
                </label>

                <select id="time_slot_id"
                    name="time_slot_id"
                    required
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition focus:border-[#D46417]">

                    <option value="">
                        اختر الفترة التدريبية
                    </option>

                    @foreach ($timeSlots as $timeSlot)

                        <option value="{{ $timeSlot->id }}"
                            @selected(old('time_slot_id') == $timeSlot->id)>

                            {{ $timeSlot->name }}

                            —
                            {{ \Carbon\Carbon::parse($timeSlot->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($timeSlot->end_time)->format('H:i') }}

                        </option>

                    @endforeach

                </select>

                @error('time_slot_id')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Game --}}
            <div>

                <label for="game_id" class="mb-2 block text-sm font-bold">
                    اللعبة
                </label>

                <select id="game_id"
                    name="game_id"
                    required
                    disabled
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition disabled:cursor-not-allowed disabled:opacity-50 focus:border-[#D46417]">

                    <option value="">
                        اختر الفترة أولًا
                    </option>

                </select>

                @error('game_id')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

                <p id="game-help"
                    class="mt-2 text-xs text-[var(--color-text-muted)]">

                    سيتم عرض الألعاب المرتبطة بالفترة المختارة.

                </p>

            </div>

            {{-- Trainer --}}
            <div>

                <label for="staff_id" class="mb-2 block text-sm font-bold">
                    المدرب المسؤول
                </label>

                <select id="staff_id"
                    name="staff_id"
                    required
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm text-[var(--color-text)] outline-none transition focus:border-[#D46417]">

                    <option value="">
                        اختر المدرب
                    </option>

                    @foreach ($trainers as $trainer)

                        <option value="{{ $trainer->id }}"
                            @selected(old('staff_id') == $trainer->id)>

                            {{ $trainer->user?->fullname ?? 'بدون اسم' }}

                            @if ($trainer->user?->username)
                                — {{ $trainer->user->username }}
                            @endif

                        </option>

                    @endforeach

                </select>

                @error('staff_id')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Preview --}}
            <div id="assignment-preview"
                class="hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4">

                <div class="mb-3 flex items-center gap-2">

                    <i class="fa-solid fa-eye text-[#D46417]"></i>

                    <span class="text-sm font-bold">
                        معاينة التعيين
                    </span>

                </div>

                <div class="grid gap-3 sm:grid-cols-3">

                    <div>
                        <span class="block text-[10px] text-[var(--color-text-muted)]">
                            الفترة
                        </span>

                        <strong id="preview-slot"
                            class="mt-1 block text-sm">
                            -
                        </strong>
                    </div>

                    <div>
                        <span class="block text-[10px] text-[var(--color-text-muted)]">
                            اللعبة
                        </span>

                        <strong id="preview-game"
                            class="mt-1 block text-sm">
                            -
                        </strong>
                    </div>

                    <div>
                        <span class="block text-[10px] text-[var(--color-text-muted)]">
                            المدرب
                        </span>

                        <strong id="preview-trainer"
                            class="mt-1 block text-sm">
                            -
                        </strong>
                    </div>

                </div>

            </div>

            {{-- Actions --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-[var(--color-border)] pt-5 sm:flex-row sm:justify-end">

                <a href="{{ route('trainer-game-time-slots.index') }}"
                    class="rounded-xl border border-[var(--color-border)] px-6 py-3 text-center text-sm font-bold text-[var(--color-text-muted)] transition hover:border-[#D46417] hover:text-[#D46417]">

                    إلغاء

                </a>

                <button type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95714]">

                    <i class="fa-solid fa-check me-2"></i>

                    حفظ التعيين

                </button>

            </div>

        </form>

    </div>

    {{-- Data --}}
    <script>
    const timeSlots = @json($timeSlotsData);

    const slotSelect = document.getElementById('time_slot_id');
    const gameSelect = document.getElementById('game_id');
    const trainerSelect = document.getElementById('staff_id');

    const preview = document.getElementById('assignment-preview');
    const previewSlot = document.getElementById('preview-slot');
    const previewGame = document.getElementById('preview-game');
    const previewTrainer = document.getElementById('preview-trainer');

    const oldGameId = @json(old('game_id'));

    /**
     * تحديث الألعاب حسب الفترة المختارة
     */
    function updateGames() {

        const slotId = Number(slotSelect.value);

        gameSelect.innerHTML = '';

        // لم يتم اختيار فترة
        if (!slotId) {

            gameSelect.disabled = true;

            const option = document.createElement('option');

            option.value = '';
            option.textContent = 'اختر الفترة أولًا';

            gameSelect.appendChild(option);

            updatePreview();

            return;
        }

        const slot = timeSlots.find(
            item => Number(item.id) === slotId
        );

        gameSelect.disabled = false;

        // الخيار الافتراضي
        const defaultOption = document.createElement('option');

        defaultOption.value = '';
        defaultOption.textContent = 'اختر اللعبة';

        gameSelect.appendChild(defaultOption);

        // لا توجد ألعاب
        if (!slot || !slot.games || !slot.games.length) {

            const emptyOption = document.createElement('option');

            emptyOption.value = '';
            emptyOption.textContent =
                'لا توجد ألعاب مرتبطة بهذه الفترة';

            gameSelect.appendChild(emptyOption);

            gameSelect.disabled = true;

            updatePreview();

            return;
        }

        // إضافة الألعاب
        slot.games.forEach(game => {

            const option = document.createElement('option');

            option.value = game.id;
            option.textContent = game.name;

            if (
                oldGameId &&
                String(game.id) === String(oldGameId)
            ) {
                option.selected = true;
            }

            gameSelect.appendChild(option);
        });

        updatePreview();
    }

    /**
     * تحديث المعاينة
     */
    function updatePreview() {

        const hasSlot =
            slotSelect.value !== '';

        const hasGame =
            gameSelect.value !== '';

        const hasTrainer =
            trainerSelect.value !== '';

        // لا يوجد شيء محدد
        if (!hasSlot && !hasGame && !hasTrainer) {

            preview.classList.add('hidden');

            return;
        }

        preview.classList.remove('hidden');

        // الفترة
        if (hasSlot) {

            const slotOption =
                slotSelect.options[
                    slotSelect.selectedIndex
                ];

            previewSlot.textContent =
                slotOption.textContent.trim();

        } else {

            previewSlot.textContent = '-';

        }

        // اللعبة
        if (hasGame) {

            const gameOption =
                gameSelect.options[
                    gameSelect.selectedIndex
                ];

            previewGame.textContent =
                gameOption.textContent.trim();

        } else {

            previewGame.textContent = '-';

        }

        // المدرب
        if (hasTrainer) {

            const trainerOption =
                trainerSelect.options[
                    trainerSelect.selectedIndex
                ];

            previewTrainer.textContent =
                trainerOption.textContent.trim();

        } else {

            previewTrainer.textContent = '-';

        }
    }

    /**
     * عند تغيير الفترة
     */
    slotSelect.addEventListener('change', function () {

        updateGames();

    });

    /**
     * عند تغيير اللعبة
     */
    gameSelect.addEventListener('change', function () {

        updatePreview();

    });

    /**
     * عند تغيير المدرب
     */
    trainerSelect.addEventListener('change', function () {

        updatePreview();

    });

    /**
     * تشغيل أولي
     */
    updateGames();

    updatePreview();
</script>
@endsection