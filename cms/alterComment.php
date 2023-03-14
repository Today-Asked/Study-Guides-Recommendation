<?php
require_once "auth.php";

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
                        echo "成功更新 book 資料表 編號" . $bookId . "<br>";
                    } else {
                        echo "error1";
                    }
                    if($connection->query($delete) === true){
                        echo "成功刪除編號" . $id . "評論";
                    } else {
                        echo "error2";
                    }
                } else {
                    echo "此評論之書籍不存在";
                }
            } else { // if not reviewed
                $delete = "DELETE FROM questionnaire WHERE id='$id'";
                if($connection->query($delete) === true){
                    echo "成功刪除編號" . $id . "評論";
                } else {
                    echo "error";
                }
            }
        } else {
            echo "查無此筆資料";
        }
    } else if($choice == "resetCommentOfABook"){
        $delete = "DELETE FROM questionnaire WHERE book='$id'";
        if($connection->query($delete) === true){
            echo "成功刪除書籍編號為 " . $id . " 的所有評論<br>";
        } else {
            echo "error";
        }

        $update = "UPDATE book SET dataAmount=0, overall=0.000, content=0.000, difficulty=0.000, answer=0.000, layout=0.000 WHERE id='$id'";
        if($connection->query($update) === true){
            echo "成功重置書籍編號" . $id;
        } else {
            echo "error2";
        }
    } else if($choice == "deleteAMsg"){
        $delete = "DELETE FROM msgBoard WHERE id='$id'";
        if($connection->query($delete) === true){
            echo "成功刪除編號為 " . $id . " 的留言<br>";
        } else {
            echo "error";
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="noindex">
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <select name="choice">
                <option value="deleteAComment">刪一則評論(請在下方輸入評論 id)</option>
                <option value="resetCommentOfABook">刪除一本書的所有評論(請在下方輸入書本 id)</option>
                <option value="deleteAMsg">刪除一則留言(請在下方輸入留言 id)</option>
            </select><br>
            <input type="text" name="id"><br>
            <input type="submit">
        </form>
    </body>
</html>