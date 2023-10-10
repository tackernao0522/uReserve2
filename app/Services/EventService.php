<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventService
{
    public static function checkEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists();
    }

    public static function joinDateAndTime($eventDate, $startTime, $endTime)
    {
        $start = $eventDate . ' ' . $startTime;
        $startDate = Carbon::createFromFormat('Y-m-d H:i', $start);

        $end = $eventDate . ' ' . $endTime;
        $endDate = Carbon::createFromFormat('Y-m-d H:i', $end);

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
