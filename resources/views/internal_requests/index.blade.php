@extends('layout.app')

@section('title', 'طلبات الشراء والصيانة')
@section('page-title', 'طلبات الشراء والصيانة')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-xl font-extrabold">
                    إدارة الطلبات الداخلية
                </h2>

                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                    طلبات الشراء والصيانة المقدمة من المدربين وموظفي الاستقبال.
                </p>

            </div>

            @can('internal_requests.create')
                <a href="{{ route('internal-requests.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95412]">

                    <i class="fa-solid fa-plus"></i>

                    طلب جديد

                </a>
            @endcan

        </div>

        {{-- Filters --}}
        <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

            <form method="GET" action="{{ route('internal-requests.index') }}"
                class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">

                {{-- نوع مقدم الطلب --}}
                <div>

                    <label for="role" class="mb-2 block text-sm font-bold">
                        نوع مقدم الطلب
                    </label>

                    <select name="role" id="role"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[#D46417]">

                        <option value="">
                            جميع الموظفين
                        </option>

                        <option value="trainer" {{ request('role') === 'trainer' ? 'selected' : '' }}>
                            مدرب
                        </option>

                        <option value="reception" {{ request('role') === 'reception' ? 'selected' : '' }}>
                            استقبال
                        </option>

                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>
                            أدمن
                        </option>

                    </select>

                </div>


                {{-- حالة الطلب --}}
                <div>

                    <label for="status" class="mb-2 block text-sm font-bold">
                        حالة الطلب
                    </label>

                    <select name="status" id="status"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[#D46417]">

                        <option value="">
                            جميع الحالات
                        </option>

                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                            قيد الانتظار
                        </option>

                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                            تمت الموافقة
                        </option>

                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>
                            مرفوض
                        </option>

                        <option value="postponed" {{ request('status') === 'postponed' ? 'selected' : '' }}>
                            مؤجل
                        </option>

                    </select>

                </div>


                {{-- الأزرار --}}
                <div class="flex items-end gap-2">

                    <button type="submit"
                        class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95412]">

                        <i class="fa-solid fa-filter"></i>

                        تطبيق الفلاتر

                    </button>

                    <a href="{{ route('internal-requests.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[var(--color-border)] px-5 py-3 text-sm font-bold transition hover:border-[#D46417] hover:text-[#D46417]">

                        <i class="fa-solid fa-rotate-left"></i>

                        إعادة تعيين

                    </a>

                </div>

            </form>

        </div>



        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[950px] text-right">

                    <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">

                        <tr>

                            <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                مقدم الطلب
                            </th>

                            <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                نوع المستخدم
                            </th>

                            <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                الحالة
                            </th>

                            <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                التاريخ
                            </th>

                            <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                                الإجراءات
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-[var(--color-border)]">

                        @forelse($requests as $request)
                            @php
                                $role = $request->requester->getRoleNames()->first();
                            @endphp

                            <tr class="transition hover:bg-[var(--color-surface-hover)]">

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-[#D46417] font-bold text-white">

                                            {{ mb_substr($request->requester->fullname, 0, 1) }}

                                        </div>

                                        <div>

                                            <div class="font-bold">

                                                {{ $request->requester->fullname }}

                                            </div>

                                            <div class="text-xs text-[var(--color-text-muted)]">

                                                {{ $request->requester->username }}

                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-4">

                                    @switch($role)
                                        @case('trainer')
                                            <span
                                                class="rounded-lg bg-[#D46417]/10 px-3 py-1.5 text-xs font-bold text-[#D46417]">مدرب</span>
                                        @break

                                        @case('reception')
                                            <span
                                                class="rounded-lg bg-blue-500/10 px-3 py-1.5 text-xs font-bold text-blue-500">استقبال</span>
                                        @break

                                        @case('admin')
                                            <span
                                                class="rounded-lg bg-red-500/10 px-3 py-1.5 text-xs font-bold text-red-500">أدمن</span>
                                        @break
                                    @endswitch

                                </td>

                                <td class="px-6 py-4">

                                    @switch($request->status)
                                        @case('pending')
                                            <span
                                                class="rounded-lg bg-yellow-500/10 px-3 py-1.5 text-xs font-bold text-yellow-500">قيد
                                                الانتظار</span>
                                        @break

                                        @case('approved')
                                            <span
                                                class="rounded-lg bg-green-500/10 px-3 py-1.5 text-xs font-bold text-green-500">تمت
                                                الموافقة</span>
                                        @break

                                        @case('rejected')
                                            <span
                                                class="rounded-lg bg-red-500/10 px-3 py-1.5 text-xs font-bold text-red-500">مرفوض</span>
                                        @break

                                        @case('postponed')
                                            <span
                                                class="rounded-lg bg-orange-500/10 px-3 py-1.5 text-xs font-bold text-orange-500">مؤجل</span>
                                        @break
                                    @endswitch

                                </td>

                                <td class="px-6 py-4 text-sm">

                                    {{ $request->created_at->format('Y-m-d') }}

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex gap-2">

                                        @can('view', $request)
                                            <a href="{{ route('internal-requests.show', $request) }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] hover:border-[#D46417] hover:text-[#D46417]">

                                                <i class="fa-solid fa-eye text-xs"></i>

                                            </a>
                                        @endcan

                                        @can('update', $request)
                                            <a href="{{ route('internal-requests.edit', $request) }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] hover:border-[#D46417] hover:text-[#D46417]">

                                                <i class="fa-solid fa-pen text-xs"></i>

                                            </a>
                                        @endcan

                                    </div>

                                </td>

                            </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="px-6 py-16 text-center">

                                        <div
                                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">

                                            <i class="fa-solid fa-screwdriver-wrench"></i>

                                        </div>

                                        <h3 class="mt-4 font-bold">
                                            لا توجد طلبات
                                        </h3>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if ($requests->hasPages())
                    <div class="border-t border-[var(--color-border)] p-4">

                        {{ $requests->links() }}

                    </div>
                @endif

            </div>

        </div>

    @endsection
