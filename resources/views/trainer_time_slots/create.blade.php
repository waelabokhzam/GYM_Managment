@extends('layout.app')

@section('title', 'ربط جديد')
@section('page-title', 'ربط جديد')

@section('content')

    <div class="mx-auto max-w-3xl">

        <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

            <h2 class="mb-6 text-xl font-extrabold">

                ربط مدرب بفترة

            </h2>

            <form method="POST" action="{{ route('trainer-time-slots.store') }}" class="space-y-6">

                @csrf

                <div>

                    <label class="mb-2 block text-sm font-bold">

                        المدرب

                    </label>

                    <select name="staff_id"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        <option value="">اختر المدرب</option>

                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}">

                                {{ $trainer->user->fullname }}

                            </option>
                        @endforeach

                    </select>

                    @error('staff_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                </div>

                <div>

                    <label class="mb-2 block text-sm font-bold">

                        الفترة

                    </label>

                    <select name="time_slot_id"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        <option value="">اختر الفترة</option>

                        @foreach ($timeSlots as $slot)
                            <option value="{{ $slot->id }}">

                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}

                                -

                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}

                                ({{ $slot->gender_type == 'mixed' ? 'مختلط' : 'سيدات' }})
                            </option>
                        @endforeach

                    </select>

                    @error('time_slot_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                </div>

                <div class="flex justify-end gap-3">

                    <a href="{{ route('trainer-time-slots.index') }}"
                        class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

                        إلغاء

                    </a>

                    <button class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white hover:bg-[#b95412]">

                        حفظ الربط

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
