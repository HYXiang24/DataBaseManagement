<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>資管影城</title>
    <link rel="stylesheet" href="ticket.css">
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION["userid"])) {
        echo '<form id="autoSubmitForm" action="./login.html" method="get">';
        echo '<input type="hidden" name="button5" value="">';
        echo '</form>';

        echo '<script>';
        echo 'document.getElementById("autoSubmitForm").submit();';
        echo '</script>';
        echo 'exit';
    }
    ?>
    <header>
        <h1>資管影城</h1>
    </header>
    
    <main>
        <div class="movie-container">
            <div class="movie-card">
            <!-- echo "<img src=../movie_back/" . $row['image'] . " alt='電影海報'>"; -->
                <!-- <img src="image/poster1.jpg" alt="電影海報1" class="movie-poster"> -->
                <!-- <div class="movie-info"> -->
                    <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "1114576";
                        $dbname = "final";

                        $name = $_GET["name"];

                        if (isset($_GET['name'])) {
                            // 將 name 參數儲存到 session 中
                            $_SESSION['name'] = $_GET['name'];
                        }

                        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $sql = "SELECT * FROM movie WHERE Name = :name";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['name' => $name]);

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            echo "<img src=../movie_back/" . $row['image'] . " alt='電影海報' class='movie-poster'>";
                            echo "<div class='movie-info'>";
                            echo "<h2 class='movie-title'>". htmlspecialchars($row['Name'])."</h2>";
                            echo "<p class='movie-description'>評價：". htmlspecialchars($row['movie_rating']) . "</p>";
                            echo "<p class='movie-description'>分級：". htmlspecialchars($row['rated']) . "</p>";
                            echo "<p class='movie-description'>時長：". htmlspecialchars($row['duration']) . " 分鐘</p>";
                            echo "<p class='movie-description'>上映日期：". htmlspecialchars(date("Y-m-d", strtotime($row['release_date']))) . "</p>";
                            echo "<p>選擇日期：</p>";
                        } else {
                            echo "<p>找不到電影資訊。</p>";
                        }

                        echo "<div class='date-selection'>";
                        echo "<button onclick=\"showTimes('06-21'); GetDate('06-21')\">6月21日 (五)</button>";
                        echo "<button onclick=\"showTimes('06-22'); GetDate('06-22')\">6月22日 (六)</button>";
                        echo "<button onclick=\"showTimes('06-23'); GetDate('06-23')\">6月23日 (日)</button>";
                        echo "<button onclick=\"showTimes('06-24'); GetDate('06-24')\">6月24日 (一)</button>";
                        echo "<button onclick=\"showTimes('06-25'); GetDate('06-25')\">6月25日 (二)</button>";
                        echo "<button onclick=\"showTimes('06-26'); GetDate('06-26')\">6月26日 (三)</button>";
                        echo "</div>";
                    ?>
                    <div class="showtimes">
                        <p>選擇時段：</p>
                        <div id="showtime-buttons-1" class="showtime-buttons">
                            <!-- 時段按鈕會根據選擇的日期變動 -->
                        </div>
                    </div>

                    <div class="table" id="table">
                        
                    </div>
                    
                    <button class="floating-button" id="floatingButton" onclick="window.location.href='choose.php'">可選取 0 個位置</button>
                </div>
            </div>
        </div>
    </main>
    <script src="ticket.js"></script>
</body>
</html>

<script>
function GetDate(date){
    localStorage.setItem("date", date);
}
</script>