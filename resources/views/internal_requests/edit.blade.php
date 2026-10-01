@extends('layout.app')

@section('title','تعديل الطلب')
@section('page-title','تعديل الطلب')

@section('content')

<div class="mx-auto max-w-3xl">

<div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

<h2 class="mb-6 text-xl font-extrabold">

تعديل الطلب

</h2>

<form method="POST" action="{{ route('internal-requests.update',$internalRequest) }}" class="space-y-6">

@csrf
@method('PUT')

<div>

<label class="mb-2 block text-sm font-bold">

تفاصيل الطلب

</label>

<textarea name="details"
rows="7"
class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-4">{{ old('details',$internalRequest->details) }}</textarea>

</div>

@can('internal_requests.manage')

<div>

<label class="mb-2 block text-sm font-bold">

حالة الطلب

</label>

<select name="status"
class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

<option value="pending" @selected($internalRequest->status=='pending')>قيد الانتظار</option>

<option value="approved" @selected($internalRequest->status=='approved')>تمت الموافقة</option>

<option value="rejected" @selected($internalRequest->status=='rejected')>مرفوض</option>

<option value="postponed" @selected($internalRequest->status=='postponed')>مؤجل</option>

</select>

</div>

@endcan

<div class="flex justify-end gap-3">

<a href="{{ route('internal-requests.index') }}"
class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

إلغاء

</a>

<button
class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white transition hover:bg-[#b95412]">

حفظ التعديلات

</button>

</div>

</form>

</div>

</div>

@endsection