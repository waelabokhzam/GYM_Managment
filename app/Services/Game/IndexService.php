<?php

namespace App\Services\Game;

use App\Models\Game;
use Illuminate\Http\Request;

class IndexService
{
    public function index(Request $request)
    {
        $games = Game::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%");
            })
            ->get();

        return $games;
    }
}
