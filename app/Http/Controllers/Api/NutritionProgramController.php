<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NutritionProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NutritionProgramController extends Controller
{
    /**
     * عرض البرنامج التغذوي الحالي للاعب (لو موجود)
     */
    public function show(Request $request, int $playerId): JsonResponse
    {
        $program = NutritionProgram::query()
            ->where('player_id', $playerId)
            ->with('meals')
            ->first();

        if (!$program) {
            return response()->json([
                'success' => true,
                'data' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatProgram($program),
        ]);
    }

    /**
     * إنشاء أو تحديث البرنامج التغذوي (edit-in-place)
     */
    public function save(Request $request, int $playerId): JsonResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
            'meals' => 'required|array|min:1',
            'meals.*.name' => 'required|string|max:255',
            'meals.*.description' => 'required|string',
            'meals.*.notes' => 'nullable|string',
        ]);

        $staff = $request->user()->staff;

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'حساب المدرب غير موجود.',
            ], 404);
        }

        $program = DB::transaction(function () use ($validated, $playerId, $staff) {
            $program = NutritionProgram::firstOrNew(['player_id' => $playerId]);

            $program->coach_id = $staff->id;
            $program->notes = $validated['notes'] ?? null;
            $program->save();

            // نحذف الوجبات القديمة ونعيد بناءها من جديد (نفس منطق التدريبي)
            $program->meals()->delete();

            foreach ($validated['meals'] as $mealData) {
                $program->meals()->create([
                    'name' => $mealData['name'],
                    'description' => $mealData['description'],
                    'notes' => $mealData['notes'] ?? null,
                ]);
            }

            return $program->fresh('meals');
        });

        return response()->json([
            'success' => true,
            'data' => $this->formatProgram($program),
        ]);
    }

    private function formatProgram(NutritionProgram $program): array
    {
        return [
            'id' => $program->id,
            'player_id' => $program->player_id,
            'coach_id' => $program->coach_id,
            'notes' => $program->notes,
            'updated_at' => $program->updated_at->toIso8601String(),
            'meals' => $program->meals->map(function ($meal) {
                return [
                    'id' => $meal->id,
                    'name' => $meal->name,
                    'description' => $meal->description,
                    'notes' => $meal->notes,
                ];
            })->values(),
        ];
    }
}
