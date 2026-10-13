<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SocialLinkController extends Controller
{
    private const PLATFORMS = [
        'facebook',
        'instagram',
        'tiktok',
        'youtube',
        'whatsapp',
        'telegram',
        'x',
    ];

    public function index()
    {
        $socialLinks = SocialLink::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('social-links.index', [
            'socialLinks' => $socialLinks,
            'platforms' => self::PLATFORMS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => [
                'required',
                Rule::in(self::PLATFORMS),
                'unique:social_links,platform',
            ],
            'url' => ['required', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);

        SocialLink::create([
            'platform' => $validated['platform'],
            'url' => $validated['url'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('social-links.index')
            ->with('success', 'تمت إضافة رابط التواصل بنجاح.');
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform' => [
                'required',
                Rule::in(self::PLATFORMS),
                Rule::unique('social_links', 'platform')
                    ->ignore($socialLink->id),
            ],
            'url' => ['required', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);

        $socialLink->update([
            'platform' => $validated['platform'],
            'url' => $validated['url'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('social-links.index')
            ->with('success', 'تم تعديل رابط التواصل بنجاح.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return redirect()
            ->route('social-links.index')
            ->with('success', 'تم حذف رابط التواصل بنجاح.');
    }
}
