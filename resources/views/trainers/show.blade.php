@extends('layout.app')

@section('title', 'بيانات المدرب')

@section('page-title', 'بيانات المدرب')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- Back --}}

    <a
        href="{{ route('trainers.index') }}"
        class="
            inline-flex
            items-center
            gap-2
            text-sm
            text-[var(--color-text-muted)]
            transition
            hover:text-[#D46417]
        "
    >
        <i class="fa-solid fa-arrow-right"></i>
        العودة إلى المدربين
    </a>


    {{-- Profile Header --}}

    <div
        class="
            overflow-hidden
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
        "
    >

        <div
            class="
                border-b
                border-[var(--color-border)]
                p-6
            "
        >

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-4">

                    <div
                        class="
                            flex
                            h-16
                            w-16
                            shrink-0
                            items-center
                            justify-center
                            rounded-2xl
                            bg-[#D46417]
                            text-2xl
                            font-extrabold
                            text-white
                            shadow-lg
                            shadow-[#D46417]/20
                        "
                    >
                        {{ mb_substr($trainer->user->fullname, 0, 1) }}
                    </div>

                    <div>

                        <h2 class="text-xl font-extrabold">
                            {{ $trainer->user->fullname }}
                        </h2>

                        <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                            مدرب
                        </p>

                    </div>

                </div>


                <div class="flex items-center gap-2">

                    @can('update', $trainer)

                        <a
                            href="{{ route('trainers.edit', $trainer) }}"
                            class="
                                inline-flex
                                items-center
                                gap-2
                                rounded-xl
                                bg-[#D46417]
                                px-5
                                py-3
                                text-sm
                                font-bold
                                text-white
                                transition
                                hover:bg-[#b95412]
                            "
                        >
                            <i class="fa-solid fa-pen"></i>
                            تعديل
                        </a>

                    @endcan

                </div>

            </div>

        </div>


        {{-- Information --}}

        <div class="grid gap-4 p-6 md:grid-cols-2 lg:grid-cols-3">


            {{-- Username --}}

            <div class="info-card">

                <div class="info-icon">
                    <i class="fa-solid fa-at"></i>
                </div>

                <div>

                    <div class="info-label">
                        اسم المستخدم
                    </div>

                    <div class="info-value">
                        {{ $trainer->user->username }}
                    </div>

                </div>

            </div>


            {{-- Phone --}}

            <div class="info-card">

                <div class="info-icon">
                    <i class="fa-solid fa-phone"></i>
                </div>

                <div>

                    <div class="info-label">
                        رقم الهاتف
                    </div>

                    <div class="info-value">
                        {{ $trainer->user->phone }}
                    </div>

                </div>

            </div>


            {{-- Salary Type --}}

            <div class="info-card">

                <div class="info-icon">
                    <i class="fa-solid fa-money-bill"></i>
                </div>

                <div>

                    <div class="info-label">
                        نوع الأجر
                    </div>

                    <div class="info-value">

                        @if ($trainer->salary_type === 'fixed')

                            راتب ثابت

                        @else

                            نسبة

                        @endif

                    </div>

                </div>

            </div>


            {{-- Salary --}}

            <div class="info-card">

                <div class="info-icon">
                    <i class="fa-solid fa-coins"></i>
                </div>

                <div>

                    <div class="info-label">
                        قيمة الأجر
                    </div>

                    <div class="info-value">

                        {{ number_format($trainer->base_salary, 2) }}

                        @if ($trainer->salary_type === 'percentage')
                            %
                        @endif

                    </div>

                </div>

            </div>


            {{-- Created --}}

            <div class="info-card">

                <div class="info-icon">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>

                <div>

                    <div class="info-label">
                        تاريخ الإضافة
                    </div>

                    <div class="info-value">
                        {{ $trainer->created_at?->format('Y-m-d') }}
                    </div>

                </div>

            </div>


            {{-- ID --}}

            <div class="info-card">

                <div class="info-icon">
                    <i class="fa-solid fa-hashtag"></i>
                </div>

                <div>

                    <div class="info-label">
                        رقم السجل
                    </div>

                    <div class="info-value">
                        #{{ $trainer->id }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Danger Zone --}}

    @can('delete', $trainer)

        <div
            class="
                rounded-2xl
                border
                border-red-500/20
                bg-red-500/5
                p-6
            "
        >

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h3 class="font-extrabold text-red-400">
                        حذف المدرب
                    </h3>

                    <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                        سيتم حذف حساب المدرب وبياناته.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('trainers.destroy', $trainer) }}"
                    onsubmit="return confirm('هل أنت متأكد من حذف هذا المدرب؟');"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="
                            rounded-xl
                            border
                            border-red-500/30
                            px-5
                            py-3
                            text-sm
                            font-bold
                            text-red-400
                            transition
                            hover:bg-red-500/10
                        "
                    >
                        <i class="fa-solid fa-trash ml-2"></i>
                        حذف المدرب
                    </button>

                </form>

            </div>

        </div>

    @endcan

</div>


@push('styles')

<style>

    .info-card {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        border: 1px solid var(--color-border);
        border-radius: 1rem;
        padding: 1rem;
        background: var(--color-background);
    }

    .info-icon {
        display: flex;
        width: 2.75rem;
        height: 2.75rem;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        background: rgba(212, 100, 23, 0.10);
        color: #D46417;
    }

    .info-label {
        font-size: 0.7rem;
        color: var(--color-text-muted);
    }

    .info-value {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        font-weight: 700;
    }

</style>

@endpush

@endsection