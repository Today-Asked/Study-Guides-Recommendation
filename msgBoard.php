
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
        echo "
        <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js'></script>
        <script>
          emailjs.init('RhsmLYJSGkv4WFdO3');
            var tmp = {type: '留言'};
            emailjs.send('service_ecyjr9k', 'template_qfesiq6', tmp)
                    .then(function(response) {
                        console.log('SUCCESS!');
                    }, function(error) {
                        console.log('FAILED...', error);
                    });
        </script>";
        //echo "<script>alert('留言成功，經審核後就會出現在留言板上囉！');location.href = '/message_board.html';</script>";
        if($category == 0){
            echo "<script language='javascript'>navigator.clipboard.writeText('" . $redeemCode . "')
            .then(() => {
              console.log('Text copied to clipboard');
              location.href = 'message_board.html';
            })
            .catch(err => {
              // This can happen if the user denies clipboard permissions:
              console.error('Could not copy text: ', err);
            });";
            echo "alert('留言成功，經審核後就會出現在留言板上囉！\u000a您的兌換碼: " . $redeemCode . "\u000a（兌換碼已自動複製到您的剪貼簿，留言審核通過後可至合作網站書愛流動兌換愛心幣）');</script>";
        } else {
            echo "<script>alert('留言成功，留言經審核後就會出現在留言板上囉！');location.href = '/message_board.html';</script>";
        }
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
            echo "<div>" . nl2br($row["msg"]) . "</div>";
            echo "<small style='color:rgb(157, 157, 157); float:right'>" . substr($row["time"], 0, 10) . "</small><BR>";
            echo "</div>";
            $flag = 1;
        }
    } else {
        echo "尚無人留言";
    }
}
?>
<head>
    <meta name="robots" content="noindex">
</head>