<?php

namespace App\Services\Receipt;

use App\Models\Receipt;
use Illuminate\Http\Request;

class IndexService
{
    public function index(Request $request)
    {
        $receipt = Receipt::query()
            ->when($request->filterByGame && $request->filterByGame != "all", function ($q) use ($request) {
                $q->where('game_id', $request->filterByGame);
            })
            ->when($request->filterByPlayer && $request->filterByPlayer != "all", function ($q) use ($request) {
                $q->where('player_id', $request->filterByPlayer);
            })
            ->when($request->searchStaff, function ($q) use ($request) {
                $q->whereHas('receivedBy.user', function ($q) use ($request) {
                    $q->where("name", "LIKE", "%{$request->searchStaff}%");
                });
            })
            ->get();

        return $receipt;
    }
}