@extends('layout.app')

@section('title', 'المدربون')

@section('page-title', 'المدربون')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-xl font-extrabold">
                إدارة المدربين
            </h2>

            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إدارة حسابات وبيانات المدربين في النادي
            </p>

        </div>

        @can('trainers.create')

            <a
                href="{{ route('trainers.create') }}"
                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    rounded-xl
                    bg-[#D46417]
                    px-5
                    py-3
                    text-sm
                    font-bold
                    text-white
                    shadow-lg
                    shadow-[#D46417]/20
                    transition
                    hover:bg-[#b95412]
                "
            >
                <i class="fa-solid fa-plus"></i>

                إضافة مدرب
            </a>

        @endcan

    </div>


    {{-- Search --}}

    <div
        class="
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
            p-4
        "
    >

        <form
            method="GET"
            action="{{ route('trainers.index') }}"
            class="flex flex-col gap-3 sm:flex-row"
        >

            <div class="relative flex-1">

                <i
                    class="
                        fa-solid
                        fa-magnifying-glass
                        absolute
                        right-4
                        top-1/2
                        -translate-y-1/2
                        text-[var(--color-text-muted)]
                    "
                ></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="البحث بالاسم أو اسم المستخدم أو الهاتف..."
                    class="
                        w-full
                        rounded-xl
                        border
                        border-[var(--color-border)]
                        bg-[var(--color-background)]
                        py-3
                        pl-4
                        pr-11
                        text-sm
                        text-[var(--color-text)]
                        outline-none
                        transition
                        focus:border-[#D46417]
                        focus:ring-2
                        focus:ring-[#D46417]/10
                    "
                >

            </div>

            <button
                type="submit"
                class="
                    rounded-xl
                    bg-[#D46417]
                    px-6
                    py-3
                    text-sm
                    font-bold
                    text-white
                    transition
                    hover:bg-[#b95412]
                "
            >
                بحث
            </button>

        </form>

    </div>


    {{-- Table --}}

    <div
        class="
            overflow-hidden
            rounded-2xl
            border
            border-[var(--color-border)]
            bg-[var(--color-surface)]
        "
    >

        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px] text-right">

                <thead
                    class="
                        border-b
                        border-[var(--color-border)]
                        bg-[var(--color-background)]
                    "
                >

                    <tr>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            المدرب
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            اسم المستخدم
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الهاتف
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            نوع الأجر
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الأجر
                        </th>

                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">
                            الإجراءات
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse ($trainers as $trainer)

                        <tr class="transition hover:bg-[var(--color-surface-hover)]">

                            {{-- Name --}}

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="
                                            flex
                                            h-10
                                            w-10
                                            shrink-0
                                            items-center
                                            justify-center
                                            rounded-full
                                            bg-[#D46417]
                                            font-bold
                                            text-white
                                        "
                                    >
                                        {{ mb_substr($trainer->user->fullname, 0, 1) }}
                                    </div>

                                    <div>

                                        <div class="font-bold">
                                            {{ $trainer->user->fullname }}
                                        </div>

                                        <div class="mt-1 text-xs text-[var(--color-text-muted)]">
                                            #{{ $trainer->id }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Username --}}

                            <td class="px-6 py-4">

                                <span
                                    class="
                                        rounded-lg
                                        bg-[var(--color-background)]
                                        px-3
                                        py-1.5
                                        text-xs
                                        font-bold
                                    "
                                >
                                    {{ $trainer->user->username }}
                                </span>

                            </td>


                            {{-- Phone --}}

                            <td class="px-6 py-4 text-sm">
                                {{ $trainer->user->phone }}
                            </td>


                            {{-- Salary Type --}}

                            <td class="px-6 py-4">

                                @if ($trainer->salary_type === 'fixed')

                                    <span
                                        class="
                                            rounded-lg
                                            bg-green-500/10
                                            px-3
                                            py-1.5
                                            text-xs
                                            font-bold
                                            text-green-500
                                        "
                                    >
                                        راتب ثابت
                                    </span>

                                @else

                                    <span
                                        class="
                                            rounded-lg
                                            bg-[#D46417]/10
                                            px-3
                                            py-1.5
                                            text-xs
                                            font-bold
                                            text-[#D46417]
                                        "
                                    >
                                        نسبة
                                    </span>

                                @endif

                            </td>


                            {{-- Salary --}}

                            <td class="px-6 py-4 text-sm font-bold">

                                {{ number_format($trainer->base_salary, 2) }}

                                @if ($trainer->salary_type === 'percentage')
                                    %
                                @endif

                            </td>


                            {{-- Actions --}}

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-2">

                                    @can('trainers.view')

                                        <a
                                            href="{{ route('trainers.show', $trainer) }}"
                                            class="
                                                flex
                                                h-9
                                                w-9
                                                items-center
                                                justify-center
                                                rounded-lg
                                                border
                                                border-[var(--color-border)]
                                                text-[var(--color-text-muted)]
                                                transition
                                                hover:border-[#D46417]
                                                hover:text-[#D46417]
                                            "
                                            title="عرض"
                                        >
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>

                                    @endcan


                                    @can('trainers.edit')

                                        <a
                                            href="{{ route('trainers.edit', $trainer) }}"
                                            class="
                                                flex
                                                h-9
                                                w-9
                                                items-center
                                                justify-center
                                                rounded-lg
                                                border
                                                border-[var(--color-border)]
                                                text-[var(--color-text-muted)]
                                                transition
                                                hover:border-[#D46417]
                                                hover:text-[#D46417]
                                            "
                                            title="تعديل"
                                        >
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                    @endcan


                                    @can('trainers.delete')

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
                                                    flex
                                                    h-9
                                                    w-9
                                                    items-center
                                                    justify-center
                                                    rounded-lg
                                                    border
                                                    border-red-500/20
                                                    text-red-400
                                                    transition
                                                    hover:bg-red-500/10
                                                "
                                                title="حذف"
                                            >
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>

                                        </form>

                                    @endcan

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-16 text-center"
                            >

                                <div
                                    class="
                                        mx-auto
                                        flex
                                        h-16
                                        w-16
                                        items-center
                                        justify-center
                                        rounded-2xl
                                        bg-[#D46417]/10
                                        text-2xl
                                        text-[#D46417]
                                    "
                                >
                                    <i class="fa-solid fa-person-running"></i>
                                </div>

                                <h3 class="mt-4 font-bold">
                                    لا يوجد مدربون
                                </h3>

                                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                                    لم يتم العثور على أي مدربين.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($trainers->hasPages())

            <div class="border-t border-[var(--color-border)] p-4">
                {{ $trainers->links() }}
            </div>

        @endif

    </div>

</div>

@endsection