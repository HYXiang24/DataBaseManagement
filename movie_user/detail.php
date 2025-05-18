<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂購完成</title>
    <link rel="stylesheet" href="detail.css">
</head>

<body>
    <header>
        <h1>訂購完成</h1>
        
    </header>
    <a class="back" href="./home.php"><img width="50" height="50" src="../movie_back/image/home.png" alt="返回首頁"></a>
    <main>
        <div id="cartContainer">
            <h2>訂單編號</h2>
                <?php
                    session_start();
                    $servername = "localhost";
                    $username = "root";
                    $password = "1114576";
                    $dbname = "final";

                    try {
                        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $sql = "SELECT * FROM `order` WHERE order_id = :order_id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':order_id', $_SESSION['order_ID'], PDO::PARAM_INT);
                        $stmt->execute();

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $seats = json_decode($row['seats'], true);

                        // 使用 array_map 來轉換座位格式
                        $formattedSeats = array_map(function($seat) {
                            list($row, $number) = explode('-', $seat);
                            return "{$row}排{$number}座";
                        }, $seats);

                        // 使用 implode 來將數組轉換為帶空格的字符串
                        $formattedSeatsString = implode(' ', $formattedSeats);
                        if ($row) {
                            echo "<p><strong>". htmlspecialchars($row['order_id']) . "</strong></p>";
                            echo "<h2>訂單內容</h2>";
                            echo "<p>電影名稱：".htmlspecialchars($row['movie_name']). "</p>";
                            echo "<p>票種：".htmlspecialchars($row['order_ticket']). "</p>";
                            echo "<p>播放時間：".htmlspecialchars($row['date'])." ".htmlspecialchars($row['time'])."</p>";
                            echo "<p>影聽：".htmlspecialchars($row['room_name']). "</p>";
                            echo "<p>座位：" . htmlspecialchars($formattedSeatsString) . "</p>";
                            echo "<p>--------------------------------------------------------------------------------------------------------</p>";
                            echo "<p>請於電影播放前30分鐘至櫃台取票</p>";
                            echo "<p id='totalPrice'>總金額: ". htmlspecialchars($row['total_price']). "</p>";
                        } else {
                            echo "<p>找不到訂單資訊。</p>";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                ?>
            
        </div>
    </main>
    <footer>
        <p>詐騙影城</p>
    </footer>

    <script src="detail.js"></script>
</body>

</html>