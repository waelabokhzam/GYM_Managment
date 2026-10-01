@extends('layout.app')

@section('title', 'تعديل الربط')
@section('page-title', 'تعديل الربط')

@section('content')

    <div class="mx-auto max-w-3xl">

        <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

            <h2 class="mb-6 text-xl font-extrabold">

                تعديل الربط

            </h2>

            <form method="POST" action="{{ route('trainer-time-slots.update', $trainerTimeSlot) }}" class="space-y-6">

                @csrf
                @method('PUT')

                <div>

                    <label class="mb-2 block text-sm font-bold">

                        المدرب

                    </label>

                    <select name="staff_id"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}" @selected($trainer->id == $trainerTimeSlot->staff_id)>

                                {{ $trainer->user->fullname }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="mb-2 block text-sm font-bold">

                        الفترة

                    </label>

                    <select name="time_slot_id"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        @foreach ($timeSlots as $slot)
                            <option value="{{ $slot->id }}" @selected($slot->id == $trainerTimeSlot->time_slot_id)>

                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}

                                -

                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}

                                ({{ $slot->gender_type == 'mixed' ? 'مختلط' : 'سيدات' }})
                            </option>
                        @endforeach

                    </select>
                    @error('time_slot_id')
                        <p class="mt-2 text-sm font-medium text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div class="flex justify-end gap-3">

                    <a href="{{ route('trainer-time-slots.index') }}"
                        class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

                        إلغاء

                    </a>

                    <button class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white hover:bg-[#b95412]">

                        حفظ التعديلات

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
