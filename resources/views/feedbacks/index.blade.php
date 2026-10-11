@extends('layout.app')

@section('page-title', 'الملاحظات والشكاوى')

@section('content')
    <div class="space-y-6">

        {{-- Alert النجاح --}}
        @if (session('success'))
            <div id="success-notification"
                class="flex items-center justify-between p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="hover:opacity-75">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- كارت الجدول --}}
        <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] overflow-hidden shadow-sm">

            {{-- هيدر الكارت --}}
            <div class="p-5 border-b border-[var(--color-border)] flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-[var(--color-text)]">رسائل وملاحظات المشتركين</h2>
                    <p class="text-xs text-[var(--color-text-muted)] mt-1">عرض جميع الرسائل الواردة من تطبيق الجوال وتحديث
                        حالتها</p>
                </div>
                <span class="px-3 py-1 text-xs font-bold rounded-full bg-[#D46417]/10 text-[#D46417]">
                    الإجمالي: {{ $feedbacks->total() }}
                </span>
            </div>

                        {{-- شريط البحث والفلترة --}}
<div class="mb-6 p-4 rounded-2xl bg-[var(--color-surface,#18181b)] border border-[var(--color-border,#27272a)] shadow-lg">
    <form action="{{ route('feedback.index') }}" method="GET" class="flex flex-wrap items-center gap-3">

        {{-- حقل البحث بالكلمة المفتاحية --}}
        <div class="flex-1 min-w-[220px]">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute start-3 top-1/2 -translate-y-1/2 text-xs text-[var(--color-text-muted)]"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="ابحث بالاسم، الهاتف، الموضوع أو النص..."
                       class="w-full ps-9 pe-4 py-2.5 text-xs rounded-xl bg-[var(--color-bg,#09090b)] border border-[var(--color-border,#27272a)] text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:outline-none focus:border-[#D46417] transition">
            </div>
        </div>

        {{-- فلتر الحالة --}}
        <div class="w-full sm:w-auto min-w-[150px]">
            <select name="status"
                    onchange="this.form.submit()"
                    class="w-full px-3 py-2.5 text-xs rounded-xl bg-[var(--color-bg,#09090b)] border border-[var(--color-border,#27272a)] text-[var(--color-text)] focus:outline-none focus:border-[#D46417] cursor-pointer transition">
                <option value="">جميع الحالات</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلقة</option>
                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>تمت المراجعة</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>مكتملة</option>
            </select>
        </div>

        {{-- أزرار البحث والتفريغ --}}
        <div class="flex items-center gap-2">
            <button type="submit"
                    class="px-4 py-2.5 text-xs font-semibold rounded-xl bg-[#D46417] text-white hover:bg-[#D46417]/90 transition shadow-md shadow-[#D46417]/20 flex items-center gap-1.5">
                <i class="fa-solid fa-filter text-[10px]"></i>
                <span>فلترة</span>
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('feedback.index') }}"
                   class="px-3 py-2.5 text-xs font-semibold rounded-xl bg-[var(--color-surface-hover,#27272a)] text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition border border-[var(--color-border,#333)]">
                    إلغاء الفلترة
                </a>
            @endif
        </div>

    </form>
</div>

            {{-- الجدول --}}
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead
                        class="bg-[var(--color-surface-hover)] text-xs text-[var(--color-text-muted)] uppercase border-b border-[var(--color-border)]">
                        <tr>
                            <th class="px-6 py-4">المستخدم</th>
                            <th class="px-6 py-4">الموضوع</th>
                            <th class="px-6 py-4">الرسالة</th>
                            <th class="px-6 py-4">الحالة</th>
                            <th class="px-6 py-4">التاريخ</th>
                            <th class="px-6 py-4 text-center">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border)] text-[var(--color-text)]">
                        @forelse($feedbacks as $feedback)
                            <tr class="hover:bg-[var(--color-surface-hover)]/50 transition">

                                {{-- المستخدم --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-full bg-[#D46417]/20 font-bold text-[#D46417] text-xs">
                                            {{ mb_substr($feedback->user->fullname ?? 'م', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">
                                                {{ $feedback->user->fullname ?? 'مستخدم غير معروف' }}</div>
                                            <div class="text-xs text-[var(--color-text-muted)] dir-ltr text-right">
                                                {{ $feedback->user->phone ?? ($feedback->user->username ?? '-') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                {{-- الموضوع --}}
                                <td class="px-6 py-4 font-bold max-w-[180px] truncate" title="{{ $feedback->subject }}">
                                    {{ $feedback->subject }}
                                </td>

                                {{-- الرسالة --}}
                                <td class="px-6 py-4 max-w-xs">
                                    <p class="text-xs leading-relaxed text-[var(--color-text-muted)] line-clamp-2 break-words"
                                        title="{{ $feedback->message }}">
                                        {{ $feedback->message }}
                                    </p>
                                </td>

                                <td>
                                    <a href="{{ route('feedback.show', $feedback->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mx-2 font-medium">
                                        عرض التفاصيل
                                    </a>
                                </td>

                                {{-- الحالة --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($feedback->status === 'pending')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            قيد الانتظار
                                        </span>
                                    @elseif($feedback->status === 'read')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-500/10 text-blue-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            تمت القراءة
                                        </span>
                                    @elseif($feedback->status === 'resolved')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            تم الحل
                                        </span>
                                    @endif
                                </td>

                                {{-- التاريخ --}}
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-[var(--color-text-muted)]">
                                    <div>{{ $feedback->created_at->format('Y-m-d') }}</div>
                                    <div class="text-[10px] opacity-75">{{ $feedback->created_at->format('h:i A') }}</div>
                                </td>

                                {{-- الإجراء لتغيير الحالة --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('feedback.updateStatus', $feedback->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="text-xs bg-[var(--color-surface)] border border-[var(--color-border)] rounded-xl px-2.5 py-1.5 text-[var(--color-text)] focus:border-[#D46417] focus:outline-none cursor-pointer">
                                            <option value="pending"
                                                {{ $feedback->status === 'pending' ? 'selected' : '' }}>معلقة</option>
                                            <option value="read" {{ $feedback->status === 'read' ? 'selected' : '' }}>
                                                مقروءة</option>
                                            <option value="resolved"
                                                {{ $feedback->status === 'resolved' ? 'selected' : '' }}>تمت المعالجة
                                            </option>
                                        </select>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-[var(--color-text-muted)]">
                                    <i class="fa-solid fa-inbox text-4xl mb-3 block opacity-40"></i>
                                    <span>لا يوجد أي ملاحظات أو شكاوى حالياً</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- الترقيم (Pagination) --}}
            @if ($feedbacks->hasPages())
                <div class="p-4 border-t border-[var(--color-border)]">
                    {{ $feedbacks->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
