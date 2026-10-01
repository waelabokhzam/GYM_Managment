@extends('layout.app')

@section('title','طلب جديد')
@section('page-title','طلب شراء أو صيانة')

@section('content')

<div class="mx-auto max-w-3xl">

<div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

<h2 class="mb-6 text-xl font-extrabold">

إرسال طلب داخلي

</h2>

<form method="POST" action="{{ route('internal-requests.store') }}" class="space-y-6">

@csrf

<div>

<label class="mb-2 block text-sm font-bold">

تفاصيل الطلب

</label>

<textarea name="details"
rows="7"
placeholder="اكتب تفاصيل طلب الشراء أو الصيانة..."
class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4 outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">{{ old('details') }}</textarea>

@error('details')

<p class="mt-2 text-sm text-red-500">

{{ $message }}

</p>

@enderror

</div>

<div class="rounded-xl bg-[var(--color-background)] p-4 text-sm text-[var(--color-text-muted)]">

<i class="fa-solid fa-circle-info ml-1"></i>

سيتم إرسال الطلب إلى الإدارة وسيكون في حالة <strong>قيد الانتظار</strong> حتى يتم اتخاذ قرار بشأنه.

</div>

<div class="flex justify-end gap-3">

<a href="{{ route('internal-requests.index') }}"
class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

إلغاء

</a>

<button
class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white transition hover:bg-[#b95412]">

إرسال الطلب

</button>

</div>

</form>

</div>

</div>

@endsection