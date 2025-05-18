<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除電影</title>
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

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .form-container h1 {
            color: #6f42c1;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
            position: absolute;
            top: 20px;
            right: 40px;
        }
    </style>
</head>

<body>
<a class="back" href="./main.html"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>
    <?php
    $host = 'localhost';
    $db = 'final';
    $user = 's1114580';
    $pass = '1114580';

    // 建立連接
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    if (isset($_GET["MName"]) && !empty($_GET["MName"])) {
        $MName = $_GET["MName"];

        // 準備SQL語句
        $sql = "DELETE FROM movie WHERE name = :name";
        $stmt = $pdo->prepare($sql);

        // 執行SQL語句
        if ($stmt->execute([':name' => $MName])) {
            echo "<div class='form-container'><p>成功刪除 $MName</p></div>";
        } else {
            echo "<div class='form-container'><p>刪除失敗</p></div>";
        }
        //清除頁面緩存
        header("Location: " . $_SERVER['PHP_SELF']);
    }
    ?>
    <div class="form-container">
        <h1>刪除電影</h1>
        <form action="./movie_rm.php" method="get">
            <label for="MName">刪除電影名稱：</label>
            <select name="MName" id="MName" required>
                <?php
                // 執行SQL查詢
                $sql = 'SELECT name FROM movie';
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                // 獲取查詢結果
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results as $row): ?>
                    <option value="<?= $row['name']; ?>"><?= $row['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">確認</button>
        </form>
    </div>
</body>

</html>