<?php

namespace App\Services\Game;

use App\Models\Game;
use Illuminate\Http\Request;

class IndexService
{
    public function index(Request $request)
    {
        return Game::query()
            ->with('timeSlots')
            ->when(
                $request->search,
                function ($q) use ($request) {
                    $q->where(
                        'name',
                        'LIKE',
                        "%{$request->search}%"
                    );
                }
            )
            ->latest()
            ->get();
    }
}