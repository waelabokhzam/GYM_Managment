@extends('layout.app')

@section('title', 'إدارة الصلاحيات')

@section('content')

<div class="space-y-6" dir="rtl">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                إدارة الأدوار والصلاحيات
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                إدارة أدوار المستخدمين والصلاحيات المرتبطة بكل دور
            </p>
        </div>

        @can('roles.manage')
            <a href="{{ route('roles.create') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3
                      rounded-xl bg-[#D46417] text-white font-semibold
                      hover:bg-[#b95512] transition shadow-sm">

                <i class="fa-solid fa-plus"></i>

                إضافة دور جديد
            </a>
        @endcan

    </div>


    {{-- Flash Messages --}}
    @if(session('success'))

        <div class="flex items-center gap-3 p-4 rounded-xl
                    bg-green-50 border border-green-200
                    text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">

            <i class="fa-solid fa-circle-check text-lg"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div class="flex items-center gap-3 p-4 rounded-xl
                    bg-red-50 border border-red-200
                    text-red-700 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">

            <i class="fa-solid fa-circle-exclamation text-lg"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- Search --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm
                border border-gray-200 dark:border-gray-800 p-5">

        <form method="GET"
              action="{{ route('roles.index') }}"
              class="flex flex-col md:flex-row gap-3">

            <div class="relative flex-1">

                <span class="absolute inset-y-0 right-0 flex items-center pr-4
                             text-gray-400">

                    <i class="fa-solid fa-magnifying-glass"></i>

                </span>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="ابحث باسم الدور..."
                    class="w-full rounded-xl border border-gray-300
                           dark:border-gray-700 dark:bg-gray-800
                           dark:text-white
                           pr-11 pl-4 py-3
                           focus:ring-2 focus:ring-[#D46417]
                           focus:border-[#D46417]"
                >

            </div>

            <button type="submit"
                    class="px-6 py-3 rounded-xl
                           bg-gray-900 text-white
                           dark:bg-white dark:text-gray-900
                           hover:opacity-90 transition">

                <i class="fa-solid fa-search ml-1"></i>

                بحث
            </button>

            @if(request('search'))

                <a href="{{ route('roles.index') }}"
                   class="px-6 py-3 rounded-xl border
                          border-gray-300 dark:border-gray-700
                          text-gray-700 dark:text-gray-300
                          hover:bg-gray-50 dark:hover:bg-gray-800
                          text-center">

                    إلغاء البحث

                </a>

            @endif

        </form>

    </div>


    {{-- Roles Table --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm
                border border-gray-200 dark:border-gray-800 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-right">

                <thead class="bg-gray-50 dark:bg-gray-800/70">

                    <tr>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            #
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            الدور
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            عدد المستخدمين
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            عدد الصلاحيات
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            تاريخ الإنشاء
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300 text-center">
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                    @forelse($roles as $role)

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">

                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $roles->firstItem() + $loop->index }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-xl
                                                bg-[#D46417]/10
                                                text-[#D46417]
                                                flex items-center justify-center">

                                        <i class="fa-solid fa-user-shield"></i>

                                    </div>

                                    <div>

                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            {{ $role->name }}
                                        </div>

                                        <div class="text-xs text-gray-400">
                                            ID: {{ $role->id }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            <td class="px-6 py-4">

                                <span class="inline-flex items-center gap-2
                                             px-3 py-1 rounded-full
                                             bg-blue-50 text-blue-700
                                             dark:bg-blue-900/20 dark:text-blue-400">

                                    <i class="fa-solid fa-users text-xs"></i>

                                    {{ $role->users_count ?? $role->users()->count() }}

                                </span>

                            </td>


                            <td class="px-6 py-4">

                                <span class="inline-flex items-center gap-2
                                             px-3 py-1 rounded-full
                                             bg-orange-50 text-orange-700
                                             dark:bg-orange-900/20 dark:text-orange-400">

                                    <i class="fa-solid fa-key text-xs"></i>

                                    {{ $role->permissions_count ?? $role->permissions()->count() }}

                                </span>

                            </td>


                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">

                                {{ $role->created_at?->format('Y-m-d') }}

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- Show --}}
                                    <a href="{{ route('roles.show', $role) }}"
                                       title="عرض"
                                       class="w-9 h-9 flex items-center justify-center
                                              rounded-lg bg-blue-50 text-blue-600
                                              dark:bg-blue-900/20 dark:text-blue-400
                                              hover:bg-blue-100 transition">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>


                                    {{-- Edit --}}
                                    @can('roles.manage')

                                        <a href="{{ route('roles.edit', $role) }}"
                                           title="تعديل"
                                           class="w-9 h-9 flex items-center justify-center
                                                  rounded-lg bg-orange-50 text-[#D46417]
                                                  dark:bg-orange-900/20
                                                  hover:bg-orange-100 transition">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>


                                        {{-- Delete --}}
                                        @if(!in_array($role->name, ['admin']))

                                            <form action="{{ route('roles.destroy', $role) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        title="حذف"
                                                        class="w-9 h-9 flex items-center justify-center
                                                               rounded-lg bg-red-50 text-red-600
                                                               dark:bg-red-900/20
                                                               hover:bg-red-100 transition">

                                                    <i class="fa-solid fa-trash"></i>

                                                </button>

                                            </form>

                                        @endif

                                    @endcan

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-12 text-center">

                                <div class="flex flex-col items-center justify-center">

                                    <div class="w-16 h-16 rounded-full
                                                bg-gray-100 dark:bg-gray-800
                                                flex items-center justify-center
                                                text-gray-400 text-2xl">

                                        <i class="fa-solid fa-user-shield"></i>

                                    </div>

                                    <h3 class="mt-4 font-semibold text-gray-700 dark:text-gray-300">
                                        لا توجد أدوار
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-400">
                                        لم يتم العثور على أي دور مطابق للبحث
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($roles->hasPages())

            <div class="p-5 border-t border-gray-200 dark:border-gray-800">

                {{ $roles->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection