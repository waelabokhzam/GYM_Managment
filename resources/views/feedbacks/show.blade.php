@extends('layout.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4">

    {{-- الهيدر وزر العودة --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-[var(--color-text)]">تفاصيل الملاحظة</h1>
            <p class="text-sm text-[var(--color-text-muted)]">مراجعة نص الملاحظة وبيانات المستخدم</p>
        </div>
        <a href="{{ route('feedback.index') }}"
           class="flex items-center gap-2 px-4 py-2 rounded-xl bg-[var(--color-surface-hover)] text-[var(--color-text)] hover:opacity-80 transition text-sm border border-[var(--color-border,#333)]">
            <i class="fa-solid fa-arrow-right text-xs"></i>
            <span>رجوع للقائمة</span>
        </a>
    </div>

    {{-- كرت التفاصيل الرئيسي --}}
    <div class="rounded-2xl bg-[var(--color-surface,#18181b)] border border-[var(--color-border,#27272a)] p-6 shadow-xl">

        {{-- بيانات المستخدم والحالة --}}
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-6 border-b border-[var(--color-border,#27272a)]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#D46417]/10 text-[#D46417] flex items-center justify-center font-bold text-lg border border-[#D46417]/20">
                    {{ mb_substr($feedback->user->fullname ?? 'أ', 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-base text-[var(--color-text)]">
                        {{ $feedback->user->fullname ?? $feedback->user->username ?? 'مستخدم غير معروف' }}
                    </h3>
                    <p class="text-xs text-[var(--color-text-muted)] flex items-center gap-2 mt-1">
                        <i class="fa-solid fa-phone text-[10px]"></i>
                        <span dir="ltr">{{ $feedback->user->phone ?? 'لا يوجد رقم هاتف' }}</span>
                    </p>
                </div>
            </div>

            <div class="text-left">
                <span class="text-xs text-[var(--color-text-muted)] block mb-2">
                    <i class="fa-regular fa-clock me-1"></i>
                    {{ $feedback->created_at->format('Y-m-d | h:i A') }}
                </span>

                {{-- شارة الحالة --}}
                @php
                    $statusClasses = [
                        'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                        'read' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                        'resolved' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                    ];
                    $statusNames = [
                        'pending' => 'قيد الانتظار',
                        'read' => 'تمت المراجعة',
                        'resolved' => 'مكتملة',
                    ];
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border {{ $statusClasses[$feedback->status] ?? 'bg-gray-500/10 text-gray-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $statusNames[$feedback->status] ?? $feedback->status }}
                </span>
            </div>
        </div>

        {{-- الموضوع --}}
        <div class="mb-6">
            <h4 class="text-xs font-medium text-[var(--color-text-muted)] uppercase tracking-wider mb-1">الموضوع</h4>
            <p class="text-base font-bold text-[var(--color-text)] break-words">
                {{ $feedback->subject }}
            </p>
        </div>

        {{-- محتوى الرسالة --}}
        <div class="mb-8">
            <h4 class="text-xs font-medium text-[var(--color-text-muted)] uppercase tracking-wider mb-2">محتوى الرسالة</h4>
            <div class="p-4 rounded-xl bg-[var(--color-bg,#09090b)] border border-[var(--color-border,#27272a)] text-[var(--color-text)] text-sm leading-relaxed whitespace-pre-line break-words">
                {{ $feedback->message }}
            </div>
        </div>

        {{-- أزرار إجراء تحديث الحالة --}}
        <div class="pt-6 border-t border-[var(--color-border,#27272a)] flex flex-wrap items-center justify-between gap-4">
            <span class="text-xs text-[var(--color-text-muted)]">تغيير حالة الملاحظة:</span>

            <form action="{{ route('feedback.updateStatus', $feedback->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()"
                        class="rounded-xl bg-[var(--color-bg,#09090b)] border border-[var(--color-border,#27272a)] text-[var(--color-text)] text-sm px-4 py-2 focus:ring-1 focus:ring-[#D46417] focus:border-[#D46417] outline-none cursor-pointer">
                    <option value="pending" {{ $feedback->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="read" {{ $feedback->status == 'read' ? 'selected' : '' }}>تمت المراجعة</option>
                    <option value="resolved" {{ $feedback->status == 'resolved' ? 'selected' : '' }}>مكتملة</option>
                </select>
            </form>
        </div>

    </div>
</div>
@endsection
