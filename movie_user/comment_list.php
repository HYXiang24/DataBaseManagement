<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>評論測試</title>
    <link rel="stylesheet" href="comment.css">
</head>

<body>
    <?php
    $name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '未知電影';
    ?>
    <form action="./comment.php" method="get">
        當前時間：<span id="demo"></span>
        <script>
            var myVar = setInterval(myTimer, 1000);

            function myTimer() {
                var d = new Date();
                var t = d.toLocaleTimeString();
                document.getElementById("demo").innerHTML = t;
            }
        </script>

        <input type="hidden" name="MName" value="<?php echo htmlspecialchars($name); ?>">

        <br><br>
        在此評論->
        <textarea name="context" id=""></textarea>
        <br><br>
        評論星級：
        <select name="rating">
            <option value="1">1 星</option>
            <option value="2">2 星</option>
            <option value="3">3 星</option>
            <option value="4">4 星</option>
            <option value="5">5 星</option>
        </select>
        <br><br>
        <button type="submit" name="button1">送出</button>
        <button type="submit" name="button2">查看此電影的評論</button>

        <br><br>
    </form>

</body>

</html>