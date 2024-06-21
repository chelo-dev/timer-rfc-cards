<?php

namespace App\Http\Controllers\ScheduleEntrie;

use App\Helpers\SharedFunctionsHelpers;
use App\Http\Controllers\Controller;
use App\Models\ScheduleEntry;
use Exception;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    protected $shared;

    // Autorización
    public function __construct(SharedFunctionsHelpers $shared)
    {
        $this->shared = $shared;
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |   History check-in
    |----------------------------------------------------------------------------------------------------
    */

    public function checkInHistory()
    {
        try {
            $departments = $this->getCheckInHistory();

            return $this->shared->sendResponse($departments, 'Historico de check-in recuperado con exito.');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al recuperar el historico', $e->getMessage());
        }
    }

    public function getCheckInHistory()
    {
        $entries = ScheduleEntry::with(['user', 'histories'])
            ->get()
            ->map(function ($entry) {
                return [
                    'user_name' => $entry->user->name,
                    'schedule_entry' => $entry->only([
                        'uuid', 
                        'scheduled_start', 
                        'scheduled_end', 
                        'grace_period_minutes', 
                        'schedule_date'
                    ]),
                    'histories' => $entry->histories->map(function ($history) {
                        return $history->only([
                            'uuid', 
                            'check_in_time', 
                            'check_out_time', 
                            'type', 
                            'notes'
                        ]);
                    }),
                ];
            });

        return $entries;
    }

}
