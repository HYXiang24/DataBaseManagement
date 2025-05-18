<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增電影</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #6f42c1;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 80px);
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        form input, form select, form textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #6f42c1;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        form button:hover {
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
<?php
    if (isset($_POST["MName"]) && !empty($_POST["MName"])) {
        $servername = "localhost";
        $username = "root";
        $password = "1114576";
        $dbname = "final";

        $conn = new mysqli($servername, $username, $password, $dbname);
        $name = $_POST["MName"];
        $release_date = $_POST["release_date"];
        $introduction = $_POST["introduction"];
        $duration = $_POST["duration"];
        $rated = $_POST["rated"];
        $image = $_FILES["image"]["name"];
        $target_dir = "image/";
        $target_file = $target_dir . basename($image);

        if ($conn->connect_error) {
            die("連接失敗：" . $conn->connect_error);
        }

        // 檢查並創建目標目錄
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // 移動上傳的文件到指定目錄
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO movie (Name, release_date, introduction, duration, rated, image)
            VALUES ('$name', '$release_date', '$introduction', '$duration', '$rated', '$target_file')";

            if ($conn->query($sql)) {
                echo "新記錄插入成功";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "上傳圖片失敗。";
        }

        $conn->close();
    }
    ?>
    <div class="header">新增電影
        <a class="back" href="./main.html"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>
    </div>
    <div class="container">
        <form action="./movies_add.php" method="post" enctype="multipart/form-data">
            <label for="MName">新增電影名稱：</label>
            <input type="text" name="MName" id="MName" required>
            <br>
            <label for="release_date">電影上映日期：</label>
            <input type="datetime-local" name="release_date" id="release_date" required>
            <br>
            <label for="duration">電影片長：</label>
            <input type="number" name="duration" id="duration" required>
            <br>
            <label for="rated">電影分級：</label>
            <select name="rated" id="rated" required>
                <option value="限制級">限制級</option>
                <option value="輔導級">輔導級</option>
                <option value="保護級">保護級</option>
                <option value="普遍級">普遍級</option>
            </select>
            <br>
            <label for="introduction">電影簡介：</label>
            <textarea name="introduction" id="introduction" required></textarea>
            <br>
            <label for="image">上傳圖片：</label>
            <input type="file" name="image" id="image" required>
            <br>
            <button type="submit">確認</button>
        </form>
    </div>
</body>
</html>

