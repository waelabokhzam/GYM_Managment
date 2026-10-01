<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Game\StoreGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Models\Game;
use App\Services\Game\CreateGameService;
use App\Services\Game\DeleteGameService;
use App\Services\Game\IndexService;
use App\Services\Game\UpdateGameService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GameController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private IndexService $indexService,
        private CreateGameService $createGameService,
        private UpdateGameService $updateGameService,
        private DeleteGameService $deleteGameService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize("viewAny", Game::class);
        $games = $this->indexService->index($request);

        return view('game.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize("create", Game::class);
        return view('game.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request)
    {
        $this->authorize("create", Game::class);
        $this->createGameService->create($request->validated());
        return redirect()->route('games.index')->with('success', 'Game created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $this->authorize("view", $game);
        return view('game.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $this->authorize("update", $game);
        return view('game.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        $this->authorize("update", $game);
        $game = $this->updateGameService->update($request->validated(), $game);
        return redirect()->route('games.show', $game)->with('success', 'Game updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $this->authorize("delete", $game);
        $this->deleteGameService->delete($game);
        return redirect()->route('games.index')->with('success', 'Game deleted successfully.');
    }
}
