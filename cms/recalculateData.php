<?php
echo "<head><meta name='robots' content='noindex'></head>";
session_start();
if(!$_SESSION["login"]){
    echo "<script>alert('permission denied'); location.href='/loginCMS.php';</script>";
}
require_once "../databaseLogin.php";
$connection = new mysqli($hostname, $username, $password, $database);
if($connection->error) die("database connection error!");
//else echo "Success!";
$connection->set_charset("utf8");

$select = "SELECT * FROM book";
$result = $connection->query($select);
while($row = $result->fetch_assoc()){
    $id = $row['id'];
    $dataAmount = 0;
    $overall = 0;
    $content = 0;
    $difficulty = 0;
    $answer = 0;
    $layout = 0;

    $_select = "SELECT * FROM questionnaire WHERE book='$id' AND review=1";
    $_result = $connection->query($_select);
    while($_row = $_result->fetch_assoc()){
        $overall = ($overall * $dataAmount + $_row['overall']) / ($dataAmount + 1);
        $content = ($content * $dataAmount + $_row['content']) / ($dataAmount + 1);
        $difficulty = ($difficulty * $dataAmount + $_row['difficulty']) / ($dataAmount + 1);
        $answer = ($answer * $dataAmount + $_row['answer']) / ($dataAmount + 1);
        $layout = ($layout * $dataAmount + $_row['layout']) / ($dataAmount + 1);
        $dataAmount += 1;
    }
    $updateBook = "UPDATE book SET dataAmount='$dataAmount', overall='$overall', content='$content', 
        difficulty='$difficulty', answer='$answer', layout='$layout' WHERE id='$id'";
    if($connection->query($updateBook) === true){
        echo "update data successfully";
    } else {
        echo "fail to update data";
    }
}
?>