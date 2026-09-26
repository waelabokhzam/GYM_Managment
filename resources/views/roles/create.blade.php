@extends('layout.app')

@section('title', 'إضافة دور جديد')

@section('content')

<div class="space-y-6" dir="rtl">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                إضافة دور جديد
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                إنشاء دور جديد وتحديد الصلاحيات الخاصة به
            </p>

        </div>

        <a href="{{ route('roles.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5
                  rounded-xl border border-gray-300
                  dark:border-gray-700
                  text-gray-700 dark:text-gray-300
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition">

            <i class="fa-solid fa-arrow-right"></i>

            العودة

        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="p-4 rounded-xl bg-red-50 border border-red-200
                    text-red-700 dark:bg-red-900/20
                    dark:border-red-800 dark:text-red-400">

            <div class="flex items-center gap-2 font-semibold mb-2">

                <i class="fa-solid fa-circle-exclamation"></i>

                يرجى تصحيح الأخطاء التالية:

            </div>

            <ul class="list-disc mr-6 text-sm space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form action="{{ route('roles.store') }}"
          method="POST">

        @csrf


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Role Information --}}
            <div class="lg:col-span-1">

                <div class="bg-white dark:bg-gray-900
                            rounded-2xl shadow-sm
                            border border-gray-200
                            dark:border-gray-800 p-6">

                    <div class="flex items-center gap-3 mb-6">

                        <div class="w-11 h-11 rounded-xl
                                    bg-[#D46417]/10
                                    text-[#D46417]
                                    flex items-center justify-center">

                            <i class="fa-solid fa-user-shield"></i>

                        </div>

                        <div>

                            <h2 class="font-bold text-gray-900 dark:text-white">
                                معلومات الدور
                            </h2>

                            <p class="text-xs text-gray-400">
                                البيانات الأساسية
                            </p>

                        </div>

                    </div>


                    <label class="block mb-2 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        اسم الدور

                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="مثال: reception"
                        required
                        class="w-full rounded-xl border border-gray-300
                               dark:border-gray-700
                               dark:bg-gray-800 dark:text-white
                               px-4 py-3
                               focus:ring-2 focus:ring-[#D46417]
                               focus:border-[#D46417]"
                    >

                    <p class="mt-2 text-xs text-gray-400">
                        يجب أن يكون اسم الدور فريداً.
                    </p>

                </div>

            </div>


            {{-- Permissions --}}
            <div class="lg:col-span-2">

                <div class="bg-white dark:bg-gray-900
                            rounded-2xl shadow-sm
                            border border-gray-200
                            dark:border-gray-800 p-6">

                    <div class="flex flex-col md:flex-row
                                md:items-center md:justify-between gap-3 mb-6">

                        <div>

                            <h2 class="font-bold text-gray-900 dark:text-white">
                                الصلاحيات
                            </h2>

                            <p class="text-xs text-gray-400 mt-1">
                                اختر الصلاحيات التي يستطيع هذا الدور استخدامها
                            </p>

                        </div>

                        <div class="flex gap-2">

                            <button type="button"
                                    onclick="selectAllPermissions()"
                                    class="px-3 py-2 rounded-lg
                                           text-xs font-semibold
                                           bg-green-50 text-green-700
                                           dark:bg-green-900/20
                                           dark:text-green-400">

                                تحديد الكل

                            </button>

                            <button type="button"
                                    onclick="unselectAllPermissions()"
                                    class="px-3 py-2 rounded-lg
                                           text-xs font-semibold
                                           bg-red-50 text-red-700
                                           dark:bg-red-900/20
                                           dark:text-red-400">

                                إلغاء الكل

                            </button>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        @forelse($permissions as $permission)

                            <label class="permission-item flex items-center gap-3
                                          p-4 rounded-xl border
                                          border-gray-200 dark:border-gray-700
                                          hover:border-[#D46417]
                                          hover:bg-orange-50/50
                                          dark:hover:bg-orange-900/10
                                          cursor-pointer transition">

                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->name }}"
                                    class="permission-checkbox w-5 h-5
                                           rounded border-gray-300
                                           text-[#D46417]
                                           focus:ring-[#D46417]"
                                    @checked(in_array($permission->name, old('permissions', [])))
                                >

                                <div class="flex-1">

                                    <div class="font-medium text-sm
                                                text-gray-800 dark:text-gray-200">

                                        {{ $permission->name }}

                                    </div>

                                </div>

                                <i class="fa-solid fa-key text-gray-300"></i>

                            </label>

                        @empty

                            <div class="md:col-span-2 p-8 text-center
                                        text-gray-400">

                                لا توجد صلاحيات متاحة.

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 mt-6">

            <a href="{{ route('roles.index') }}"
               class="px-6 py-3 rounded-xl
                      border border-gray-300 dark:border-gray-700
                      text-gray-700 dark:text-gray-300
                      hover:bg-gray-50 dark:hover:bg-gray-800">

                إلغاء

            </a>

            <button type="submit"
                    class="px-7 py-3 rounded-xl
                           bg-[#D46417] text-white
                           font-semibold
                           hover:bg-[#b95512]
                           transition shadow-sm">

                <i class="fa-solid fa-save ml-1"></i>

                حفظ الدور

            </button>

        </div>

    </form>

</div>


<script>

function selectAllPermissions() {

    document
        .querySelectorAll('.permission-checkbox')
        .forEach(checkbox => checkbox.checked = true);

}

function unselectAllPermissions() {

    document
        .querySelectorAll('.permission-checkbox')
        .forEach(checkbox => checkbox.checked = false);

}

</script>

@endsection