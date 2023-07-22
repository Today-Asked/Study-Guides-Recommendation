<?php
require_once "auth.php";

require_once "../databaseLogin.php";
require "../connectDB.php";

$id = $choice = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST["id"];
    $choice = $_POST["choice"];

    if($choice == "deleteAComment"){
        $select = "SELECT * FROM questionnaire WHERE id=:id";
        $result = $connection->prepare($select);
        $result->bindValue(':id', $id);
        $result->execute();
        if($result->rowCount() > 0){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $bookId = $row['book'];
            $overall = $row['overall'];
            $content = $row['content'];
            $difficulty = $row['difficulty'];
            $answer = $row['answer'];
            $layout = $row['layout'];
            $review = $row["review"];
            echo "deleted data: bookId = " . $bookId . "<br>overall = " . $overall . "<br>difficulty = " . $difficulty;
            echo "<br>content = " . $content . "<br>answer = " . $answer . "<br>layout = " . $layout . "<br>";
            if($review == 1){
                $selectBook = "SELECT * FROM book WHERE id=:bookId";
                $_result = $connection->prepare($selectBook);
                $_result->bindValue(':bookId', $bookId);
                $_result->execute();
                if($_result->rowCount() > 0){
                    $_row = $_result->fetch(PDO::FETCH_ASSOC);
                    $dataAmount = $_row['dataAmount'];
                    $_overall = $_row['overall'];
                    $_content = $_row['content'];
                    $_difficulty = $_row['difficulty'];
                    $_answer = $_row['answer'];
                    $_layout = $_row['layout'];
                    echo "<book> exist data: " . $dataAmount . " " . $_overall . " " . $_content . " " . $_difficulty . " " . $_answer . " " . $_layout . "<br>";
                    if($dataAmount != 1) {
                        $newOverall = ($_overall * $dataAmount - $overall) / ($dataAmount - 1);
                        $newContent = ($_content * $dataAmount - $content) / ($dataAmount - 1);
                        $newDifficulty = ($_difficulty * $dataAmount - $difficulty) / ($dataAmount - 1);
                        $newAnswer = ($_answer * $dataAmount - $answer) / ($dataAmount - 1);     
                        $newLayout = ($_layout * $dataAmount - $layout) / ($dataAmount - 1);  
                        $newDataAmount = $dataAmount - 1;
                    } else {
                        $newOverall = $newContent = $newDifficulty = $newAnswer = $newLayout = $newDataAmount = 0;
                    }
                    echo "<book> new data: " . $newDataAmount . " " . $newOverall . " " . $newContent . " " . $newDifficulty . " " . $newAnswer . " " . $newLayout . "<br>";

                    $data = [$newDataAmount, $newOverall, $newContent, $newDifficulty, $newAnswer, $newLayout];
                    $update = "UPDATE book SET dataAmount=?, overall=?, content=?,
                        difficulty=?, answer=?, layout=? WHERE id='$bookId'";
                    $updateResult = $connection->prepare($update);
                    try {
                        if($updateResult->execute($data)){
                            echo "成功更新 book 資料表 編號 " . $bookId . "<br>";
                        } else {
                            echo "更新資料表 book 失敗<br>";
                        }
                    } catch (PDOException $error) {
                        echo "更新資料表 book 失敗<br>error msg: " . $error . "<br>";
                    }
                    $delete = "DELETE FROM questionnaire WHERE id='$id'";
                    $deleteResult = $connection->prepare($delete);
                    try {
                        if($deleteResult->execute()){
                            echo "成功刪除編號 " . $id . " 評論<br>"; 
                        } else {
                            echo "刪除失敗<br>";
                        }
                    } catch (PDOException $error) {
                        echo "刪除失敗<br>error msg: " . $error . "<br>";
                    }
                } else {
                    echo "此評論之書籍不存在";
                }
            } else { // if not reviewed
                $delete = "DELETE FROM questionnaire WHERE id='$id'";
                $result = $connection->prepare($delete);
                try {
                    if($result->execute()){
                        echo "成功刪除編號 " . $id . " 的未審核評論<br>";
                    } else {
                        echo "刪除失敗<br>";
                    }
                } catch (PDOException $error) {
                    echo "刪除失敗<br>error msg: " . $error . "<br>";
                }
            }
        } else {
            echo "查無此筆資料";
        }
    } else if ($choice == "resetCommentOfABook") {
        $delete = "DELETE FROM questionnaire WHERE book='$id'";
        $result = $connection->prepare($delete);
        try {
            if($result->execute()){
                echo "成功刪除書籍編號為 " . $id . " 的所有評論<br>";
            } else {
                echo "刪除失敗<br>";
            }
        } catch (PDOException $error){
            echo "刪除失敗<br>error msg: " . $error . "<br>";
        }
        $update = "UPDATE book SET dataAmount=0, overall=0.000, content=0.000, difficulty=0.000, answer=0.000, layout=0.000 WHERE id='$id'";
        $updateResult = $connection->prepare($update);
        try {
            if ($updateResult->execute()) {
                echo "成功重置書籍編號" . $id . "<br>";
            } else {
                echo "重置書籍編號 " . $id . " 失敗<br>";
            }
        } catch (PDOException $error) {
            echo "重置書籍編號 " . $id . " 失敗<br>error msg: " . $error . "<br>";
        }
    } else if ($choice == "deleteAMsg") {
        $delete = "DELETE FROM msgBoard WHERE id='$id'";
        $result = $connection->prepare($delete);
        try {
            if($result->execute()) {
                echo "成功刪除編號為 " . $id . " 的留言<br>";
            } else {
                echo "刪除編號為 " . $id . " 的留言失敗<br>";
            }
        } catch (PDOException $error) {
            echo "刪除編號為 " . $id . " 的留言失敗<br>error msg: " . $error . "<br>";
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