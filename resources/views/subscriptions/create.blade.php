@extends('layout.app')

@section('title','إضافة اشتراك')
@section('page-title','إضافة اشتراك')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

        <h2 class="mb-6 text-xl font-extrabold">
            إنشاء اشتراك جديد
        </h2>

        <form method="POST"
              action="{{ route('subscriptions.store') }}"
              class="space-y-6">

            @csrf

            <div class="grid gap-6 md:grid-cols-2">

                {{-- Player --}}
                <div>
                    <label class="mb-2 block text-sm font-bold">
                        اللاعب
                    </label>

                    <select
                        name="player_id"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        <option value="">
                            اختر لاعب
                        </option>

                        @foreach($players as $player)

                            <option value="{{ $player->id }}"
                                @selected(old('player_id') == $player->id)>

                                {{ $player->user->fullname }}
                                (#{{ $player->unique_number }})

                            </option>

                        @endforeach

                    </select>

                    @error('player_id')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Subscription Type --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        نوع الاشتراك
                    </label>

                    <select
                        name="sub_type"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        <option value="monthly"
                            @selected(old('sub_type', 'monthly') == 'monthly')}>
                            شهري
                        </option>

                        <option value="daily"
                            @selected(old('sub_type') == 'daily')}>
                            يومي
                        </option>

                        <option value="offers"
                            @selected(old('sub_type') == 'offers')}>
                            عرض
                        </option>

                        <option value="special"
                            @selected(old('sub_type') == 'special')}>
                            خاص
                        </option>

                    </select>

                    @error('sub_type')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Registration Type --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        نوع التسجيل
                    </label>

                    <select
                        name="registration_type"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        <option value="new"
                            @selected(old('registration_type', 'new') == 'new')}>
                            أول مرة
                        </option>

                        <option value="renew"
                            @selected(old('registration_type') == 'renew')}>
                            تجديد
                        </option>

                    </select>

                    @error('registration_type')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Amount --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        مبلغ الاشتراك
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            name="amount"
                            value="{{ old('amount') }}"
                            step="0.01"
                            min="0.01"
                            placeholder="مثال: 150.00"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3 pl-16 outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-[var(--color-text-muted)]">
                            SYP
                        </span>

                    </div>

                    @error('amount')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Start Date --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        تاريخ البداية
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date', date('Y-m-d')) }}"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                    @error('start_date')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Trainer (يظهر بس لما sub_type = special) --}}
<div id="trainer-field" style="display: none;">

    <label class="mb-2 block text-sm font-bold">
        المدرب
    </label>

    <select
        name="trainer_id"
        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

        <option value="">
            اختر مدرب
        </option>

        @foreach($trainers as $trainer)

            <option value="{{ $trainer->id }}"
                @selected(old('trainer_id') == $trainer->id)>

                {{ $trainer->user->fullname }}

            </option>

        @endforeach

    </select>

    @error('trainer_id')
        <p class="mt-1 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror

</div>

            </div>


            {{-- Actions --}}
            <div class="flex justify-end gap-3">

                <a href="{{ route('subscriptions.index') }}"
                   class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

                    إلغاء

                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white hover:bg-[#b95412]">

                    حفظ الاشتراك

                </button>

            </div>

        </form>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subTypeSelect = document.querySelector('select[name="sub_type"]');
        const trainerField = document.getElementById('trainer-field');

        function toggleTrainerField() {
            if (subTypeSelect.value === 'special') {
                trainerField.style.display = 'block';
            } else {
                trainerField.style.display = 'none';
            }
        }

        // تشغيل فوري عند تحميل الصفحة (حالة إعادة تحميل الفورم بعد خطأ تحقق مثلاً)
        toggleTrainerField();

        subTypeSelect.addEventListener('change', toggleTrainerField);
    });
</script>

@endsection
