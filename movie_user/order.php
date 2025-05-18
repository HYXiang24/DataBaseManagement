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
$movie = $_SESSION['name'];
$member = $_SESSION['userid'];
$room = $_SESSION['room'];
$ticket = $_GET['buyItem'];
$totalprice = $_GET['totalprice'];


$data = json_decode(file_get_contents('php://input'), true);
$selectedSeats = isset($data['selectedSeats']) ? json_encode($data['selectedSeats']) : '';


$errors = [];

$sql = "INSERT INTO `order` (`member_ID`, `date`, `time`, `seats`, `order_ticket`, `room_name`, `total_price`, `movie_name`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssssss", $member, $date, $time, $selectedSeats, $ticket, $room, $totalprice, $movie);

// 執行
if ($stmt->execute()) {
    $orderID = $conn->insert_id;
    $_SESSION['order_ID'] = $orderID;
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

// 關閉連接
$stmt->close();
$conn->close();
?>

