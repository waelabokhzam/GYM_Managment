@extends('layout.app')

@section('title','ربط المدربين بالفترات')
@section('page-title','ربط المدربين بالفترات')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-xl font-extrabold">
                إدارة ربط المدربين بالفترات
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إدارة الفترات الخاصة بكل مدرب.
            </p>
        </div>

        @can('training_periods.create')

        <a href="{{ route('trainer-time-slots.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg hover:bg-[#b95412]">

            <i class="fa-solid fa-plus"></i>

            ربط جديد

        </a>

        @endcan

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px] text-right">

                <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">

                    <tr>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            المدرب
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الفترة
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            النوع
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الإجراءات
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse($trainerTimeSlots as $item)

                    <tr class="transition hover:bg-[var(--color-surface-hover)]">

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#D46417] font-bold text-white">

                                    {{ mb_substr($item->trainer->user->fullname,0,1) }}

                                </div>

                                <div>

                                    <div class="font-bold">
                                        {{ $item->trainer->user->fullname }}
                                    </div>

                                    <div class="text-xs text-[var(--color-text-muted)]">
                                        {{ $item->trainer->user->username }}
                                    </div>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-4 text-sm font-bold">

                            {{ \Carbon\Carbon::parse($item->timeSlot->start_time)->format('H:i') }}

                            -

                            {{ \Carbon\Carbon::parse($item->timeSlot->end_time)->format('H:i') }}

                        </td>

                        <td class="px-6 py-4">

                            @if($item->timeSlot->gender_type=='mixed')

                            <span class="rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">

                                مختلط

                            </span>

                            @else

                            <span class="rounded-lg bg-pink-500/10 px-3 py-1.5 text-xs font-bold text-pink-500">

                                سيدات

                            </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex gap-2">

                                @can('training_periods.view')

                                <a href="{{ route('trainer-time-slots.show',$item) }}"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] hover:border-[#D46417] hover:text-[#D46417]">

                                    <i class="fa-solid fa-eye text-xs"></i>

                                </a>

                                @endcan

                                @can('training_periods.edit')

                                <a href="{{ route('trainer-time-slots.edit',$item) }}"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] hover:border-[#D46417] hover:text-[#D46417]">

                                    <i class="fa-solid fa-pen text-xs"></i>

                                </a>

                                @endcan

                                @can('training_periods.delete')

                                <form method="POST" action="{{ route('trainer-time-slots.destroy',$item) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('حذف الربط؟')"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/20 text-red-400 hover:bg-red-500/10">

                                        <i class="fa-solid fa-trash text-xs"></i>

                                    </button>

                                </form>

                                @endcan

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="px-6 py-16 text-center">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">

                                <i class="fa-solid fa-clock"></i>

                            </div>

                            <h3 class="mt-4 font-bold">

                                لا توجد روابط

                            </h3>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($trainerTimeSlots->hasPages())

        <div class="border-t border-[var(--color-border)] p-4">

            {{ $trainerTimeSlots->links() }}

        </div>

        @endif

    </div>

</div>

@endsection