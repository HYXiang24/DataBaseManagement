<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改電影資訊</title>
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
            position: fixed;
            top: 20px;
            right: 40px;
        }
    </style>
</head>
<body>
 

<div class="header">修改電影</div>
<a class="back" href="./main.html"><img width="50" height="50" src="./image/home.png" alt="返回首頁"></a>
<div class="container">

<form action="./edit_movie.php" method="post" enctype="multipart/form-data">
<div>
選擇要修改電影：<select name="MName">
            <?php
            $host = 'localhost';
            $db = 'final';
            $user = 's1114580';
            $pass = '1114580';
            
            // 建立連接
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            
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
            <br>
            <label for="modify-name">修改電影名稱：</label>
            <input type="text" name="newName" id="newName">
            <br>
            <label for="release_date">修改電影上映日期：</label>
            <input type="datetime-local" name="release_date" id="release_date">
            <br>
            <label for="duration">修改電影片長：</label>
            <input type="number" name="duration" id="duration">
            <br>
            <label for="rated">修改電影分級：</label>
            <select name="rated" id="rated">
                <option value="" selected></option>
                <option value="限制級">限制級</option>
                <option value="輔導級">輔導級</option>
                <option value="保護級">保護級</option>
                <option value="普遍級">普遍級</option>
            </select>
            <br>
            <label for="introduction">修改電影簡介：</label>
            <textarea name="introduction" id="introduction"></textarea>
            <br>
            <label for="image">修改圖片：</label>
            <input type="file" name="image" id="image">
            <br>
            <button type="submit">確認修改</button>
</div>
</div>
</form>
<script>
