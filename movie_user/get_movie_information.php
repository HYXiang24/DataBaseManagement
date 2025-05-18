<?php
$servername = "localhost";
$username = "root";
$password = "1114576";
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
$sql = "SELECT `Name`,`movie_rating`, release_date, `duration`,`rated`, `image` FROM movie";
$result = $conn->query($sql);

$movie = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $movie[] = [
            'Name' => $row["Name"],
            'movie_rating' => $row["movie_rating"],
            'release_date' => $row["release_date"],
            'duration' => $row["duration"],
            'rated' => $row["rated"],
            'image' => $row["image"]
        ];
    }
}

$conn->close();

echo json_encode(['movie' => $movie], JSON_UNESCAPED_UNICODE);
?>