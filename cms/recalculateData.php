<?php
require_once "auth.php";

require_once "../databaseLogin.php";
require "../connectDB.php";

$select = "SELECT * FROM book";
$result = $connection->prepare($select);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $id = $row['id'];
    $dataAmount = 0;
    $overall = 0;
    $content = 0;
    $difficulty = 0;
    $answer = 0;
    $layout = 0;

    $_select = "SELECT * FROM questionnaire WHERE book='$id' AND review=1";
    $_result = $connection->prepare($_select);
    $_result->execute();
    while($_row = $_result->fetch(PDO::FETCH_ASSOC)){
        $overall = ($overall * $dataAmount + $_row['overall']) / ($dataAmount + 1);
        $content = ($content * $dataAmount + $_row['content']) / ($dataAmount + 1);
        $difficulty = ($difficulty * $dataAmount + $_row['difficulty']) / ($dataAmount + 1);
        $answer = ($answer * $dataAmount + $_row['answer']) / ($dataAmount + 1);
        $layout = ($layout * $dataAmount + $_row['layout']) / ($dataAmount + 1);
        $dataAmount += 1;
    }
    $updateBook = "UPDATE book SET dataAmount='$dataAmount', overall='$overall', content='$content', 
        difficulty='$difficulty', answer='$answer', layout='$layout' WHERE id='$id'";
    $updateResult = $connection->prepare($updateBook);
    try {
        if($updateResult->execute()){
            echo "重新計算編號 " . $id . " 的書籍成功<br>";
        } else {
            echo "編號 " . $id . "的書籍更新失敗<br>";
        }

    } catch (PDOException $error) {
        echo "編號 " . $id . "的書籍更新失敗<br>error msg: " . $error . "<br>";
    }
}
?>