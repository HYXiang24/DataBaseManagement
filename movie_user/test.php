<?php
            $host = 'localhost';
            $db = 'final';
            $user = 's1114580';
            $pass = '1114580';

            // 建立連接
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

            // 執行SQL查詢
            $sql = 'SELECT name FROM movie';
            echo $sql;
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            // 獲取查詢結果
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($results);

            foreach ($results as $row): ?>
              <option value="<?= $row['name']; ?>"><?= $row['name']; ?></option>
<?php endforeach; ?>