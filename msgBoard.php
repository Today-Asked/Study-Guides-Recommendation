<?php
echo "<head><meta name='robots' content='noindex'></head>";
require_once "databaseLogin.php";
require "connectDB.php";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "GET") { // study or emo 
    $category = $_GET["type"];
    if($category == 0) $type = "studyPlan";
    else $type = "emotion";
    echo "<script>console.log('" . $category . "');</script>";
    $select = "SELECT * FROM msgBoard WHERE category=:category AND review=1";
    $result = $connection->prepare($select);
    $result->bindValue(':category', $category);
    $result->execute();
    if($result->rowCount() > 0){
        $flag = 0;
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
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