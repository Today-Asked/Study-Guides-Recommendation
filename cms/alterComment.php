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

$id = $choice = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST["id"];
    $choice = $_POST["choice"];

    if($choice == "deleteAComment"){
        $select = "SELECT * FROM questionnaire WHERE id='$id'";
        $result = $connection->query($select);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $bookId = $row['book'];
                $overall = $row['overall'];
                $content = $row['content'];
                $difficulty = $row['difficulty'];
                $answer = $row['answer'];
                $layout = $row['layout'];
                $review = $row["review"];
            }
            echo "data to delete: " . $bookId . " " . $overall . " " . $content . " " . $difficulty . " " . $answer . " " . $layout . "<br>";
            if($review == 1){
                $selectBook = "SELECT * FROM book WHERE id='$bookId'";
                $_result = $connection->query($selectBook);
                if($_result->num_rows > 0){
                    while($_row = $_result->fetch_assoc()){
                        $dataAmount = $_row['dataAmount'];
                        $_overall = $_row['overall'];
                        $_content = $_row['content'];
                        $_difficulty = $_row['difficulty'];
                        $_answer = $_row['answer'];
                        $_layout = $_row['layout'];
                    }
                    echo "<book> exist data: " . $dataAmount . " " . $_overall . " " . $_content . " " . $_difficulty . " " . $_answer . " " . $_layout . "<br>";

                    $newOverall = ($_overall * $dataAmount - $overall) / ($dataAmount - 1);
                    $newContent = ($_content * $dataAmount - $content) / ($dataAmount - 1);
                    $newDifficulty = ($_difficulty * $dataAmount - $difficulty) / ($dataAmount - 1);
                    $newAnswer = ($_answer * $dataAmount - $answer) / ($dataAmount - 1);     
                    $newLayout = ($_layout * $dataAmount - $layout) / ($dataAmount - 1);  
                    $newDataAmount = $dataAmount - 1;
                    echo "<book> new data: " . $newDataAmount . " " . $newOverall . " " . $newContent . " " . $newDifficulty . " " . $newAnswer . " " . $newLayout . "<br>";

                    $update = "UPDATE book SET dataAmount='$newDataAmount', overall='$newOverall', difficulty='$newDifficulty',
                        answer='$newAnswer', layout='$newLayout' WHERE id='$bookId'";
                    $delete = "DELETE FROM questionnaire WHERE id='$id'";
                    if($connection->query($update) === true){
                        echo "???????????? book ????????? ??????" . $bookId . "<br>";
                    } else {
                        echo "error1";
                    }
                    if($connection->query($delete) === true){
                        echo "??????????????????" . $id . "??????";
                    } else {
                        echo "error2";
                    }
                } else {
                    echo "???????????????????????????";
                }
            } else { // if not reviewed
                $delete = "DELETE FROM questionnaire WHERE id='$id'";
                if($connection->query($delete) === true){
                    echo "??????????????????" . $id . "??????";
                } else {
                    echo "error";
                }
            }
        } else {
            echo "??????????????????";
        }
    } else if($choice == "resetCommentOfABook"){
        $delete = "DELETE FROM questionnaire WHERE book='$id'";
        if($connection->query($delete) === true){
            echo "??????????????????????????? " . $id . " ???????????????<br>";
        } else {
            echo "error";
        }

        $update = "UPDATE book SET dataAmount=0, overall=0.000, content=0.000, difficulty=0.000, answer=0.000, layout=0.000 WHERE id='$id'";
        if($connection->query($update) === true){
            echo "????????????????????????" . $id;
        } else {
            echo "error2";
        }
    } else if($choice == "deleteAMsg"){
        $delete = "DELETE FROM msgBoard WHERE id='$id'";
        if($connection->query($delete) === true){
            echo "????????????????????? " . $id . " ?????????<br>";
        } else {
            echo "error";
        }
    }
}

?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
    <select name="choice">
        <option value="deleteAComment">???????????????(???????????????????????? id)</option>
        <option value="resetCommentOfABook">??????????????????????????????(???????????????????????? id)</option>
        <option value="deleteAMsg">??????????????????(???????????????????????? id)</option>
    </select><br>
    <input type="text" name="id"><br>
    <input type="submit">
</form>