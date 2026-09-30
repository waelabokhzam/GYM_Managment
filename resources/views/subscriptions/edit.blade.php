@extends('layout.app')

@section('title','تعديل الاشتراك')
@section('page-title','تعديل الاشتراك')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="rounded-3xl border border-[var(--color-border)] bg-[var(--color-surface)] p-8">

        <h2 class="mb-6 text-xl font-extrabold">
            تعديل الاشتراك
        </h2>

        <form method="POST"
              action="{{ route('subscriptions.update',$subscription) }}"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">

                {{-- Subscription Type --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        نوع الاشتراك
                    </label>

                    <select
                        name="sub_type"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        @foreach([
                            'monthly'=>'شهري',
                            'daily'=>'يومي',
                            'offers'=>'عرض',
                            'special'=>'خاص'
                        ] as $key => $label)

                            <option value="{{ $key }}"
                                @selected($subscription->sub_type == $key)>

                                {{ $label }}

                            </option>

                        @endforeach

                    </select>

                    @error('sub_type')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Amount --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        مبلغ الاشتراك
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            name="amount"
                            value="{{ old('amount', $subscription->amount) }}"
                            step="0.01"
                            min="0.01"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3 pl-16 outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-[var(--color-text-muted)]">
                            $
                        </span>

                    </div>

                    @error('amount')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Status --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        الحالة
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] p-3">

                        <option value="active"
                            @selected($subscription->status == 'active')}>
                            نشط
                        </option>

                        <option value="expired"
                            @selected($subscription->status == 'expired')}>
                            منتهي
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            <div class="flex justify-end gap-3">

                <a href="{{ route('subscriptions.index') }}"
                   class="rounded-xl border border-[var(--color-border)] px-6 py-3 font-bold">

                    إلغاء

                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-[#D46417] px-6 py-3 font-bold text-white hover:bg-[#b95412]">

                    حفظ التعديلات

                </button>

            </div>

        </form>

    </div>

</div>

@endsection