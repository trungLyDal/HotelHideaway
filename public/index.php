<?php
require_once '../includes/fileHandler.php';
require_once '../includes/validator.php';

if (isset($_GET['room_type'])) {
    $selected_room_type = $_GET['room_type'];
    $rooms = readRoomsFromCSV('../data/rooms.csv');
    $filtered_rooms = filterRoomsByType($rooms, $selected_room_type);
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_submit'])) {
    $name = htmlspecialchars(trim($_POST['guest_name']));
    $room_id = intval($_POST['room_id']);
    $room_type = htmlspecialchars(trim($_POST['room_type']));
    $checkin_date = htmlspecialchars(trim($_POST['checkin_date']));
    $checkout_date = htmlspecialchars(trim($_POST['checkout_date']));
    


    $rooms = readRoomsFromCSV('../data/rooms.csv');
    $room_details = null;
    foreach ($rooms as $room) {
        if ($room['room_id'] == $room_id) {
            $room_details = $room;
            break;
        }
    }

    if ($room_details === null) {  
        $errors[] = "Invalid room ID.";
    } else if (strtolower(trim($room_details['availability'])) !== 'available') {
        $errors[] = "Room is not available";
    }

    if (empty($errors)) {
        $booking_data = [
            'name' => $name,
            'room_id' => $room_id,
            'room_type' => $room_type,
            'checkin_date' => $checkin_date,
            'checkout_date' => $checkout_date,
        ];

        if (appendBookingToCSV($booking_data, '../data/bookings.csv')) {
            $success_message = "Booking successful!";
            unset($name, $checkin_date, $checkout_date); 
        } else {
            $errors[] = "Error saving booking. Please try again.";
        }
    }
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
        <section class="page-section cta" id="room-details">
            <div class="container">
                <div class="cta-inner bg-faded text-center rounded">
                    <h1 id = #room-details>Room Details</h1>
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
                            <tr>
                                <th>Availability</th>
                                <td>
                                    <span class="availability <?php echo trim(strtolower($room_details['availability'])) === 'booked' ? 'booked' : 'available'; ?>">
                                        <?php echo htmlspecialchars($room_details['availability']); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <a href="#search" class="btn btn-primary">Back to Search</a>

                    <?php if (strtolower(trim($room_details['availability'])) === 'available'): ?>
                        <section class="page-section clearfix">
                            <div id="booking-form-container">
                                <h2>Book This Room</h2>  
                                <form id="booking-form" action="index.php#room-details" method="POST">
                                    <input type="hidden" name="booking_submit" value="true">
                                    <input type="hidden" name="room_id" value="<?php echo $room_details['room_id']; ?>">
                                    <input type="hidden" name="room_type" value="<?php echo $room_details['room_type']; ?>">

                                    <label for="guest_name">Name:</label>
                                    <input type="text" name="guest_name" id="guest_name" value="<?php echo isset($name) ? $name : ''; ?>" required><br><br>

                                    <label for="checkin_date">Check-in Date:</label>
                                    <input type="date" name="checkin_date" id="checkin_date" value="<?php echo isset($checkin_date) ? $checkin_date : ''; ?>" required><br><br>

                                    <label for="checkout_date">Check-out Date:</label>
                                    <input type="date" name="checkout_date" id="checkout_date" value="<?php echo isset($checkout_date) ? $checkout_date : ''; ?>" required><br><br>

                                    <button type="button" class="btn btn-secondary cancel-booking">Cancel</button>
                                    <button class="btn btn-primary" type="submit" name ="booking_submit">Submit Booking</button>
                                    
                                </form>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>
<?php
include_once '../templates/footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('booking-form');
    const checkinDateInput = document.getElementById('checkin_date');
    const checkoutDateInput = document.getElementById('checkout_date');
    const cancelButton = document.querySelector('.cancel-booking');


    if (!bookingForm) {
        console.error("Booking form not found!");
        return; 
    }

    if (!checkinDateInput) {
        console.error("Check-in input not found!");
        return;
    }

    if (!checkoutDateInput) {
        console.error("Check-out input not found!");
        return;
    }

    if (cancelButton) {
        cancelButton.addEventListener('click', function() {
            window.location.href = "#search";
    });
    }

    bookingForm.addEventListener('submit', function (event) {
        const checkInDateStr = checkinDateInput.value;
        const checkOutDateStr = checkoutDateInput.value;

    

        const [checkInYear, checkInMonth, checkInDay] = checkInDateStr.split('-').map(Number);
        const [checkOutYear, checkOutMonth, checkOutDay] = checkOutDateStr.split('-').map(Number);

        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth() + 1;
        const currentDay = today.getDate();
        console.log(checkInYear, checkInMonth, checkInDay);
        console.log(checkOutYear, checkOutMonth, checkOutDay);

        if (
            checkInYear > checkOutYear ||
            (checkInYear === checkOutYear && checkInMonth > checkOutMonth) ||
            (checkInYear === checkOutYear && checkInMonth === checkOutMonth && checkInDay >= checkOutDay) || 
            (checkInYear === currentYear && checkInMonth < currentMonth) ||
            (checkInYear === currentYear && checkInMonth === currentMonth && checkInDay < currentDay) || 
            checkOutYear < currentYear ||
            (checkOutYear === currentYear && checkOutMonth < currentMonth) ||
            (checkOutYear === currentYear && checkOutMonth === currentMonth && checkOutDay < currentDay) 
        ) {
            alert('Check-out date must be after or same as check-in date and both dates must be today or later.');
            event.preventDefault();
        }
    });

});
</script>