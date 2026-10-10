@extends('layout.app')

@section('title', 'تعديل البصمة')
@section('page-title', 'تعديل البصمة')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-[#101010] border border-white/10 rounded-2xl p-6">

        <form
            method="POST"
            action="{{ route('attendances.update', $attendance) }}"
            class="space-y-5">

            @csrf
            @method('PUT')


            <div>

                <label class="block text-sm text-gray-400 mb-2">
                    الشخص
                </label>

                <select
                    name="user_id"
                    required
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3">

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected($attendance->user_id == $user->id)
                        >
                            {{ $user->fullname }}
                            —
                            {{ $user->username }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="grid md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm text-gray-400 mb-2">
                        الدخول
                    </label>

                    <input
                        type="datetime-local"
                        name="check_in"
                        value="{{ $attendance->check_in?->format('Y-m-d\TH:i') }}"
                        required
                        class="w-full rounded-xl bg-black border border-white/10
                               text-white px-4 py-3">

                </div>


                <div>

                    <label class="block text-sm text-gray-400 mb-2">
                        الخروج
                    </label>

                    <input
                        type="datetime-local"
                        name="check_out"
                        value="{{ $attendance->check_out?->format('Y-m-d\TH:i') }}"
                        class="w-full rounded-xl bg-black border border-white/10
                               text-white px-4 py-3">

                </div>

            </div>


            <div>

                <label class="block text-sm text-gray-400 mb-2">
                    الحالة
                </label>

                <select
                    name="status"
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3">

                    <option value="open"
                        @selected($attendance->status === 'open')>
                        مفتوح
                    </option>

                    <option value="completed"
                        @selected($attendance->status === 'completed')>
                        مكتمل
                    </option>

                    <option value="auto_closed"
                        @selected($attendance->status === 'auto_closed')>
                        مغلق تلقائياً
                    </option>

                </select>

            </div>


            <div>

                <label class="block text-sm text-gray-400 mb-2">
                    الفترة
                </label>

                <select
                    name="time_slot_id"
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3">

                    <option value="">
                        بدون فترة
                    </option>

                    @foreach($timeSlots as $slot)

                        <option
                            value="{{ $slot->id }}"
                            @selected($attendance->time_slot_id == $slot->id)
                        >
                            {{ $slot->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div>

                <label class="block text-sm text-gray-400 mb-2">
                    اللعبة
                </label>

                <select
                    name="game_id"
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3">

                    <option value="">
                        بدون لعبة
                    </option>

                    @foreach($games as $game)

                        <option
                            value="{{ $game->id }}"
                            @selected($attendance->game_id == $game->id)
                        >
                            {{ $game->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('attendances.index') }}"
                    class="px-5 py-3 rounded-xl bg-white/5 text-gray-300">

                    إلغاء

                </a>

                <button
                    class="px-6 py-3 rounded-xl
                           bg-[var(--color-orange)] text-white font-bold">

                    حفظ التعديلات

                </button>

            </div>

        </form>

    </div>

</div>

@endsection