<div>
    カレンダー
    <input type="text" class="block mt-1 w-full" id="calendar" name="calendar" value="{{ $currentDate }}"
        wire:change="getDate($event.target.value)">
    <div class="flex">
        @for ($day = 0; $day < 7; $day++)
            {{ $currentWeek[$day] }}
        @endfor
    </div>
</div>