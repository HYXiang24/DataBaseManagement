<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "1114576";
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$time = isset($_GET['time']) ? $_GET['time'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$_SESSION['time'] = $time;
$_SESSION['date'] = $date;


$room = $_SESSION['room'];

$data = json_decode(file_get_contents('php://input'), true);
$selectedSeats = $data['selectedSeats'];

$errors = [];

foreach ($selectedSeats as $seat) {
    list($row, $column) = explode('-', $seat);
    $sql = "UPDATE seat_fuck SET status='booked' WHERE `row`='$row' AND `column`='$column' AND time=? AND date=? AND `room`=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $time, $date, $room); 
    $stmt->execute();
    $result = $stmt->get_result();
}

$conn->close();

if (empty($errors)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'errors' => $errors]);
}