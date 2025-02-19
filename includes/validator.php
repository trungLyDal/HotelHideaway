<?php
function filterRoomsByType($rooms, $room_type) {
    return array_filter($rooms, function ($room) use ($room_type) {
        return $room['room_type'] === $room_type;
    });
}
?>