<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve user data
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Retrieve parking reservations
$sql_reservations = "SELECT * FROM parking_reservations WHERE user_id = $user_id";
$result_reservations = $conn->query($sql_reservations);

// Handle new reservation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reserve'])) {
    $parking_spot = $_POST['parking_spot'];
    $reservation_time = $_POST['reservation_time'];

    // Insert reservation
    $sql_reserve = "INSERT INTO parking_reservations (user_id, parking_spot, reservation_time) 
                    VALUES ('$user_id', '$parking_spot', '$reservation_time')";
    if ($conn->query($sql_reserve) === TRUE) {
        echo "Parking spot reserved successfully!";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

    <h2>Your Profile</h2>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

    <h2>Your Parking Reservations</h2>
    <?php
    if ($result_reservations->num_rows > 0) {
        while ($reservation = $result_reservations->fetch_assoc()) {
            echo "<p>Spot: " . htmlspecialchars($reservation['parking_spot']) . " | Time: " . htmlspecialchars($reservation['reservation_time']) . "</p>";
        }
    } else {
        echo "<p>No reservations found.</p>";
    }
    ?>

    <h3>Reserve a New Parking Spot</h3>
    <form method="POST" action="dashboard.php">
        <label for="parking_spot">Parking Spot:</label>
        <input type="text" name="parking_spot" required><br>

        <label for="reservation_time">Reservation Time:</label>
        <input type="datetime-local" name="reservation_time" required><br>

        <button type="submit" name="reserve">Reserve</button>
    </form>

    <footer>
        <a href="logout.php">Logout</a>
    </footer>
</body>
</html>
