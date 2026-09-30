<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerGame\StorePlayerGameRequest;
use App\Http\Requests\PlayerGame\UpdatePlayerGameRequest;
use App\Models\Game;
use App\Models\Player;
use App\Models\PlayerGame;
use App\Services\PlayerGame\PlayerGameService;
use Illuminate\Support\Facades\Gate;

class PlayerGameController extends Controller
{
    public function __construct(
        private PlayerGameService $service
    ) {}

    public function index()
    {
        Gate::authorize('viewAny', PlayerGame::class);

        $playerGames = PlayerGame::with([
            'player.user',
            'game',
        ])->paginate(10);

        return view(
            'player_games.index',
            compact('playerGames')
        );
    }

    public function create()
    {
        Gate::authorize('create', PlayerGame::class);

        $players = Player::with('user')->get();

        $games = Game::orderBy('name')->get();

        return view(
            'player_games.create',
            compact('players', 'games')
        );
    }

    public function store(StorePlayerGameRequest $request)
    {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('player-games.index')
            ->with('success', 'تم ربط اللاعب باللعبة بنجاح.');
    }

    public function show(PlayerGame $playerGame)
    {
        Gate::authorize('view', $playerGame);

        $playerGame->load([
            'player.user',
            'game',
        ]);

        return view(
            'player_games.show',
            compact('playerGame')
        );
    }

    public function edit(PlayerGame $playerGame)
    {
        Gate::authorize('update', $playerGame);

        $players = Player::with('user')->get();

        $games = Game::orderBy('name')->get();

        return view(
            'player_games.edit',
            compact(
                'playerGame',
                'players',
                'games'
            )
        );
    }

    public function update(
        UpdatePlayerGameRequest $request,
        PlayerGame $playerGame
    ) {

        $this->service->update(
            $playerGame,
            $request->validated()
        );

        return redirect()
            ->route('player-games.index')
            ->with('success', 'تم تحديث الربط.');
    }

    public function destroy(PlayerGame $playerGame)
    {
        Gate::authorize('delete', $playerGame);

        $this->service->delete($playerGame);

        return redirect()
            ->route('player-games.index')
            ->with('success', 'تم حذف الربط.');
    }
}