<?php
require_once '../includes/fileHandler.php';
require_once '../includes/validator.php';

if (isset($_GET['room_type'])) {
    $selected_room_type = $_GET['room_type'];

    $rooms = readRoomsFromCSV('../data/rooms.csv');

    $filtered_rooms = filterRoomsByType($rooms, $selected_room_type);
}

include_once '../templates/header.php';
?>

<section class="page-section clearfix">
    <div class="container">
        <div class="intro">
            <img class="intro-img img-fluid mb-3 mb-lg-0 rounded" src="../assets/img/intro.jpg" alt="intro picture" />
            <div class="intro-text left-0 text-center bg-faded p-5 rounded">
                <h2 class="section-heading mb-4">
                    <span class="section-heading-upper">Find</span>
                    <span class="section-heading-lower">Your Room</span>
                </h2>
                <!-- Search Form -->
                <form action="#results" method="GET" class="mb-3">
                    <label for="room_type" class="form-label">Select Room Type:</label>
                    <select name="room_type" id="room_type" class="form-select" required>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Suite">Suite</option>
                        <option value="Royal">Royal</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-xl mt-3">Search Now</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php if (isset($filtered_rooms)): ?>
    <div id="results">
        <section class="page-section cta">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 mx-auto">
                        <div class="cta-inner bg-faded text-center rounded">
                            <h2 class="section-heading mb-4">
                                <span class="section-heading-upper">Search Results</span>
                                <span class="section-heading-lower">Available Rooms</span>
                            </h2>

                            <?php if (!empty($filtered_rooms)): ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Room ID</th>
                                            <th>Room Type</th>
                                            <th>Price</th>
                                            <th>Availability</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php foreach ($filtered_rooms as $room): ?>
        <tr onclick="window.location='index.php?room_id=<?php echo $room['room_id']; ?>#room-details';"
            style="cursor: pointer;"
            class="<?php echo (isset($_GET['room_id']) && $_GET['room_id'] == $room['room_id']) ? 'selected' : ''; ?>">
            <td><?php echo htmlspecialchars($room['room_id']); ?></td>
            <td><?php echo htmlspecialchars($room['room_type']); ?></td>
            <td><?php echo htmlspecialchars("$" . number_format($room['price'], 2)); ?></td>
            <td class="availability <?php echo trim(strtolower($room['availability'])) === 'booked' ? 'booked' : 'available'; ?>">
    <?php echo htmlspecialchars($room['availability']); ?>
</td>
        </tr>
    <?php endforeach; ?>
</tbody>
                                </table>
                                <a href="#search" class="btn btn-primary">Back to Search</a>
                            <?php else: ?>
                                <p>No available rooms found for the selected room type.</p>
                                <a href="#search" class="btn btn-primary">Back to Search</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php endif; ?>

<?php if (isset($_GET['room_id'])): ?>
    <?php
    $room_id = $_GET['room_id'];
    $rooms = readRoomsFromCSV('../data/rooms.csv');
    $room_details = null;

    foreach ($rooms as $room) {
        if ($room['room_id'] == $room_id) {
            $room_details = $room;
            break;
        }
    }
    ?>

    <?php if ($room_details): ?>
        <section class="page-section cta" id = "room-details">
            <div class="container">
                <div class="cta-inner bg-faded text-center rounded">
                <h2 class="section-heading mb-4">
                                <span class="section-heading-upper">Search Result</span>
                                <span class="section-heading-lower">Available Room</span>
                            </h2>
                    <img src="<?php echo htmlspecialchars($room_details['image']); ?>"
                         alt="<?php echo htmlspecialchars($room_details['room_type']); ?>"
                         class="img-fluid mb-3">
                    <p><strong>Room ID:</strong> <?php echo htmlspecialchars($room_details['room_id']); ?></p>
                    <p><strong>Room Type:</strong> <?php echo htmlspecialchars($room_details['room_type']); ?></p>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($room_details['price']); ?>/night</p>
                    <p>
                    <strong>Availability:</strong>
                    <span class="availability <?php echo trim(strtolower($room_details['availability'])) === 'booked' ? 'booked' : 'available'; ?>">
    <?php echo htmlspecialchars($room_details['availability']); ?>
</span>
                    </p>                   
                <a href="#search" class="btn btn-primary">Back to Search</a>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>

<?php
include_once '../templates/footer.php';
?>