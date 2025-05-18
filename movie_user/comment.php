<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>電影評論</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .header {
            background-color: #6f42c1;
            height: 80px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
            padding-left: 20px;
            box-sizing: border-box;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comment {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .comment h3 {
            margin: 0;
            color: #6f42c1;
        }

        .comment p {
            margin: 5px 0;
        }

        .comment-time {
            font-size: 0.9em;
            color: #666;
        }

        .form-container {
            margin-top: 20px;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #6f42c1;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        .form-container button:hover {
            background-color: #5a34a1;
        }

        .back {
            position: fixed;
            top: 20px;
            right: 40px;
        }
    </style>
</head>

<body>
    <div class="header">電影評論
        <a class="back" href="./movies-information.php"><img width="50" height="50" src="../movie_back/image/home.png"
                alt="返回首頁"></a>
    </div>

    <div class="container">

        <?php
        session_start();
        $servername = "localhost";
        $username = "s1114580";
        $password = "1114580";
        $dbname = "final";

        try {
            // 建立PDO連接
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_GET["button2"]) || isset($_GET["button3"]) || isset($_GET["button5"])) {
                if (isset($_GET["button2"])) {
                    $movie = $_GET["MName"];
                } else if (isset($_GET["button3"])) {
                    $movie = $_GET["name"];
                } else {
                    $movie = $_GET["button5"];
                }
                // 查詢評論
                $sql = "SELECT member_ID, context, time FROM comment WHERE Movie_name = :movie
                        ORDER BY time DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['movie' => $movie]);

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results as $row) {
                    echo "<div class='comment'>";
                    $ID = $row["member_ID"];
                    $sql = "SELECT * FROM member WHERE ID = $ID";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $results2 = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<h3>評論人: " . $results2['Name'] . "</h3>";
                    echo "<p>" . htmlspecialchars($row['context']) . "</p>";
                    echo "<p class='comment-time'>評論時間: " . htmlspecialchars($row['time']) . "</p>";
                    echo "</div>";
                }

                die();
            }

            if (isset($_GET["button4"]) && isset($_SESSION["userid"])) {
                $name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '未知電影';

                echo '<dev class="form-container">
                <form action="./comment.php" method="get">
        當前時間：<span id="demo"></span>
        <script>
            var myVar = setInterval(myTimer, 1000);

            function myTimer() {
                var d = new Date();
                var t = d.toLocaleTimeString();
                document.getElementById("demo").innerHTML = t;
            }
        </script>

        <input type="hidden" name="MName" value="' . $name . '">

        <br><br>
        <textarea name="context" placeholder="評論內容" rows="4" required></textarea>
        <br><br>
        評論星級：
        <input type="number" name="rating" placeholder="評分 (1-5)" min="1" max="5" required>
        <br><br>
        <button type="submit" name="button1">提交評論</button>

        <br><br>
    </form> </div>';
            } else if (!isset($_SESSION["userid"])) {
                echo '<form id="autoSubmitForm" action="./login.html" method="get">';
                echo '<input type="hidden" name="button5" value="">';
                echo '</form>';

                echo '<script>';
                echo 'document.getElementById("autoSubmitForm").submit();';
                echo '</script>';
                echo 'exit()';
            }

            if (isset($_GET["MName"]) && isset($_GET["context"]) && isset($_GET["rating"])) {
                $name = $_GET["MName"];
                date_default_timezone_set("Asia/Taipei");
                $time = date("Y-m-d H:i:s");
                $context = $_GET["context"];
                $rating = $_GET["rating"];

                //評論人重複檢測
                $sql = "SELECT COUNT(*) FROM comment WHERE member_ID = :id AND Movie_name = :name";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $_SESSION['userid'], ':name' => $name]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row && $row['COUNT(*)'] > 0) {
                    echo'你已經評論過了';
                    echo '<script>setTimeout(function() {
                        window.location.href = "./movies-information.php"; 
                      }, 2000);
                      </script>';
                      exit();
                    }
                // 插入新評論
                $sql = "INSERT INTO comment (member_ID, Movie_name, time, context) VALUES (:userid, :name, :time, :context)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['userid' => $_SESSION["userid"], 'name' => $name, 'time' => $time, 'context' => $context]);

                echo "<p>新增評論成功</p>";

                // 計算某部電影的評論數量
                $sql = "SELECT COUNT(*) as count FROM comment WHERE Movie_name = :movieName";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['movieName' => $name]);

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $count = $result['count'];

                //echo "<p>電影 <strong>" . htmlspecialchars($name) . "</strong> 有 $count 條評論。</p>";
        
                // 評分處理
                $sql = "SELECT movie_rating FROM movie WHERE Name = :name";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['name' => $name]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $original_rate = $result["movie_rating"];

                if ($original_rate != NULL) {
                    $final_rate = ($original_rate * $count + $rating) / ($count + 1);
                } else {
                    $final_rate = $rating;
                }
                $sql = "UPDATE movie SET movie_rating = :final_rate WHERE Name = :name";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['final_rate' => $final_rate, 'name' => $name]);
                echo '<form id="autoSubmitForm" action="./comment.php" method="get">';
                echo '<input type="hidden" name="button5" value="' . $name . '">';
                echo '</form>';

                echo '<script>';
                echo 'document.getElementById("autoSubmitForm").submit();';
                echo '</script>';
            }

        } catch (PDOException $e) {
            echo "<p>連接失敗：" . htmlspecialchars($e->getMessage()) . "</p>";
        }

        ?>
        <!--
    <div class="form-container">
        <form action="" method="GET">
            <input type="text" name="MName" placeholder="電影名稱" required>
            <textarea name="context" placeholder="評論內容" rows="4" required></textarea>
            <input type="number" name="rating" placeholder="評分 (1-5)" min="1" max="5" required>
            <button type="submit">提交評論</button>
        </form>
    </div>-->

    </div>
</body>

</html>