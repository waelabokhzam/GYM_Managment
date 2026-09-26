@extends('layout.app')

@section('title', 'تفاصيل الدور')

@section('content')

<div class="space-y-6" dir="rtl">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row
                md:items-center md:justify-between gap-4">

        <div>

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                تفاصيل الدور
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                عرض معلومات الدور والصلاحيات والمستخدمين المرتبطين به
            </p>

        </div>


        <div class="flex items-center gap-2">

            <a href="{{ route('roles.index') }}"
               class="inline-flex items-center gap-2
                      px-4 py-2.5 rounded-xl
                      border border-gray-300
                      dark:border-gray-700
                      text-gray-700 dark:text-gray-300
                      hover:bg-gray-50 dark:hover:bg-gray-800">

                <i class="fa-solid fa-arrow-right"></i>

                العودة

            </a>


            @can('roles.manage')

                <a href="{{ route('roles.edit', $role) }}"
                   class="inline-flex items-center gap-2
                          px-4 py-2.5 rounded-xl
                          bg-[#D46417] text-white
                          hover:bg-[#b95512]">

                    <i class="fa-solid fa-pen"></i>

                    تعديل

                </a>

            @endcan

        </div>

    </div>


    {{-- Role Card --}}
    <div class="bg-white dark:bg-gray-900
                rounded-2xl shadow-sm
                border border-gray-200
                dark:border-gray-800 p-6">

        <div class="flex flex-col md:flex-row
                    md:items-center gap-5">

            <div class="w-20 h-20 rounded-2xl
                        bg-[#D46417]/10
                        text-[#D46417]
                        flex items-center justify-center
                        text-3xl">

                <i class="fa-solid fa-user-shield"></i>

            </div>


            <div class="flex-1">

                <div class="flex items-center gap-3 flex-wrap">

                    <h2 class="text-2xl font-bold
                               text-gray-900 dark:text-white">

                        {{ $role->name }}

                    </h2>


                    @if($role->name === 'admin')

                        <span class="px-3 py-1 rounded-full
                                     text-xs font-semibold
                                     bg-red-50 text-red-600
                                     dark:bg-red-900/20 dark:text-red-400">

                            دور النظام الأساسي

                        </span>

                    @endif

                </div>


                <p class="text-sm text-gray-400 mt-1">
                    Role ID: {{ $role->id }}
                </p>

            </div>


            <div class="grid grid-cols-2 gap-3">

                <div class="px-5 py-4 rounded-xl
                            bg-gray-50 dark:bg-gray-800
                            text-center">

                    <div class="text-2xl font-bold
                                text-gray-900 dark:text-white">

                        {{ $role->permissions->count() }}

                    </div>

                    <div class="text-xs text-gray-400 mt-1">
                        صلاحية
                    </div>

                </div>


                <div class="px-5 py-4 rounded-xl
                            bg-gray-50 dark:bg-gray-800
                            text-center">

                    <div class="text-2xl font-bold
                                text-gray-900 dark:text-white">

                        {{ $role->users->count() }}

                    </div>

                    <div class="text-xs text-gray-400 mt-1">
                        مستخدم
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


        {{-- Permissions --}}
        <div class="bg-white dark:bg-gray-900
                    rounded-2xl shadow-sm
                    border border-gray-200
                    dark:border-gray-800">

            <div class="p-6 border-b border-gray-200
                        dark:border-gray-800">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl
                                bg-orange-50 text-[#D46417]
                                dark:bg-orange-900/20
                                flex items-center justify-center">

                        <i class="fa-solid fa-key"></i>

                    </div>

                    <div>

                        <h2 class="font-bold text-gray-900 dark:text-white">
                            الصلاحيات
                        </h2>

                        <p class="text-xs text-gray-400">
                            الصلاحيات الممنوحة لهذا الدور
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6">

                @if($role->permissions->count())

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                        @foreach($role->permissions as $permission)

                            <div class="flex items-center gap-3
                                        p-3 rounded-xl
                                        bg-gray-50 dark:bg-gray-800">

                                <div class="w-8 h-8 rounded-lg
                                            bg-[#D46417]/10
                                            text-[#D46417]
                                            flex items-center justify-center">

                                    <i class="fa-solid fa-check text-xs"></i>

                                </div>

                                <span class="text-sm text-gray-700
                                             dark:text-gray-300">

                                    {{ $permission->name }}

                                </span>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="text-center py-8 text-gray-400">

                        <i class="fa-solid fa-key text-3xl mb-3"></i>

                        <p>
                            لا توجد صلاحيات مرتبطة بهذا الدور.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- Users --}}
        <div class="bg-white dark:bg-gray-900
                    rounded-2xl shadow-sm
                    border border-gray-200
                    dark:border-gray-800">

            <div class="p-6 border-b border-gray-200
                        dark:border-gray-800">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl
                                bg-blue-50 text-blue-600
                                dark:bg-blue-900/20
                                flex items-center justify-center">

                        <i class="fa-solid fa-users"></i>

                    </div>

                    <div>

                        <h2 class="font-bold text-gray-900 dark:text-white">
                            المستخدمون
                        </h2>

                        <p class="text-xs text-gray-400">
                            المستخدمون الذين يمتلكون هذا الدور
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6">

                @if($role->users->count())

                    <div class="space-y-3">

                        @foreach($role->users as $user)

                            <div class="flex items-center gap-3
                                        p-3 rounded-xl
                                        bg-gray-50 dark:bg-gray-800">

                                <div class="w-10 h-10 rounded-full
                                            bg-[#D46417]
                                            text-white
                                            flex items-center justify-center
                                            font-bold">

                                    {{ mb_substr($user->fullname ?? $user->name ?? 'U', 0, 1) }}

                                </div>


                                <div class="flex-1 min-w-0">

                                    <div class="font-medium
                                                text-gray-800 dark:text-gray-200">

                                        {{ $user->fullname ?? $user->name }}

                                    </div>

                                    @if($user->username)

                                        <div class="text-xs text-gray-400">

                                            {{ $user->username }}

                                        </div>

                                    @endif

                                </div>


                                @if($user->phone)

                                    <div class="hidden md:block text-xs text-gray-400">

                                        {{ $user->phone }}

                                    </div>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="text-center py-8 text-gray-400">

                        <i class="fa-solid fa-users text-3xl mb-3"></i>

                        <p>
                            لا يوجد مستخدمون مرتبطون بهذا الدور.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- Metadata --}}
    <div class="bg-white dark:bg-gray-900
                rounded-2xl shadow-sm
                border border-gray-200
                dark:border-gray-800 p-6">

        <h2 class="font-bold text-gray-900 dark:text-white mb-5">
            معلومات النظام
        </h2>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-800">

                <div class="text-xs text-gray-400 mb-1">
                    رقم الدور
                </div>

                <div class="font-semibold text-gray-900 dark:text-white">
                    #{{ $role->id }}
                </div>

            </div>


            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-800">

                <div class="text-xs text-gray-400 mb-1">
                    تاريخ الإنشاء
                </div>

                <div class="font-semibold text-gray-900 dark:text-white">

                    {{ $role->created_at?->format('Y-m-d H:i') }}

                </div>

            </div>


            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-800">

                <div class="text-xs text-gray-400 mb-1">
                    آخر تحديث
                </div>

                <div class="font-semibold text-gray-900 dark:text-white">

                    {{ $role->updated_at?->format('Y-m-d H:i') }}

                </div>

            </div>

        </div>

    </div>


    {{-- Delete --}}
    @can('roles.manage')

        @if($role->name !== 'admin')

            <div class="bg-red-50 dark:bg-red-900/10
                        border border-red-200
                        dark:border-red-900/40
                        rounded-2xl p-6">

                <div class="flex flex-col md:flex-row
                            md:items-center md:justify-between gap-4">

                    <div>

                        <h3 class="font-bold text-red-700 dark:text-red-400">

                            حذف الدور

                        </h3>

                        <p class="text-sm text-red-600/80
                                  dark:text-red-400/70 mt-1">

                            حذف الدور سيؤدي إلى إزالة ارتباطه بالمستخدمين.

                        </p>

                    </div>


                    <form action="{{ route('roles.destroy', $role) }}"
                          method="POST"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟ لا يمكن التراجع عن هذه العملية.');">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="px-5 py-3 rounded-xl
                                       bg-red-600 text-white
                                       hover:bg-red-700 transition">

                            <i class="fa-solid fa-trash ml-1"></i>

                            حذف الدور

                        </button>

                    </form>

                </div>

            </div>

        @endif

    @endcan

</div>

@endsection