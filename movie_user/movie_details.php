<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>瞭解更多</title>
    <style>
        .container {
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .movie-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 800px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        .movie-card img {
            width: 300px;
            height: 450px;
            object-fit: cover;
            margin-right: 20px;
        }

        .movie-details {
            flex: 1;
        }

        .movie-details h2 {
            margin: 0 0 10px 0;
            font-size: 2em;
        }

        .movie-details p {
            margin: 10px 0;
            font-size: 1.2em;
        }

        .movie-details button {
            background-color: #6f42c1;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.2em;
            margin-top: 20px;
            margin-right: 10px;
        }

        .movie-details button:hover {
            background-color: #5a34a1;
        }

        .movie-details form {
            display: flex;
            gap: 10px;
        }

        .back {
            position: fixed;
            top: 20px;
            right: 40px;
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

        .movie-introduction {
            max-height: 100px;
            overflow: hidden;
            position: relative;
            transition: max-height 0.3s ease;
        }

        .show-more {
            color: #6f42c1;
            cursor: pointer;
            font-size: 1em;
            margin-top: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="header">電影資訊</div>
    <a class="back" href="./movies-information.php"><img width="50" height="50" src="../movie_back/image/home.png" alt="返回首頁"></a>
<div class="container">

<?php
$servername = "localhost";
$username = "root";
$password = "1114576";
$dbname = "final";

$name = $_GET["name"];

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM movie WHERE Name = :name";
$stmt = $pdo->prepare($sql);
$stmt->execute(['name' => $name]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo "<div class='movie-card'>";
    echo "<img src='../movie_back/" . htmlspecialchars($row['image']) . "' alt='電影海報'>";
    echo "<div class='movie-details'>";
    echo "<h2>" . htmlspecialchars($row['Name']) . "</h2>";
    if ($row["movie_rating"] != NULL) {
        echo "<p><strong>評價:</strong> " . number_format($row['movie_rating'], 1) . "</p>";
    } else {
        echo "<p><strong>評價:</strong> " . "尚無評分" . "</p>";
    }
    echo "<p><strong>分級:</strong> " . htmlspecialchars($row['rated']) . "</p>";
    echo "<p><strong>時長:</strong> " . htmlspecialchars($row['duration']) . "分鐘</p>";
    echo "<p><strong>上映日期:</strong> " . htmlspecialchars(date("Y-m-d", strtotime($row['release_date']))) . "</p>";
    echo "<div class='movie-introduction'>" . htmlspecialchars($row['introduction']) . "</div>";
    echo "<span class='show-more'>顯示更多</span>";
    echo "<form action='./comment.php' method='GET'>";
    echo "<input type='hidden' name='name' value='" . htmlspecialchars($row['Name']) . "'>";
    echo "<button type='submit' name='button3'>查看評論</button>";
    echo "<button type='submit' name='button4'>評論此電影</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<p>找不到電影資訊。</p>";
}
?>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var intro = document.querySelector('.movie-introduction');
        var showMoreBtn = document.querySelector('.show-more');

        if (intro.scrollHeight <= 100) {
            showMoreBtn.style.display = 'none';
        }

        showMoreBtn.addEventListener('click', function() {
            if (intro.style.maxHeight === '100px') {
                intro.style.maxHeight = intro.scrollHeight + 'px';
                this.textContent = '顯示更少';
            } else {
                intro.style.maxHeight = '100px';
                this.textContent = '顯示更多';
            }
        });
    });
</script>
</body>
</html>




