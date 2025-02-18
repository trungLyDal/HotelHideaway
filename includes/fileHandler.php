<?php
function readRoomsFromCSV($filePath) {
    $rooms = [];

    if (($file = fopen($filePath, 'r'))) {
        // Skip the header row
        fgetcsv($file);

        // Read room data into an array
        while (($row = fgetcsv($file)) !== FALSE) {
            $rooms[] = [
                'room_id' => $row[0],
                'room_type' => $row[1],
                'price' => $row[2],
                'availability' => $row[3]
            ];
        }
        fclose($file);
    }

    return $rooms;
}
?>