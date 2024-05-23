<?php

namespace App\Http\Controllers\ScheduleEntrie;

use App\Helpers\SharedFunctionsHelpers;
use App\Http\Controllers\Controller;
use App\Models\ScheduleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\History;
use App\Models\User;
use Carbon\Carbon;

class ScheduleEntrieController extends Controller
{
    protected $shared;

    // Autorización
    public function __construct(SharedFunctionsHelpers $shared)
    {
        $this->shared = $shared;
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |    Check de entrada y salida
    |----------------------------------------------------------------------------------------------------
    */

    public function checkIn(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:users,uuid',
        ]);

        $user = User::where('uuid', $validatedData['uuid'])->firstOrFail();
        $now = Carbon::now();
        
        // Obtener el horario programado para hoy
        $schedule = ScheduleEntry::where('user_id', $user->id)
            ->where('schedule_date', $now->toDateString())
            ->first();

        if (!$schedule) {
            return $this->shared->sendError('No se encontró ningún horario programado para hoy.');
        }

        // Validar hora de entrada con margen de gracia
        $scheduledTime = Carbon::parse($schedule->scheduled_start);
        $gracePeriodEnd = $scheduledTime->copy()->addMinutes($schedule->grace_period_minutes);

        if ($now->lessThan($scheduledTime) || $now->greaterThan($gracePeriodEnd)) {
            return $this->shared->sendError('Esta fuera del horario programado.', 403);
        }

        // Registrar check-in
        // Aquí iría la lógica para registrar la hora de entrada en `histories`
        History::create([
            'uuid' => Str::uuid(),
            'schedule_entrie_id' => $schedule->id,
            'check_in_time' => $now,
            'type' => 'check-in'
        ]);

        return $this->shared->sendResponse([], 'Registro exitoso.');
    }

    public function checkOut(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:users,uuid',
        ]);

        $user = User::where('uuid', $validatedData['uuid'])->firstOrFail();
        $now = Carbon::now();

        // Similar a checkIn pero con la hora de salida programada
        $schedule = ScheduleEntry::where('user_id', $user->id)
            ->where('schedule_date', $now->toDateString())
            ->first();

        if (!$schedule) {
            return $this->shared->sendError('No se encontró ningún horario programado para hoy.');
        }

        // Validar hora de salida con margen de gracia
        $scheduledEndTime = Carbon::parse($schedule->scheduled_end);
        $gracePeriodEnd = $scheduledEndTime->copy()->addMinutes($schedule->grace_period_minutes);

        if ($now->lessThan($scheduledEndTime) || $now->greaterThan($gracePeriodEnd)) {
            return $this->shared->sendError('Esta fuera del horario programado.', 403);
        }

        // Registrar check-out
        // Aquí iría la lógica para registrar la hora de salida en `histories`
        History::create([
            'uuid' => Str::uuid(),
            'schedule_entrie_id' => $schedule->id,
            'check_out_time' => $now,
            'check_in_time' => $now,
            'type' => 'check-out'
        ]);

        return $this->shared->sendResponse([], 'Registro exitoso.');
    }
}
