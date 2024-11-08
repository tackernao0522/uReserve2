<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventService
{
    public static function checkEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
            ->whereDate('start_date', $eventDate) // 日にち
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists(); // 存在確認
    }

    public static function countEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->count();
    }

    public static function joinDateAndTime($date, $time)
    {
        $join = $date . ' ' . $time;

        return Carbon::createFromFormat('Y-m-d H:i', $join);
    }

    public static function getWeekEvents($startDate, $endDate)
    {
        $reservedPeople = Reservation::reservedPeople();

        return DB::table('events')
            ->leftJoinSub($reservedPeople, 'reservedPeople', function ($join) {
                $join->on('events.id', '=', 'reservedPeople.event_id');
            })
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderBy('start_date', 'ASC')
            ->get();
    }
}
