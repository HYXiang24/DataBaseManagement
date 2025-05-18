<?php
$servername = "localhost";
$username = "root";
$password = "1114576";
$dbname = "test";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$time = isset($_GET['time']) ? $_GET['time'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$sql = "SELECT `row`, `column` FROM seat_fuck WHERE status='booked' AND time=? AND date=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $time, $date); // 添加了 $date 參數
$stmt->execute();
$result = $stmt->get_result();

$bookedSeats = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $bookedSeats[] = $row["row"] . "-" . $row["column"];
    }
}

$stmt->close();
$conn->close();

echo json_encode(['bookedSeats' => $bookedSeats]);
?>