<?php
// 開始 session
session_start();

// 資料庫連接參數
$servername = "localhost";
$username = "root";
$password = "1114576";
$dbname = "final";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 檢查表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 防止 SQL 注入
    $user = mysqli_real_escape_string($conn, $user);
    $pass = mysqli_real_escape_string($conn, $pass);

    // 驗證用戶
    $sql = "SELECT * FROM member WHERE e_mail='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 獲取用戶資料
        $row = $result->fetch_assoc();
        // 驗證密碼
        if ($pass === $row['Password']) {
            // 設置 session 變量
            $_SESSION['usermail'] = $row['e_mail'];
            $_SESSION['username'] = $row['Name'];
            $_SESSION['userid'] = $row['ID'];
            header("Location: home.php"); // 重定向到 home.php
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
}

// 關閉連接
$conn->close();
?>
