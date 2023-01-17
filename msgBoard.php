
<?php
require_once "databaseLogin.php";
$connection = new mysqli($hostname, $username, $password, $database);
if($connection->error) die("database connection error!".$connection->connnect_error);
//else echo "Success!";
$connection->set_charset("utf8");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST") { // insert data
    $title = test_input($_POST["title"]);
    $msg = test_input($_POST["comment"]);
    $theme = test_input($_POST["theme"]);
    $acceptedChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890@#%^&*+=-_";
    $redeemCode = substr(str_shuffle($acceptedChar), 0, 7);
    if($theme == "studyPlan"){
        $category = 0;
    } else {
        $category = 1;
    }
    $insert = "INSERT INTO msgBoard (category, title, msg, redeemCode) VALUES ('$category', '$title', '$msg', '$redeemCode')";
    if($connection->query($insert) === true){
        echo "<script>alert('留言成功，經審核後就會出現在留言板上囉！');location.href = '/message_board.html';</script>";
        //echo "<script>alert('留言成功，經審核後就會出現在留言板上囉！\u000a您的兌換碼: '" . $redeemCode . "（審核通過後可至合作網站書愛流動兌換愛心幣）');location.href = '/message_board.html';</script>";
    } else {
        echo "<script>alert('留言失敗，請再試一次');location.href = '/message_board.html';</script>";
    }
} else if($_SERVER["REQUEST_METHOD"] == "GET") { // study or emo 
    $category = $_GET["type"];
    if($category == 0) $type = "studyPlan";
    else $type = "emotion";
    echo "<script>console.log('" . $category . "');</script>";
    $select = "SELECT * FROM msgBoard WHERE category='$category' AND review=1";
    $result = $connection->query($select);
    if($result->num_rows > 0){
        $flag = 0;
        while($row = $result -> fetch_assoc()){
            if($flag == 1){
                echo "<hr style='margin-left: 1%; margin-right: 1%;'>";
            }
            echo "<div style='margin:1%'>";
            echo "<strong>" . $row["title"] . "</strong><br>";
            echo "<div>" . $row["msg"] . "</div>";
            echo "<small style='color:rgb(157, 157, 157); float:right'>" . substr($row["time"], 0, 10) . "</small><BR>";
            echo "</div>";
            $flag = 1;
        }
    } else {
        echo "尚無人留言";
    }
}
?>