@extends('layout.app')

@section('title', 'تفاصيل البصمة')
@section('page-title', 'تفاصيل البصمة')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-[#101010] border border-white/10 rounded-2xl p-6">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h1 class="text-xl font-bold text-white">
                    تفاصيل الحضور
                </h1>

                <p class="text-sm text-gray-500">
                    سجل رقم #{{ $attendance->id }}
                </p>

            </div>

            <a
                href="{{ route('attendances.index') }}"
                class="px-4 py-2 rounded-xl bg-white/5 text-gray-300">

                العودة

            </a>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

            <div class="bg-black/40 rounded-xl p-5">

                <div class="text-gray-500 text-sm">
                    الشخص
                </div>

                <div class="text-white font-bold mt-2">
                    {{ $attendance->user->fullname }}
                </div>

                <div class="text-gray-500 text-xs mt-1">
                    {{ $attendance->user->username }}
                </div>

            </div>


            <div class="bg-black/40 rounded-xl p-5">

                <div class="text-gray-500 text-sm">
                    نوع الشخص
                </div>

                <div class="text-white font-bold mt-2">

                    @switch($attendance->person_type)

                        @case('player')
                            لاعب
                            @break

                        @case('trainer')
                            مدرب
                            @break

                        @case('reception')
                            موظف استقبال
                            @break

                    @endswitch

                </div>

            </div>


            <div class="bg-black/40 rounded-xl p-5">

                <div class="text-gray-500 text-sm">
                    الحالة
                </div>

                <div class="text-white font-bold mt-2">
                    {{ $attendance->status }}
                </div>

            </div>


            <div class="bg-black/40 rounded-xl p-5">

                <div class="text-gray-500 text-sm">
                    وقت الدخول
                </div>

                <div class="text-white font-bold mt-2">
                    {{ $attendance->check_in?->format('Y-m-d H:i:s') }}
                </div>

            </div>


            <div class="bg-black/40 rounded-xl p-5">

                <div class="text-gray-500 text-sm">
                    وقت الخروج
                </div>

                <div class="text-white font-bold mt-2">
                    {{ $attendance->check_out?->format('Y-m-d H:i:s') ?? 'لم يسجل' }}
                </div>

            </div>


            <div class="bg-black/40 rounded-xl p-5">

                <div class="text-gray-500 text-sm">
                    طريقة الخروج
                </div>

                <div class="text-white font-bold mt-2">

                    @if($attendance->checkout_type === 'automatic')
                        تلقائي
                    @elseif($attendance->checkout_type === 'manual')
                        بصمة / يدوي
                    @else
                        —
                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection