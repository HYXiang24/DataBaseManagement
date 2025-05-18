<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除票種</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .header {
            background-color: #6f42c1;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            width: 100%;
            box-sizing: border-box;
            position: relative;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin-top: 20px;
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
    <div class="header">
        刪除票種
        <a class="back" href="./main.html"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>
    </div>

    <?php
    $host = 'localhost';
    $db = 'final';
    $user = 's1114580';
    $pass = '1114580';

    // 建立連接
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    if (isset($_GET["Name"]) && !empty($_GET["Name"])) {
        $Name = $_GET["Name"];
        // 準備SQL語句
        $sql = "DELETE FROM ticket WHERE Name = :Name";
        $stmt = $pdo->prepare($sql);

        // 執行SQL語句
        if ($stmt->execute([':Name' => $Name])) {
            echo "<div class='form-container'><p>成功刪除 $Name</p></div>";
        } else {
            echo "<div class='form-container'><p>刪除失敗</p></div>";
        }
        //清除頁面緩存
        echo '<script>setTimeout(function() {
            window.location.href = "./ticket_rm.php"; 
          }, 2000);
          </script>';
    }
    ?>

    <div class="form-container">

        <form action="./ticket_rm.php" method="get">
            <label for="Name">刪除票種名稱：</label>
            <select name="Name" id="Name" required>
                <?php
                // 執行SQL查詢
                $sql = 'SELECT Name FROM ticket';
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                // 獲取查詢結果
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($results as $row): ?>
                    <option value="<?= $row['Name']; ?>"><?= $row['Name']; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">確認</button>
        </form>
    </div>
</body>

</html>
