<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    /**
     * Display a listing of active games/classes with time slots.
     */
    public function index(): JsonResponse
    {
        $games = Game::with(['timeSlots'])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Games retrieved successfully',
            'data' => $games,
        ], 200);
    }
}
