<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Player\StorePlayerRequest;
use App\Http\Requests\Player\UpdatePlayerRequest;
use App\Models\Player;
use App\Services\Player\PlayerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class PlayerController extends Controller
{
    public function __construct(
        private readonly PlayerService $playerService
    ) {
    }

    /**
     * عرض جميع اللاعبين
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Player::class);

        $players = Player::with('user')
            ->latest()
            ->paginate(15);

        return view('players.index', compact('players'));
    }

    /**
     * عرض صفحة إنشاء لاعب
     */
    public function create(): View
    {
        Gate::authorize('create', Player::class);

        return view('players.create');
    }

    /**
     * تخزين لاعب جديد
     */
    public function store(StorePlayerRequest $request): RedirectResponse
    {
        Gate::authorize('create', Player::class);

        $player = $this->playerService->createPlayer(
            $request->validated()
        );

        return redirect()
            ->route('players.index')
            ->with('success', 'تم إنشاء اللاعب بنجاح.')
            ->with(
                'generated_username',
                $player->user->username
            )
            ->with(
                'unique_number',
                $player->unique_number
            );
    }

    /**
     * عرض بيانات لاعب
     */
    public function show(Player $player): View
    {
        Gate::authorize('view', $player);

        $player->load('user');

        return view('players.show', compact('player'));
    }

    /**
     * عرض صفحة تعديل اللاعب
     */
    public function edit(Player $player): View
    {
        Gate::authorize('update', $player);

        $player->load('user');

        return view('players.edit', compact('player'));
    }

    /**
     * تحديث بيانات اللاعب
     */
    public function update(
        UpdatePlayerRequest $request,
        Player $player
    ): RedirectResponse {
        Gate::authorize('update', $player);

        $this->playerService->updatePlayer(
            $player,
            $request->validated()
        );

        return redirect()
            ->route('players.index')
            ->with('success', 'تم تحديث بيانات اللاعب بنجاح.');
    }

    /**
     * حذف اللاعب
     */
    public function destroy(Player $player): RedirectResponse
    {
        Gate::authorize('delete', $player);

        $this->playerService->deletePlayer($player);

        return redirect()
            ->route('players.index')
            ->with('success', 'تم حذف اللاعب بنجاح.');
    }
}