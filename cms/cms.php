<?php
echo "<head><meta name='robots' content='noindex'></head>";
session_start();
if(!$_SESSION["login"]){
    echo "<script>alert('permission denied'); location.href='/loginCMS.php';</script>";
}
?>
<!DOCTYPE HTML5>
<head>
    <title>後台索引頁</title>
</head>
<body>
    <a href="./reviewComment.php">審核評論</a><br>
    <a href="./reviewMsg.php">審核留言</a><br>
    <a href='./alterComment.php'>刪除資料（評論 or 書籍）</a><br>
    <a href="./picture.php">更新封面圖片</a><br>
    <a href="./recalculateData.php">重新計算 book 資料表（按下此連結就會執行！）</a><br>
</body>