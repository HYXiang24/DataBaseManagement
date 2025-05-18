<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除電影</title>
</head>
<body>
    <form action="./movie_rm.php" method="get">
        
        刪除電影名稱：<select name="MName">
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
        <button type="submit">確認</button>
    </form>
</body>
</html>