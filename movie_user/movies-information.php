<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>電影資訊</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #6f42c1;
            height: 80px;
            width: 100%;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
            padding-left: 20px;
            box-sizing: border-box;
        }

        .container {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .movie-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .movie-card h2 {
            margin: 0 0 10px 0;
            font-size: 1.2em;
        }

        .movie-card p {
            margin: 5px 0;
        }

        .movie-card button {
            background-color: #6f42c1;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        .movie-card button:hover {
            background-color: #5a34a1;
        }

        .back {
            position: fixed;
            top: 20px;
            right: 40px;
        }

        .movie-card img {
            width: 100%;
            height: auto;
            max-width: 250px;
            /* Limit the maximum width */
            max-height: 375px;
            /* Limit the maximum height */
            object-fit: cover;
            /* Ensure the image covers the area */
            margin-bottom: 10px;
            /* Add some space below the image */
        }

        .movie-card a {
            text-decoration: none;
            color: inherit;
        }

        .movie-card img:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="header">電影資訊</div>
    <a class="back" href="home.php"><img width="50" height="50" src="../movie_back/image/home.png" alt="返回首頁"></a>
    <div class="container">

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "1114576";
        $dbname = "final";

        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $sql = "SELECT * FROM movie ORDER BY release_date DESC";
        $stmt = $pdo->query($sql);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo "<div class='movie-card'>";
            echo "<h2>" . $row['Name'] . "</h2>";
            echo "<a href='movie_details.php?name=" . urlencode($row['Name']) . "'>";
            echo "<img src=../movie_back/" . $row['image'] . " alt='電影海報'>";
            echo "</a>";
            if ($row["movie_rating"] != NULL) {
                echo "<p><strong>評價:</strong> " . number_format($row['movie_rating'], 1) . "</p>";
            } else {
                echo "<p><strong>評價:</strong> " . "尚無評分" . "</p>";
            }
            //echo "<p><strong>評價:</strong> " . $row['movie_rating'] . "</p>";
            echo "<p><strong>分級:</strong> " . $row['rated'] . "</p>";
            echo "<p><strong>時長:</strong> " . $row['duration'] . "分鐘" . "</p>";
            echo "<p><strong>上映日期:</strong> " . date("Y-m-d", strtotime($row['release_date'])) . "</p>";
            //echo "<p><strong>簡介:</strong> " . $row['introduction'] . "</p>";
            echo "<form action='./test1.php' method='GET'>";
            echo "<input type='hidden' name='name' value='" . $row['Name'] . "'>";
            echo "<button type='submit'>立即訂票</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>
</body>

</html>