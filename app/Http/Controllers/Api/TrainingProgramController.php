<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingProgramController extends Controller
{
    /**
     * عرض البرنامج التدريبي الحالي للاعب (لو موجود)
     */
    public function show(Request $request, int $playerId): JsonResponse
    {
        $program = TrainingProgram::query()
            ->where('player_id', $playerId)
            ->with('days.exercises')
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
     * إنشاء أو تحديث البرنامج التدريبي (edit-in-place)
     */
    public function save(Request $request, int $playerId): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'days' => 'required|array|min:1',
            'days.*.title' => 'required|string|max:255',
            'days.*.exercises' => 'required|array|min:1',
            'days.*.exercises.*.name' => 'required|string|max:255',
            'days.*.exercises.*.sets' => 'required|integer|min:1',
            'days.*.exercises.*.reps' => 'required|integer|min:1',
            'days.*.exercises.*.notes' => 'nullable|string',
        ]);

        $staff = $request->user()->staff;

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'حساب المدرب غير موجود.',
            ], 404);
        }

        $program = DB::transaction(function () use ($validated, $playerId, $staff) {
            // نبحث إذا في برنامج موجود أصلاً لهاد اللاعب
            $program = TrainingProgram::firstOrNew(['player_id' => $playerId]);

            $program->coach_id = $staff->id;
            $program->title = $validated['title'];
            $program->notes = $validated['notes'] ?? null;
            $program->save();

            // نحذف الأيام القديمة بالكامل، ونعيد بناءها من جديد
            // (أبسط بكتير من محاولة نقارن ونحدث عنصر عنصر)
            $program->days()->delete();

            foreach ($validated['days'] as $index => $dayData) {
                $day = $program->days()->create([
                    'title' => $dayData['title'],
                    'order' => $index,
                ]);

                foreach ($dayData['exercises'] as $exerciseData) {
                    $day->exercises()->create([
                        'name' => $exerciseData['name'],
                        'sets' => $exerciseData['sets'],
                        'reps' => $exerciseData['reps'],
                        'notes' => $exerciseData['notes'] ?? null,
                    ]);
                }
            }

            return $program->fresh('days.exercises');
        });

        return response()->json([
            'success' => true,
            'data' => $this->formatProgram($program),
        ]);
    }

    private function formatProgram(TrainingProgram $program): array
    {
        return [
            'id' => $program->id,
            'player_id' => $program->player_id,
            'coach_id' => $program->coach_id,
            'title' => $program->title,
            'notes' => $program->notes,
            'updated_at' => $program->updated_at->toIso8601String(),
            'days' => $program->days->map(function ($day) {
                return [
                    'id' => $day->id,
                    'title' => $day->title,
                    'exercises' => $day->exercises->map(function ($exercise) {
                        return [
                            'id' => $exercise->id,
                            'name' => $exercise->name,
                            'sets' => $exercise->sets,
                            'reps' => $exercise->reps,
                            'notes' => $exercise->notes,
                        ];
                    })->values(),
                ];
            })->values(),
        ];
    }
}
