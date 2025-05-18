<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增票種</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
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
        }

        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }

        h1 {
            text-align: center;
            color: #6a0dad; /* 紫色 */
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #6a0dad; /* 紫色 */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #5a0bab;
        }

        .message {
            text-align: center;
            font-weight: bold;
            color: #6a0dad; /* 紫色 */
            margin-bottom: 20px;
        }

        .back {
            position: fixed;
            top: 20px;
            right: 40px;
        }
    </style>
</head>

<body>
    <div class="header">新增票種</div>
    <a class="back" href="./main.html"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>
    <div class="container">

        <?php
        if (isset($_GET['name']) && isset($_GET['description']) && isset($_GET['price'])) {
            $host = 'localhost';
            $db = 'final';
            $user = 's1114580';
            $pass = '1114580';

            // 建立連接
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

            $sql = "INSERT INTO ticket (name, description, price) VALUES (:name, :description, :price)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':name' => $_GET['name'], ':description' => $_GET['description'], ':price' => $_GET['price']]);
            echo '<div class="message">新增成功</div>';
            echo '<script>setTimeout(function() {
                window.location.href = "./ticket_add.php"; 
              }, 2000);
              </script>';
        }
        ?>
        <form action="./ticket_add.php" method="get">
            <label for="name">名稱：</label>
            <input type="text" name="name" id="name" required>

            <label for="description">詳細内容：</label>
            <input type="text" name="description" id="description" required>

            <label for="price">金額：</label>
            <input type="number" name="price" id="price" required>

            <button type="submit">新增</button>
        </form>
    </div>
</body>

</html>
