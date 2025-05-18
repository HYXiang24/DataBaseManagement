<?php


    $servername="localhost";
    $username = "s1114580";
    $password="1114580";
    $dbname="final";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $name = $_GET["name_input"];
    $ids = $_GET["id_select"];
    $idi = $_GET["id_input"];
    $phoneNumber = $_GET["phoneNumber_input"];
    $email = $_GET["eMail_input"];
    $psw = $_GET["psw_input"];
    $pswCheck = $_GET["pswcheck_input"];

    if ($psw != $pswCheck) {
        echo "認證密碼錯誤！";
        exit();
    }

    if($conn->connect_error) {
        die("連接失敗：". $conn -> connect_error);
    }
    
    $idAll = $ids . $idi;

    $sql="INSERT INTO member (Name, ID_member, e_mail, Password, Phone_number)
    VALUES ('$name', '$idAll', '$email', '$psw', '$phoneNumber')";
    
    if ($conn->query($sql)){
        echo "用戶註冊成功";
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
?>
