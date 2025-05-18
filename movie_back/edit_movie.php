<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改結果</title>
    <style>
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
        
    </style>
    <div class="header">修改結果</div>
</head>

<body>
<?php

$host = 'localhost';
$db = 'final';
$user = 's1114580';
$pass = '1114580';

// 建立連接
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

if (isset($_POST["MName"])) {
    $MName = $_POST["MName"];
    $fields = [];
    $params = [':MName' => $MName];

    if (isset($_POST["newName"]) && str_replace(' ', '', $_POST["newName"]) != NULL) {
        $fields[] = "Name = :newName";
        $params[':newName'] = $_POST["newName"];
    }

    if (isset($_POST["release_date"]) && str_replace(' ', '', $_POST["release_date"]) != NULL) {
        $fields[] = "release_date = :release_date";
        $params[':release_date'] = $_POST["release_date"];
    }

    if (isset($_POST["duration"]) && str_replace(' ', '', $_POST["duration"]) != NULL) {
        $fields[] = "duration = :duration";
        $params[':duration'] = $_POST["duration"];
    }

    if (isset($_POST["rated"]) && str_replace(' ', '', $_POST["rated"]) != NULL) {
        $fields[] = "rated = :rated";
        $params[':rated'] = $_POST["rated"];
    }

    if (isset($_POST["introduction"]) && str_replace(' ', '', $_POST["introduction"]) != NULL) {
        $fields[] = "introduction = :introduction";
        $params[':introduction'] = $_POST["introduction"];
    }

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES["image"]["name"];
        $target_dir = "image/";
        $target_file = $target_dir . basename($image);

        // 檢查並創建目標目錄
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // 移動上傳的文件到指定目錄
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $fields[] = "image = :image";
            $params[':image'] = $target_file;  // store the file path, not just the file name
            echo "圖片上傳成功<br>";
        } else {
            echo "圖片上傳失敗<br>";
        }
    }



    if (!empty($fields)) {
        $sql = "UPDATE movie SET " . implode(", ", $fields) . " WHERE Name = :MName";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($params)) {
            echo "<div class='container'><h1>電影信息修改成功</h1></div>";
            echo '<script>setTimeout(function() {
                window.location.href = "./edit_movie_list.php"; 
              }, 2000);
              </script>';
            
            exit;
        } else {
            echo "電影信息修改失敗";
        }
    } else {
        echo "沒有要修改的字段";
    }
}
?>
</body>
</html>

