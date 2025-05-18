<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂單詳情</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            /* 背景 */
            background-color: #4b0082;
            height: 80px;
            width: 100%;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
            padding-left: 20px;
            box-sizing: border-box;
        }

        .container {
            padding: 20px;
        }

        .search-bar {
            width: 75%;
            margin: 20px auto;
            display: flex;
            justify-content: center;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        table {
            width: 75%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .back {
            position: fixed;
            top: 20px;
            right: 40px;
        }
    </style>
</head>

<body>
    <div class="header">訂單詳情</div>
    <?php
    if (!isset($_GET['member_id'])) {
        echo '<a class="back" href="main.html"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>';
    } else {
        echo '<a class="back" href="../movie_user/home.php"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>';
    }
    ?>
    <div class="container">

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "1114576";
        $dbname = "final";

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        if (!isset($_GET['member_id'])) {
            $id = $_GET["id"];
            $sql = "SELECT * FROM `order` WHERE order_id = '$id'";
            $stmt = $pdo->query($sql);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $member_id = $_GET["member_id"];
            $sql = "SELECT * FROM `order` WHERE member_ID = '$member_id'";
            $stmt = $pdo->query($sql);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        if (isset($_GET['member_id'])) {
            echo "<th>訂單編號</th>";
        }
        echo "<th>電影名稱</th>";
        echo "<th>票種</th>";
        echo "<th>日期</th>";
        echo "<th>時間</th>";
        echo "<th>影廳</th>";
        echo "<th>座位</th>";
        echo "<th>總金額</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($results as $row) {
            // 將座位資訊從 JSON 格式轉換為數組
            $seats = json_decode($row['seats'], true);

            // 格式化座位資訊
            $formattedSeats = array_map(function ($seat) {
                list($row, $number) = explode('-', $seat);
                return "{$row}排{$number}座";
            }, $seats);

            // 將格式化後的座位資訊轉換為字符串
            $formattedSeatsString = implode(' ', $formattedSeats);

            echo "<tr>";
            if (isset($_GET['member_id'])) {
                echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
            }
            echo "<td>" . htmlspecialchars($row['movie_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['order_ticket']) . "</td>";
            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['time']) . "</td>";
            echo "<td>" . htmlspecialchars($row['room_name']) . "</td>";
            echo "<td>" . htmlspecialchars($formattedSeatsString) . "</td>";
            echo "<td>" . htmlspecialchars($row['total_price']) . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        ?>
</body>

</html>