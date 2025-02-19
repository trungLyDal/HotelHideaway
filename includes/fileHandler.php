<?php
function readRoomsFromCSV($filePath) {
    $rooms = [];

    if (($file = fopen($filePath, 'r')) !== FALSE) {
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            $rooms[] = [
                'room_id' => isset($row[0]) ? $row[0] : null,
                'room_type' => isset($row[1]) ? $row[1] : null,
                'price' => isset($row[2]) ? $row[2] : null,
                'availability' => isset($row[3]) ? $row[3] : null,
                'image' => isset($row[4]) ? $row[4] : null
            ];
        }
        fclose($file);
    }

    return $rooms;
}
?>