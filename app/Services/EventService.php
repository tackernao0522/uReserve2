<?php

namespace App\Services;

use Carbon\Carbon;

class EventService
{
    public static function parseDateTime($eventDate, $startTime, $endTime)
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
