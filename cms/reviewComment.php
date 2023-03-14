<?php
require_once "auth.php";
//echo $_SESSION["login"];
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script>
            function review(id, pass){
                if(pass == 1) url = "/cms/reviewComment.php?review=1&id=" + id;
                else url = "/cms/reviewComment.php?review=0&id=" + id;
                location.href = url;
            }
        </script>
        <meta name="robots" content="noindex">
    </head>
    <body style='margin: 1%'></body>
<?php
require_once "../databaseLogin.php";
$connection = new mysqli($hostname, $username, $password, $database);
if($connection->error) die("database connection error!");
//else echo "Success!";
$connection->set_charset("utf8");

function createTable($review, $connection){
    $select = "SELECT * FROM questionnaire WHERE review=$review";
    $result = $connection->query($select);
    echo "<table cellpadding=7 align=center border='1' class='table table-hover table-bordered'>\n<tr>\n";
    if($review === 0){
        echo "<th width='90px'>review&nbsp;</th>\n";
    }
    echo "<th>id</th>\n<th>書名(bookId)</th>\n<th>timestamp</th>\n<th>overall</th>\n<th>content</th>\n<th>difficulty</th>\n<th>answer</th>\n<th>layout</th>\n<th>comment</th>\n</tr>";
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $_bookId = $row["book"];
            $_select = "SELECT * FROM book WHERE id='$_bookId'";
            $_result = $connection->query($_select);
            $bookName = "";
            if($_result->num_rows > 0){
                $_row = $_result->fetch_assoc();
                $bookName = $_row["name"];
            } else {
                //echo "didn't find book with this id\n";
            }
            echo "<tr>\n";
            if($review === 0){
                echo "<td><button class='btn btn-outline-secondary' type='button' onclick='review(" . $row['id'] . ", 1)'>通過</button><br><br>";
                echo "<button class='btn btn-outline-secondary' type='button' onclick='review(" . $row['id'] . ", 0)'>不通過</button></td>";
            }
            echo "<td>" . $row["id"] . "</td>\n";
            echo "<td>" . $bookName ."(" . $row["book"] . ")</td>\n";
            echo "<td>" . $row["date"] . "</td>\n";
            echo "<td>" . $row["overall"] . "</td>\n";
            echo "<td>" . $row["content"] . "</td>\n";
            echo "<td>" . $row["difficulty"] . "</td>\n";
            echo "<td>" . $row["answer"] . "</td>\n";  
            echo "<td>" . $row["layout"] . "</td>\n";
            echo "<td>" . $row["comment"] . "</td>\n";
            echo "</tr>";
        }
    } else {
        echo "no data";
    }
    echo "</table>";
}

echo "<h2>未審核</h2><br>";
createTable(0, $connection);
echo "<br><br><h2>審核通過</h2><br>";
createTable(1, $connection);
echo "<br><br><h2>審核不通過</h2><br>";
createTable(-1, $connection);

$id = $_GET["id"];
$pass = $_GET["review"];
if(isset($id)){
    if($pass == 1){
        $update = "UPDATE questionnaire SET review=1 WHERE id='$id'";

        // test redeemCode
        $select = "SELECT * FROM questionnaire WHERE id='$id'";
        $_result = $connection -> query($select);
        if($_result->num_rows > 0){
            $row = $_result->fetch_assoc();

            $redeemCode = $row["redeemCode"];
            $bookId = $row["book"];
            $overall = $row["overall"];
            $difficulty = $row["difficulty"];
            $content = $row["content"];
            $answer = $row["answer"];
            $layout = $row["layout"];

            $fields = [
                'redeemCode' => $redeemCode
            ];
            $postdata = http_build_query($fields);
            $ch = curl_init();
            // url
            curl_setopt($ch,CURLOPT_URL, 'https://booksriver.q23rf.repl.co/studyguides');
            //curl_setopt($ch,CURLOPT_URL, 'https://study-guides.dstw.dev/test.php');
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
            $result = curl_exec($ch);
            $error = curl_error($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            echo "<script>console.log('*" . $error . " " . $statusCode . "');</script>";
            curl_close($ch);
            
            $selectBook = "SELECT * FROM book WHERE id='$bookId'";
            $result = $connection->query($selectBook);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<script>var bookName = " . $row["name"] . ";</script>";
                    $dataAmount = $row['dataAmount'];
                    $_overall = $row['overall'];
                    $_content = $row['content'];
                    $_difficulty = $row['difficulty'];
                    $_answer = $row['answer'];
                    $_layout = $row['layout'];
                    echo "<script>window.console.log('dataAmount: " . $dataAmount . "')</script>";
                }
            } else {
                echo "<script>window.console.log('select data error')</script>"; 
            }

            $newOverall = ($dataAmount * $_overall + $overall) / ($dataAmount + 1);
            $newContent = ($dataAmount * $_content + $content) / ($dataAmount + 1);
            $newDifficulty = ($dataAmount * $_difficulty + $difficulty) / ($dataAmount + 1);
            $newAnswer = ($dataAmount * $_answer + $answer) / ($dataAmount + 1);
            $newLayout = ($dataAmount * $_layout + $layout) / ($dataAmount + 1);
            $newDataAmount = $dataAmount + 1;
            $updateBook = "UPDATE book SET dataAmount='$newDataAmount', overall='$newOverall', content='$newContent', 
                difficulty='$newDifficulty', answer='$newAnswer', layout='$newLayout' WHERE id='$bookId'";
            if($connection->query($updateBook) === true){
                echo "<script>window.console.log('update data successfully')</script>";
            } else {
                echo "<script>window.console.log('fail to update data')</script>";
            }
        }
    } else {
        $update = "UPDATE questionnaire SET review=-1 WHERE id='$id'";
    }
    $result = $connection->query($update);
    //echo "<script>console.log('success');</script>";
    echo "<script>location.href = '/cms/reviewComment.php';</script>";
}

?>
    </body>
</html>