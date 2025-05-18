<?php
    // 建立連線
    $db_link = mysqli_connect('localhost', 'root', '1114576', 'final') or die(mysqli_error());

    // Query Database
    $result = mysqli_query($db_link, "SELECT * FROM member");
    
    // 將 query 結果取出
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "id: {$row['ID']}, <br/>ID_member: {$row['ID_member']}, <br/>Name: {$row['Name']},  <br/>
            Account: {$row['Account']}, <br/>Password: {$row['Password']},  <br/>Phone_number: {$row['Phone_number']}<br/>";
        }
    } else {
        echo "0 row";
    }
    
    // 斷開連線
    mysqli_close($db_link);
?>