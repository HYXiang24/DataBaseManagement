<?php




$servername="localhost";
$username = "s1114580";
$password="1114580";
$dbname="final";

$conn = new mysqli($servername, $username, $password, $dbname);
$MName = $_GET["MName"];
if($conn->connect_error) {
    die("連接失敗：". $conn -> connect_error);
}

$sql="DELETE FROM movie WHERE name='$MName'";

mysqli_query($conn,$sql);


echo "成功刪除$MName";

$conn->close();
?>