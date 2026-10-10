@extends('layout.app')

@section('title', 'البصمات')
@section('page-title', 'إدارة البصمات والحضور')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-white">
                سجل البصمات
            </h1>

            <p class="text-sm text-gray-400 mt-1">
                متابعة دخول وخروج اللاعبين والمدربين وموظفي الاستقبال
            </p>
        </div>

        @can('attendance.create')
            <a href="{{ route('attendances.create') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                      bg-[var(--color-orange)] hover:opacity-90 text-white font-bold transition">

                <i class="fa-solid fa-fingerprint"></i>

                تسجيل بصمة
            </a>
        @endcan

    </div>


    {{-- Filters --}}
    <div class="bg-[#101010] border border-white/10 rounded-2xl p-5">

        <form method="GET"
              action="{{ route('attendances.index') }}"
              class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    بحث
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="اسم اللاعب أو اسم المستخدم..."
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3 focus:border-[var(--color-orange)] focus:ring-1
                           focus:ring-[var(--color-orange)]">
            </div>

            @if(!auth()->user()->hasRole('player'))

                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        نوع الشخص
                    </label>

                    <select
                        name="person_type"
                        class="w-full rounded-xl bg-black border border-white/10
                               text-white px-4 py-3">

                        <option value="">الكل</option>

                        <option value="player"
                            @selected(request('person_type') === 'player')>
                            لاعب
                        </option>

                        <option value="trainer"
                            @selected(request('person_type') === 'trainer')>
                            مدرب
                        </option>

                        <option value="reception"
                            @selected(request('person_type') === 'reception')>
                            استقبال
                        </option>

                    </select>
                </div>

            @endif


            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    الحالة
                </label>

                <select
                    name="status"
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3">

                    <option value="">كل الحالات</option>

                    <option value="open"
                        @selected(request('status') === 'open')>
                        مفتوح
                    </option>

                    <option value="completed"
                        @selected(request('status') === 'completed')>
                        مكتمل
                    </option>

                    <option value="auto_closed"
                        @selected(request('status') === 'auto_closed')>
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

                    <option value="">كل الفترات</option>

                    @foreach($timeSlots as $slot)

                        <option
                            value="{{ $slot->id }}"
                            @selected((string) request('time_slot_id') === (string) $slot->id)
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


            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    من تاريخ
                </label>

                <input
                    type="date"
                    name="date_from"
                    value="{{ request('date_from') }}"
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3">
            </div>


            <div>
                <label class="block text-sm text-gray-400 mb-2">
                    إلى تاريخ
                </label>

                <input
                    type="date"
                    name="date_to"
                    value="{{ request('date_to') }}"
                    class="w-full rounded-xl bg-black border border-white/10
                           text-white px-4 py-3">
            </div>


            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="flex-1 px-4 py-3 rounded-xl
                           bg-[var(--color-orange)] text-white font-bold">

                    <i class="fa-solid fa-filter ml-1"></i>
                    فلترة
                </button>

                <a
                    href="{{ route('attendances.index') }}"
                    class="px-4 py-3 rounded-xl bg-white/5
                           text-gray-300 hover:bg-white/10">

                    <i class="fa-solid fa-rotate-right"></i>

                </a>

            </div>

        </form>

    </div>


    {{-- Table --}}
    <div class="bg-[#101010] border border-white/10 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-right">

                <thead class="bg-white/5 text-gray-400 text-sm">

                    <tr>

                        <th class="px-5 py-4">الشخص</th>

                        <th class="px-5 py-4">النوع</th>

                        <th class="px-5 py-4">الدخول</th>

                        <th class="px-5 py-4">الخروج</th>

                        <th class="px-5 py-4">الفترة</th>

                        <th class="px-5 py-4">الحالة</th>

                        <th class="px-5 py-4">الإجراءات</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-white/5">

                @forelse($attendances as $attendance)

                    <tr class="hover:bg-white/[0.03]">

                        <td class="px-5 py-4">

                            <div class="font-bold text-white">
                                {{ $attendance->user->fullname }}
                            </div>

                            <div class="text-xs text-gray-500">
                                {{ $attendance->user->username }}
                            </div>

                        </td>


                        <td class="px-5 py-4">

                            @switch($attendance->person_type)

                                @case('player')
                                    <span class="text-blue-400">لاعب</span>
                                    @break

                                @case('trainer')
                                    <span class="text-purple-400">مدرب</span>
                                    @break

                                @case('reception')
                                    <span class="text-orange-400">استقبال</span>
                                    @break

                            @endswitch

                        </td>


                        <td class="px-5 py-4 text-gray-300">

                            {{ $attendance->check_in?->format('Y-m-d') }}

                            <div class="text-xs text-gray-500">
                                {{ $attendance->check_in?->format('H:i:s') }}
                            </div>

                        </td>


                        <td class="px-5 py-4 text-gray-300">

                            @if($attendance->check_out)

                                {{ $attendance->check_out->format('Y-m-d') }}

                                <div class="text-xs text-gray-500">
                                    {{ $attendance->check_out->format('H:i:s') }}
                                </div>

                            @else

                                <span class="text-yellow-500">
                                    لم يسجل بعد
                                </span>

                            @endif

                        </td>


                        <td class="px-5 py-4">

                            @if($attendance->timeSlot)

                                <div class="text-white">
                                    {{ $attendance->timeSlot->name }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($attendance->timeSlot->start_time)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($attendance->timeSlot->end_time)->format('H:i') }}
                                </div>

                            @else

                                <span class="text-gray-500">
                                    —
                                </span>

                            @endif

                        </td>


                        <td class="px-5 py-4">

                            @if($attendance->status === 'open')

                                <span class="px-3 py-1 rounded-full text-xs
                                             bg-yellow-500/10 text-yellow-400">
                                    مفتوح
                                </span>

                            @elseif($attendance->status === 'completed')

                                <span class="px-3 py-1 rounded-full text-xs
                                             bg-green-500/10 text-green-400">
                                    مكتمل
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs
                                             bg-blue-500/10 text-blue-400">
                                    مغلق تلقائياً
                                </span>

                            @endif

                        </td>


                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">

                                <a
                                    href="{{ route('attendances.show', $attendance) }}"
                                    class="w-9 h-9 rounded-lg bg-white/5
                                           flex items-center justify-center
                                           text-gray-300 hover:text-white">

                                    <i class="fa-solid fa-eye"></i>

                                </a>

                                @can('attendance.edit')

                                    <a
                                        href="{{ route('attendances.edit', $attendance) }}"
                                        class="w-9 h-9 rounded-lg bg-blue-500/10
                                               flex items-center justify-center
                                               text-blue-400">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>

                                @endcan

                                @can('attendance.checkout')

                                    @if($attendance->status === 'open')

                                        <form
                                            method="POST"
                                            action="{{ route('attendances.checkout', $attendance) }}">

                                            @csrf

                                            <button
                                                type="submit"
                                                title="تسجيل الخروج"
                                                class="w-9 h-9 rounded-lg bg-green-500/10
                                                       flex items-center justify-center
                                                       text-green-400">

                                                <i class="fa-solid fa-right-from-bracket"></i>

                                            </button>

                                        </form>

                                    @endif

                                @endcan

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="px-5 py-12 text-center text-gray-500">

                            لا توجد سجلات بصمات.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        <div class="px-5 py-4 border-t border-white/10">

            {{ $attendances->links() }}

        </div>

    </div>

</div>

@endsection