<?php
require_once '../includes/fileHandler.php';

$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;
$room_type = isset($_GET['room_type']) ? htmlspecialchars($_GET['room_type']) : '';
$checkin_date = isset($_GET['checkin_date']) ? htmlspecialchars($_GET['checkin_date']) : '';
$checkout_date = isset($_GET['checkout_date']) ? htmlspecialchars($_GET['checkout_date']) : '';

$rooms = readRoomsFromCSV('../data/rooms.csv');
$room_details = null;

foreach ($rooms as $room) {
    if ($room['room_id'] == $room_id) {
        $room_details = $room;
        break;
    }
}

include_once '../templates/header.php';
?>

<section class="page-section cta">
    <div class="container">
        <div class="cta-inner bg-faded text-center rounded">
            <h2>Booking Confirmation</h2>
            <?php if ($room_details): ?>
                <p><strong>Guest Name:</strong> <?php echo $name; ?></p>
                <p><strong>Check-in Date:</strong> <?php echo $checkin_date; ?></p>
                <p><strong>Check-out Date:</strong> <?php echo $checkout_date; ?></p>
                <img src="<?php echo htmlspecialchars($room_details['image']); ?>" alt="<?php echo htmlspecialchars($room_details['room_type']); ?>" class="img-fluid mb-3">
                <div class="table-container">
                    <table class="table table-bordered">
                        <tr>
                            <th>Room ID</th>
                            <td><?php echo htmlspecialchars($room_details['room_id']); ?></td>
                        </tr>
                        <tr>
                            <th>Room Type</th>
                            <td><?php echo htmlspecialchars($room_details['room_type']); ?></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>$<?php echo htmlspecialchars($room_details['price']); ?>/night</td>
                        </tr>
                        
                    </table>
                </div>
                <p>Your booking has been confirmed.</p>
            <?php else: ?>
                <p>Room details not found.</p>
            <?php endif; ?>
            <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</section>

<?php
include_once '../templates/footer.php';
?>