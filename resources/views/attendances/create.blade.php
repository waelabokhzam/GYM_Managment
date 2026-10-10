@extends('layout.app')

@section('title', 'تسجيل بصمة')
@section('page-title', 'تسجيل بصمة')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-[#101010] border border-white/10 rounded-2xl p-6">

        <div class="mb-6">

            <h1 class="text-xl font-bold text-white">
                تسجيل حضور يدوي
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                يمكن استخدام هذه الصفحة حالياً إلى حين ربط جهاز ZKTeco ZK4500.
            </p>

        </div>


        @if(session('error'))

            <div class="mb-5 p-4 rounded-xl bg-red-500/10
                        border border-red-500/20 text-red-400">

                {{ session('error') }}

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('attendances.store') }}"
            class="space-y-5">

            @csrf


            <div>

                <label class="block text-sm text-gray-400 mb-2">
                    الشخص
                </label>

                <select
                    name="user_id"
                    required
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3">

                    <option value="">
                        اختر الشخص
                    </option>

                    @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected(old('user_id') == $user->id)
                        >
                            {{ $user->fullname }}
                            —
                            {{ $user->username }}
                        </option>

                    @endforeach

                </select>

                @error('user_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm text-gray-400 mb-2">
                        وقت الدخول
                    </label>

                    <input
                        type="datetime-local"
                        name="check_in"
                        value="{{ old('check_in', now()->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-xl bg-black border border-white/10
                               text-white px-4 py-3">

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
                                @selected(old('time_slot_id') == $slot->id)
                            >
                                {{ $slot->name }}
                                —
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                            </option>

                        @endforeach

                    </select>

                </div>

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
                            @selected(old('game_id') == $game->id)
                        >
                            {{ $game->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div>

                <label class="block text-sm text-gray-400 mb-2">
                    ملاحظات
                </label>

                <textarea
                    name="notes"
                    rows="4"
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3"
                >{{ old('notes') }}</textarea>

            </div>


            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('attendances.index') }}"
                    class="px-5 py-3 rounded-xl bg-white/5 text-gray-300">

                    إلغاء

                </a>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl
                           bg-[var(--color-orange)] text-white font-bold">

                    <i class="fa-solid fa-fingerprint ml-1"></i>

                    تسجيل البصمة

                </button>

            </div>

        </form>

    </div>

</div>

@endsection