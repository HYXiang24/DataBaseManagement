<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂位狀態</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #6a0dad; /* 紫色 */
        }

        .seat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .seat {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 15px;
            background-color: #d8bfd8; /* 淡紫色 */
            width: 200px;
            text-align: left;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .seat h3 {
            margin: 0 0 10px;
            font-size: 1.2em;
            color: #6a0dad; /* 紫色 */
            text-align: center;
        }

        .seat p {
            margin: 5px 0;
            color: #6a0dad; /* 紫色 */
        }

        .form-btn-red {
            background-color: #6a0dad; /* 紫色 */
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }

        .message {
            text-align: center;
            font-weight: bold;
            color: #6a0dad; /* 紫色 */
        }

        .back {
            position: fixed;
            top: 20px;
            right: 40px;
        }

        .header {
            background-color: #6f42c1;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">座位清單</div>
    <div class="container">
        <a class="back" href="./main.html"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>
        <?php
        $servername = "localhost";
        $username = "s1114580";
        $password = "1114580";
        $dbname = "final";

        // 建立PDO連接
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_POST["date"], $_POST["time"], $_POST["row"], $_POST["column"], $_POST["room"])) {
            $date = $_POST["date"];
            $time = $_POST["time"];
            $row = $_POST["row"];
            $column = $_POST["column"];
            $room = $_POST["room"];
            $sql = "UPDATE seat_fuck SET status = 'available' WHERE 
                    date = :date AND time = :time AND row = :row AND `column` = :column AND room = :room";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':date' => $date, ':time' => $time, ':row' => $row, ':column' => $column, ':room' => $room]);
            echo "<div class='message'>修改成功。</div>";
            echo '<script>setTimeout(function() {
                window.location.href = "./seat.php"; 
              }, 2000);
              </script>';
        }

        $sql = "SELECT * FROM seat_fuck WHERE status = :status ORDER BY date DESC, time DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':status' => 'booked']);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='seat-container'>";
        foreach ($results as $row) {
            echo "<div class='seat'>";
            echo "<h3>座位：" . $row['row'] . "-" . $row['column'] . "</h3>";
            $sql = "SELECT name FROM schedules WHERE 
                    room = :room AND date = :date AND time = :time";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':room' => $row['room'], ':date' => $row['date'], ':time' => $row['time']]);
            $results2 = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p>電影: " . $results2['name'] . "</p>";
            echo "<p>日期：" . htmlspecialchars($row['date']) . "</p>";
            echo "<p class='comment-time'>時間: " . htmlspecialchars($row['time']) . "</p>";
            echo "<p>影廳：" . $row['room'];
            echo "<form action='./seat.php' method='post'>
                    <input type='hidden' name='date' value='" . $row['date'] . "'>
                    <input type='hidden' name='time' value='" . $row['time'] . "'>
                    <input type='hidden' name='row' value='" . $row['row'] . "'>
                    <input type='hidden' name='column' value='" . $row['column'] . "'>
                    <input type='hidden' name='room' value='" . $row['room'] . "'>
                    <input type='submit' class='form-btn-red' value='標記為可選座位'></form>";
            echo "</div>";
        }
        echo "</div>";
        ?>
    </div>
</body>

</html>

