<?php
session_start();
// 連接到資料庫
$host = 'localhost';
$db   = 'final';
$user = 'root';
$pass = '1114576';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$name = $_SESSION['name'];

// 從資料庫獲取 showtimes
$stmt = $pdo->prepare("SELECT date, time FROM schedules WHERE name = :name ORDER BY date ASC");

// 綁定 :name 參數到 $name 變數
$stmt->bindParam(':name', $name);

// 執行查詢
$stmt->execute();
$showtimes = [];
while ($row = $stmt->fetch())
{
    $time = date('H:i', strtotime($row['time']));
    $showtimes[$row['date']][] = $time;
}

// 將資料轉換為 JSON 格式並輸出
header('Content-Type: application/json');
echo json_encode($showtimes);
?>