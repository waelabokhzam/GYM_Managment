@if ($errors->any())

    <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">

        <div class="flex items-center gap-2">

            <i class="fa-solid fa-circle-exclamation"></i>

            <p class="font-bold">
                يرجى تصحيح الأخطاء التالية:
            </p>

        </div>

        <ul class="mt-2 list-inside list-disc space-y-1">

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif
