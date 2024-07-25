<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = "histories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'schedule_entrie_id',
        'check_in_time',
        'check_out_time',
        'type',
        'notes',
        'check_date_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function scheduleEntry()
    {
        return $this->belongsTo(ScheduleEntry::class, 'schedule_entrie_id');
    }
}
