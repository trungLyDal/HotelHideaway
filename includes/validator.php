<?php
function filterRoomsByType($rooms, $room_type) {
    return array_filter($rooms, function ($room) use ($room_type) {
        return $room['room_type'] === $room_type;
    });
}

function isDateValid($date) {
   $date_format = 'Y-m-d';
    $date_obj = DateTime::createFromFormat($date_format, $date);
    return $date_obj && $date_obj->format($date_format) === $date;
}
?>