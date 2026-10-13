@extends('layout.app')

@section('title', 'روابط التواصل الاجتماعي')
@section('page-title', 'روابط التواصل الاجتماعي')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-extrabold">إدارة روابط التواصل الاجتماعي</h2>
            <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                إضافة وتعديل روابط التواصل والتحكم بظهورها في التطبيق
            </p>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-green-500/20 bg-green-500/10 p-4 text-sm font-medium text-green-500">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-400">
            <div class="mb-2 font-bold">يرجى تصحيح الأخطاء التالية:</div>
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Add Social Link --}}
    <div class="rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5">

        <div class="mb-5 flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#D46417]/10 text-lg text-[#D46417]">
                <i class="fa-solid fa-plus"></i>
            </div>

            <div>
                <h3 class="font-extrabold">إضافة رابط جديد</h3>
                <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                    اختر المنصة وأدخل رابط حساب النادي
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('social-links.store') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-bold">المنصة</label>

                <select name="platform" required
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                    <option value="">اختر المنصة</option>

                    @foreach($platforms as $platform)
                        @if(!$socialLinks->contains('platform', $platform))
                            <option value="{{ $platform }}" @selected(old('platform') === $platform)>
                                @switch($platform)
                                    @case('facebook') Facebook @break
                                    @case('instagram') Instagram @break
                                    @case('tiktok') TikTok @break
                                    @case('youtube') YouTube @break
                                    @case('whatsapp') WhatsApp @break
                                    @case('telegram') Telegram @break
                                    @case('x') X @break
                                    @default {{ ucfirst($platform) }}
                                @endswitch
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-1 lg:col-span-2">
                <label class="mb-2 block text-sm font-bold">رابط الحساب</label>

                <input type="url" name="url" value="{{ old('url') }}"
                    placeholder="https://..."
                    required maxlength="2048" dir="ltr"
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-left text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold">ترتيب الظهور</label>

                <input type="number" name="sort_order"
                    value="{{ old('sort_order', 0) }}"
                    min="0" max="65535"
                    class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
            </div>

            <div class="flex items-center gap-3 md:col-span-2 lg:col-span-4">
                <label class="flex cursor-pointer items-center gap-2 text-sm font-medium">
                    <input type="checkbox" name="is_active" value="1"
                        @checked(old('is_active', '1') == '1')
                        class="h-4 w-4 rounded border-[var(--color-border)] accent-[#D46417]">
                    تفعيل الرابط مباشرة
                </label>
            </div>

            <div class="md:col-span-2 lg:col-span-4">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#D46417]/20 transition hover:bg-[#b95412]">
                    <i class="fa-solid fa-plus"></i>
                    إضافة الرابط
                </button>
            </div>
        </form>
    </div>

    {{-- Social Links Table --}}
    <div class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)]">

        <div class="flex flex-col gap-2 border-b border-[var(--color-border)] p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="font-extrabold">روابط التواصل المضافة</h3>
                <p class="mt-1 text-xs text-[var(--color-text-muted)]">
                    عدد الروابط: {{ $socialLinks->count() }}
                </p>
            </div>

            <div class="text-xs text-[var(--color-text-muted)]">
                تظهر الروابط المفعّلة فقط في التطبيق
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-right">

                <thead class="border-b border-[var(--color-border)] bg-[var(--color-background)]">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">المنصة</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">الرابط</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">الترتيب</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">الحالة</th>
                        <th class="px-6 py-4 text-xs font-bold text-[var(--color-text-muted)]">الإجراءات</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[var(--color-border)]">

                    @forelse($socialLinks as $socialLink)

                        @php
                            $platformInfo = [
                                'facebook' => ['name' => 'Facebook', 'icon' => 'fa-brands fa-facebook', 'color' => '#1877F2'],
                                'instagram' => ['name' => 'Instagram', 'icon' => 'fa-brands fa-instagram', 'color' => '#E4405F'],
                                'tiktok' => ['name' => 'TikTok', 'icon' => 'fa-brands fa-tiktok', 'color' => '#111827'],
                                'youtube' => ['name' => 'YouTube', 'icon' => 'fa-brands fa-youtube', 'color' => '#FF0000'],
                                'whatsapp' => ['name' => 'WhatsApp', 'icon' => 'fa-brands fa-whatsapp', 'color' => '#25D366'],
                                'telegram' => ['name' => 'Telegram', 'icon' => 'fa-brands fa-telegram', 'color' => '#229ED9'],
                                'x' => ['name' => 'X', 'icon' => 'fa-brands fa-x-twitter', 'color' => 'var(--color-text)'],
                            ];

                            $info = $platformInfo[$socialLink->platform] ?? [
                                'name' => ucfirst($socialLink->platform),
                                'icon' => 'fa-solid fa-link',
                                'color' => '#D46417',
                            ];
                        @endphp

                        <tr class="transition hover:bg-[var(--color-surface-hover)]">

                            {{-- Platform --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--color-background)] text-xl"
                                        style="color: {{ $info['color'] }}">
                                        <i class="{{ $info['icon'] }}"></i>
                                    </div>

                                    <div class="font-bold">{{ $info['name'] }}</div>
                                </div>
                            </td>

                            {{-- URL --}}
                            <td class="px-6 py-4">
                                <a href="{{ $socialLink->url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    dir="ltr"
                                    title="{{ $socialLink->url }}"
                                    class="block max-w-[320px] truncate text-left text-sm text-[#D46417] hover:underline">
                                    {{ $socialLink->url }}
                                </a>
                            </td>

                            {{-- Sort Order --}}
                            <td class="px-6 py-4">
                                <span class="rounded-lg bg-[var(--color-background)] px-3 py-1.5 text-xs font-bold">
                                    {{ $socialLink->sort_order }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($socialLink->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-green-500/10 px-3 py-1.5 text-xs font-bold text-green-500">
                                        <i class="fa-solid fa-circle-check"></i>
                                        مفعّل
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-red-500/10 px-3 py-1.5 text-xs font-bold text-red-400">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        معطّل
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">

                                    <button type="button"
                                        onclick="openEditModal({{ $socialLink->id }})"
                                        title="تعديل"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] transition hover:border-[#D46417] hover:text-[#D46417]">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>

                                    <form method="POST"
                                        action="{{ route('social-links.destroy', $socialLink) }}"
                                        onsubmit="return confirm('هل أنت متأكد من حذف رابط {{ $info['name'] }}؟')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            title="حذف"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/20 text-red-400 transition hover:bg-red-500/10">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#D46417]/10 text-2xl text-[#D46417]">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </div>

                                <h3 class="mt-4 font-bold">لا توجد روابط تواصل</h3>

                                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                                    أضف أول رابط باستخدام النموذج أعلاه
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Edit Modal --}}
<div id="editSocialModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm">

    <div class="w-full max-w-lg rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-2xl">

        <div class="mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-extrabold">تعديل رابط التواصل</h3>
                <p class="mt-1 text-sm text-[var(--color-text-muted)]">
                    عدّل بيانات الرابط ثم احفظ التغييرات
                </p>
            </div>

            <button type="button" onclick="closeEditModal()"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[var(--color-border)] hover:text-red-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editSocialForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                <div>
                    <label class="mb-2 block text-sm font-bold">المنصة</label>

                    <select id="edit_platform" name="platform" required
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                        @foreach($platforms as $platform)
                            <option value="{{ $platform }}">
                                @switch($platform)
                                    @case('facebook') Facebook @break
                                    @case('instagram') Instagram @break
                                    @case('tiktok') TikTok @break
                                    @case('youtube') YouTube @break
                                    @case('whatsapp') WhatsApp @break
                                    @case('telegram') Telegram @break
                                    @case('x') X @break
                                    @default {{ ucfirst($platform) }}
                                @endswitch
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold">رابط الحساب</label>

                    <input id="edit_url" type="url" name="url"
                        required maxlength="2048" dir="ltr"
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-left text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold">ترتيب الظهور</label>

                    <input id="edit_sort_order" type="number" name="sort_order"
                        min="0" max="65535" required
                        class="w-full rounded-xl border border-[var(--color-border)] bg-[var(--color-background)] px-4 py-3 text-sm outline-none transition focus:border-[#D46417] focus:ring-2 focus:ring-[#D46417]/10">
                </div>

                <label class="flex cursor-pointer items-center gap-2 text-sm font-medium">
                    <input id="edit_is_active" type="checkbox" name="is_active" value="1"
                        class="h-4 w-4 rounded border-[var(--color-border)] accent-[#D46417]">
                    تفعيل الرابط
                </label>

            </div>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="button" onclick="closeEditModal()"
                    class="rounded-xl border border-[var(--color-border)] px-5 py-3 text-sm font-bold transition hover:bg-[var(--color-surface-hover)]">
                    إلغاء
                </button>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#D46417] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b95412]">
                    <i class="fa-solid fa-floppy-disk"></i>
                    حفظ التعديلات
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    const socialLinksData = {{ Illuminate\Support\Js::from(
        $socialLinks->mapWithKeys(function ($link) {
            return [
                $link->id => [
                    'platform' => $link->platform,
                    'url' => $link->url,
                    'is_active' => $link->is_active,
                    'sort_order' => $link->sort_order,
                ],
            ];
        })->all()
    ) }};

    const editModal = document.getElementById('editSocialModal');
    const editForm = document.getElementById('editSocialForm');

    function openEditModal(id) {
        const link = socialLinksData[id];

        if (!link) {
            return;
        }

        editForm.action = @json(url('/social-links')) + '/' + id;

        document.getElementById('edit_platform').value = link.platform;
        document.getElementById('edit_url').value = link.url;
        document.getElementById('edit_sort_order').value = link.sort_order;
        document.getElementById('edit_is_active').checked = Boolean(link.is_active);

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
    }

    editModal.addEventListener('click', function (event) {
        if (event.target === editModal) {
            closeEditModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeEditModal();
        }
    });
</script>
@endpush



@endsection
