<?php
function readRoomsFromCSV($filePath) {
    $rooms = [];

    if (($file = fopen($filePath, 'r')) !== FALSE) {
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            $rooms[] = [
                'room_id' => $row[0],
                'room_type' => $row[1],
                'price' => $row[2],
                'availability' => $row[3],
                'image' => isset($row[4]) ? $row[4] : null
            ];
        }
        fclose($file);
    }

    return $rooms;
}
?>