@extends('layout.app')

@section('title', 'تعديل اللاعب')

@section('page-title', 'تعديل اللاعب')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <a
                href="{{ route('players.show', $player) }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[var(--color-border)] text-[var(--color-text-muted)] transition hover:border-[#D46417]/50 hover:text-[#D46417]"
            >
                <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div>

                <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">
                    تعديل بيانات اللاعب
                </h1>

                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                    تعديل بيانات {{ $player->user->fullname }}.
                </p>

            </div>

        </div>


        <div class="rounded-xl bg-[#D46417]/10 px-4 py-2 text-sm font-bold text-[#D46417]">

            <i class="fa-solid fa-id-card ml-1"></i>

            {{ $player->unique_number }}

        </div>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-5">

            <div class="flex items-start gap-3">

                <i class="fa-solid fa-circle-exclamation mt-0.5 text-red-500"></i>

                <div>

                    <h3 class="font-bold text-red-600 dark:text-red-400">
                        يرجى تصحيح الأخطاء التالية:
                    </h3>

                    <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">

                        @foreach($errors->all() as $error)

                            <li>
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    <form
        action="{{ route('players.update', $player) }}"
        method="POST"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- Account Information --}}
        <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

            <div class="border-b border-[var(--color-border)] p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div>

                        <h2 class="font-extrabold">
                            معلومات الحساب
                        </h2>

                        <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                            المعلومات الأساسية لحساب اللاعب.
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2">


                {{-- Fullname --}}
                <div>

                    <label
                        for="fullname"
                        class="mb-2 block text-sm font-bold"
                    >
                        الاسم الكامل
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-user absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                        <input
                            type="text"
                            id="fullname"
                            name="fullname"
                            value="{{ old('fullname', $player->user->fullname) }}"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)] bg-transparent py-3 pr-11 pl-4 text-sm outline-none transition placeholder:text-[var(--color-text-muted)] focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/20"
                        >

                    </div>

                    @error('fullname')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Phone --}}
                <div>

                    <label
                        for="phone"
                        class="mb-2 block text-sm font-bold"
                    >
                        رقم الهاتف
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-phone absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $player->user->phone) }}"
                            required
                            class="w-full rounded-xl border border-[var(--color-border)] bg-transparent py-3 pr-11 pl-4 text-sm outline-none transition placeholder:text-[var(--color-text-muted)] focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/20"
                        >

                    </div>

                    @error('phone')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Username --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        اسم المستخدم
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-at absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                        <input
                            type="text"
                            value="{{ $player->user->username }}"
                            disabled
                            class="w-full cursor-not-allowed rounded-xl border border-[var(--color-border)] bg-black/[0.03] py-3 pr-11 pl-4 text-sm text-[var(--color-text-muted)] outline-none dark:bg-white/[0.03]"
                        >

                    </div>

                    <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                        اسم المستخدم يتم إنشاؤه تلقائياً ولا يمكن تعديله.
                    </p>

                </div>


                {{-- Player Number --}}
                <div>

                    <label class="mb-2 block text-sm font-bold">
                        رقم اللاعب
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-id-card absolute right-4 top-1/2 -translate-y-1/2 text-[#D46417]"></i>

                        <input
                            type="text"
                            value="{{ $player->unique_number }}"
                            disabled
                            class="w-full cursor-not-allowed rounded-xl border border-[var(--color-border)] bg-[#D46417]/5 py-3 pr-11 pl-4 text-sm font-bold text-[#D46417] outline-none"
                        >

                    </div>

                    <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                        الرقم الخاص باللاعب لا يمكن تعديله.
                    </p>

                </div>

            </div>

        </div>


        {{-- Player Information --}}
        <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

            <div class="border-b border-[var(--color-border)] p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D46417]/15 text-[#D46417]">
                        <i class="fa-solid fa-dumbbell"></i>
                    </div>

                    <div>

                        <h2 class="font-extrabold">
                            معلومات اللاعب
                        </h2>

                        <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                            المعلومات الجسدية والشخصية للاعب.
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2 lg:grid-cols-3">


                {{-- Gender --}}
                <div>

                    <label
                        for="gender"
                        class="mb-2 block text-sm font-bold"
                    >
                        الجنس
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-venus-mars absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                        <select
                            id="gender"
                            name="gender"
                            required
                            class="w-full appearance-none rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] py-3 pr-11 pl-4 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/20"
                        >

                            <option value="male" @selected(old('gender', $player->gender) === 'male')>
                                ذكر
                            </option>

                            <option value="female" @selected(old('gender', $player->gender) === 'female')>
                                أنثى
                            </option>

                        </select>

                    </div>

                    @error('gender')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Height --}}
                <div>

                    <label
                        for="height"
                        class="mb-2 block text-sm font-bold"
                    >
                        الطول (سم)
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-ruler-vertical absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="300"
                            id="height"
                            name="height"
                            value="{{ old('height', $player->height) }}"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-transparent py-3 pr-11 pl-4 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/20"
                        >

                    </div>

                    @error('height')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Weight --}}
                <div>

                    <label
                        for="weight"
                        class="mb-2 block text-sm font-bold"
                    >
                        الوزن (كغ)
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-weight-scale absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="500"
                            id="weight"
                            name="weight"
                            value="{{ old('weight', $player->weight) }}"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-transparent py-3 pr-11 pl-4 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/20"
                        >

                    </div>

                    @error('weight')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Occupation --}}
                <div class="sm:col-span-2 lg:col-span-3">

                    <label
                        for="occupation"
                        class="mb-2 block text-sm font-bold"
                    >
                        المهنة
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-briefcase absolute right-4 top-1/2 -translate-y-1/2 text-[var(--color-text-muted)]"></i>

                        <input
                            type="text"
                            id="occupation"
                            name="occupation"
                            value="{{ old('occupation', $player->occupation) }}"
                            class="w-full rounded-xl border border-[var(--color-border)] bg-transparent py-3 pr-11 pl-4 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/20"
                        >

                    </div>

                    @error('occupation')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Health Status --}}
                <div class="sm:col-span-2 lg:col-span-3">

                    <label
                        for="health_status"
                        class="mb-2 block text-sm font-bold"
                    >
                        الحالة الصحية
                    </label>

                    <textarea
                        id="health_status"
                        name="health_status"
                        rows="5"
                        placeholder="اكتب أي ملاحظات أو حالات صحية مهمة..."
                        class="w-full rounded-xl border border-[var(--color-border)] bg-transparent px-4 py-3 text-sm outline-none transition placeholder:text-[var(--color-text-muted)] focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/20"
                    >{{ old('health_status', $player->health_status) }}</textarea>

                    @error('health_status')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Buttons --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-start">

            <a
                href="{{ route('players.show', $player) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-[var(--color-border)] px-6 py-3 text-sm font-bold transition hover:border-[#D46417]/50 hover:text-[#D46417]"
            >
                <i class="fa-solid fa-xmark"></i>
                إلغاء
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D46417] px-7 py-3 text-sm font-bold text-white transition hover:bg-[#b95310] focus:outline-none focus:ring-2 focus:ring-[#D46417]/50"
            >
                <i class="fa-solid fa-floppy-disk"></i>
                حفظ التعديلات
            </button>

        </div>

    </form>

</div>

@endsection