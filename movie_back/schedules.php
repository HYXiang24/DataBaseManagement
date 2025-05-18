<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>schedules</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            /* 增加內邊距 */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            /* 增加容器寬度 */
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            /* 增加標題底部間距 */
        }

        label {
            display: block;
            margin-bottom: 20px;
            /* 增加標籤底部間距 */
            color: #555;
        }

        input[type="text"],
        input[type="time"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            /* 增加內邊距 */
            margin-bottom: 20px;
            /* 增加底部間距 */
            border: 1px solid #ccc;
            border-radius: 4px;
            display: inline-block;
        }

        input[type="radio"] {
            margin-right: 10px;
            /* 增加右邊距 */
        }

        button {
            width: 100%;
            padding: 12px;
            /* 增加內邊距 */
            background-color: #800080;
            /* 紫色 */
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #5a005a;
            /* 深紫色 */
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            /* 增加底部間距 */
            color: green;
        }

        .back {
            position: fixed;
            top: 20px;
            right: 40px;
        }
    </style>
    <script>
        function validateDateFormat(input) {
            const datePattern = /^\d{2}-\d{2}$/;
            let errorMessage = input.parentNode.querySelector('.date-error'); // 使用类名选择错误信息

            if (!datePattern.test(input.value) && input.value !== "") { // 判断输入框是否为空
                if (!errorMessage) {
                    errorMessage = document.createElement('div');
                    errorMessage.classList.add('date-error');
                    errorMessage.textContent = '日期格式不正確，請使用MM-DD格式';
                    errorMessage.style.color = 'red';
                    input.parentNode.insertBefore(errorMessage, input.nextSibling);
                }
            } else {
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
        }

    </script>
</head>

<body>
    <div class="container">
        <a class="back" href="./main.html"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>
        <h1>新增場次</h1>
        <?php
        $host = 'localhost';
        $db = 'final';
        $user = 's1114580';
        $pass = '1114580';

        // 建立連接
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["theater"]) && isset($_GET["date"]) && isset($_GET["time"]) && isset($_GET["MName"])) {
            $theater = $_GET["theater"];
            $date = $_GET["date"];
            $time = $_GET["time"];
            $MName = $_GET["MName"];

            $sql = "SELECT room, date, time FROM schedules";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                if ($row["room"] == $theater && $row["date"] == $date && $row["time"] == $time . ':00') {
                    echo "<div class='message' style='color: red;'>新增場次衝突。</div>";
                    echo '<script>setTimeout(function() {
                        window.location.href = "./schedules.php"; 
                      }, 2000);
                      </script>';
                    exit;
                }
            }

            // 準備 SQL 語句
            $sql = "INSERT INTO schedules (room, date, time, name) VALUES (:theater, :date, :time, :movie_name)";
            $stmt = $pdo->prepare($sql);

            // 執行 SQL 語句
            if ($stmt->execute([':theater' => $theater, ':date' => $date, ':time' => $time, ':movie_name' => $MName])) {
                for ($i = 1; $i <= 8; $i++) {
                    for ($j = 1; $j <= 8; $j++) {
                        $sql = "INSERT INTO seat_fuck VALUES (:date, :time, :row, :column, :room, :status)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':date' => $date, ':time' => $time, ':row' => $i, ':column' => $j, ':room' => $theater, ':status' => 'available']);
                    }
                }
                echo "<div class='message'>新增場次成功！</div>";
            } else {
                echo "<div class='message' style='color: red;'>新增場次失敗。</div>";
            }
        }
        ?>
        <form action="./schedules.php" method="get">
            <label>
                影廳
                <input type="radio" name="theater" value="鑽石廳" required> 鑽石廳
                <input type="radio" name="theater" value="黃金廳" required> 黃金廳
            </label>
            <label>
                日期（格式：MM-DD
                <input type="text" name="date" required onblur="validateDateFormat(this)">
            </label>
            <label>
                時間
                <input type="time" name="time" required>
            </label>
            <label>
                電影選擇
                <select name="MName" id="MName" required>
                    <?php
                    // 執行 SQL 查詢
                    $sql = 'SELECT name FROM movie';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    // 獲取查詢結果
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $row): ?>
                        <option value="<?= htmlspecialchars($row['name']); ?>"><?= htmlspecialchars($row['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit">新增場次</button>
        </form>
    </div>
</body>

</html>