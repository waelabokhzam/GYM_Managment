@extends('layout.app')

@section('title', 'الاشتراكات')
@section('page-title', 'الاشتراكات')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-xl font-extrabold">إدارة الاشتراكات</h2>
            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إدارة اشتراكات اللاعبين وتجديدها
            </p>
        </div>

        @can('subscriptions.create')
        <a href="{{ route('subscriptions.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95412]">

            <i class="fa-solid fa-plus"></i>
            إضافة اشتراك
        </a>
        @endcan

    </div>

    {{-- Search --}}
    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4">

        <form method="GET" action="{{ route('subscriptions.index') }}"
            class="flex flex-col gap-3 sm:flex-row">

            <div class="relative flex-1">

                <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="ابحث باسم اللاعب..."
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] py-3 pl-4 pr-11 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">

            </div>

            <button type="submit"
                class="rounded-xl bg-[#D46417] px-6 py-3 text-sm font-bold text-white hover:bg-[#b95412]">

                بحث
            </button>

        </form>

    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1000px] text-right">

                <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">

                    <tr>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">اللاعب</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">نوع الاشتراك</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">التسجيل</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">البداية</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">الانتهاء</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">الحالة</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">الإجراءات</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse($subscriptions as $subscription)

                    <tr class="transition hover:bg-[var(--color-surface-hover)]">

                        {{-- Player --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#D46417] font-bold text-white">
                                    {{ mb_substr($subscription->player->user->fullname,0,1) }}
                                </div>

                                <div>
                                    <div class="font-bold">{{ $subscription->player->user->fullname }}</div>
                                    <div class="text-xs text-[var(--color-text-muted)]">
                                        #{{ $subscription->player->unique_number }}
                                    </div>
                                </div>

                            </div>

                        </td>

                        {{-- Type --}}
                        <td class="px-6 py-4">

                            @php
                            $types = [
                            'monthly'=>'شهري',
                            'daily'=>'يومي',
                            'offers'=>'عرض',
                            'special'=>'خاص'
                            ];
                            @endphp

                            <span class="rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">
                                {{ $types[$subscription->sub_type] }}
                            </span>

                        </td>

                        {{-- Registration --}}
                        <td class="px-6 py-4">

                            <span class="rounded-lg bg-[var(--color-background)] px-3 py-1.5 text-xs font-bold">
                                {{ $subscription->registration_type == 'new' ? 'أول مرة' : 'تجديد' }}
                            </span>

                        </td>

                        {{-- Dates --}}
                        <td class="px-6 py-4 text-sm">{{ $subscription->start_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-sm">{{ $subscription->end_date->format('Y-m-d') }}</td>

                        {{-- Status --}}
                        <td class="px-6 py-4">

                            @if($subscription->status=='active')

                            <span class="rounded-lg bg-green-500/10 px-3 py-1.5 text-xs font-bold text-green-500">
                                نشط
                            </span>

                            @else

                            <span class="rounded-lg bg-red-500/10 px-3 py-1.5 text-xs font-bold text-red-500">
                                منتهي
                            </span>

                            @endif

                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4">

                            <div class="flex gap-2">

                                @can('subscriptions.view')
                                <a href="{{ route('subscriptions.show',$subscription) }}"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] hover:border-[#D46417] hover:text-[#D46417]">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                                @endcan

                                @can('subscriptions.edit')
                                <a href="{{ route('subscriptions.edit',$subscription) }}"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] hover:border-[#D46417] hover:text-[#D46417]">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                @endcan

                                @can('subscriptions.delete')
                                <form method="POST" action="{{ route('subscriptions.destroy',$subscription) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('حذف الاشتراك؟')"
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
                        <td colspan="7" class="px-6 py-16 text-center">

                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">
                                <i class="fa-solid fa-id-card"></i>
                            </div>

                            <h3 class="mt-4 font-bold">لا توجد اشتراكات</h3>

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($subscriptions->hasPages())
        <div class="border-t border-[var(--color-border)] p-4">
            {{ $subscriptions->links() }}
        </div>
        @endif

    </div>

</div>

@endsection