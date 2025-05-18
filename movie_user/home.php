<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>主頁</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <?php
    session_start();
    ?>
    <header>
        <h1>詐騙影城</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#">主頁</a></li>
            <li><a href="#">關於我們</a></li>
            <li><a href="./movies-information.php">電影資訊</a></li>
            <li>
                <?php
                if (isset($_SESSION['userid'])) {
                    echo '<a href="logout.php">登出 (' . htmlspecialchars($_SESSION['username']) . ')</a></li>';
                    echo '<li><a href="../movie_back/detail_more.php?member_id='. $_SESSION['userid'] . '" name="'. htmlspecialchars($_SESSION['username']) .'">我的訂單</a>'; 

                } else {
                    echo '<a href="Login.html">登入</a>';
                }
                ?>
            </li>
        </ul>
    </nav>
    <div class="hot-sale">
        <p>現正熱映<p>
        <p><a href="movies-information.php">瀏覽所有電影></a></p>
    </div>
    <main>
        <div class="container">
            <img src="photo/movie_1.jpg" alt="movie" onclick="location.href='movie_details.php?name=劇場版+排球少年%21%21+垃圾場的決戰';">
            <img src="photo/movie_2.jpg" alt="movie" onclick="location.href='movie_details.php?name=幻幻之交';">
            <img src="photo/movie_3.jpg" alt="movie" onclick="location.href='movie_details.php?name=猩球崛起：王國誕生';">
            <img src="photo/movie_4.jpg" alt="movie" onclick="location.href='movie_details.php?name=芙莉歐莎：瘋狂麥斯傳奇篇章';">
            <img src="photo/movie_5.jpg" alt="movie" onclick="location.href='movie_details.php?name=特技玩家';">
        </div>
        <section>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 My Awesome Website 版權所有不得轉載</p>
    </footer>
</body>
</html>
