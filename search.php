<?php
echo "<head><meta name='robots' content='noindex'></head>";
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

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $s = test_input($_GET["search"]);
    $split = preg_split('//u', $s);
    foreach ($split as $i){
        $search[] = "%%" . $i . "%%";
    }
    //print_r($search);
    //echo "<br>";
    for($i = 1; $i < 200; $i = $i + 1){
        $cnt[$i] = 0;
    }
    for($i = 1; $search[$i] != "%%%%"; $i = $i + 1){
        $select = "SELECT id, name FROM book WHERE name LIKE '$search[$i]'";
        //echo $select . "<br>";
        $result = $connection->query($select);
        if($result -> num_rows > 0){
            //echo $search[$i] . ":<br>";
            while($row = $result -> fetch_assoc()){
                $cnt[$row["id"]] = $cnt[$row["id"]] + 1;
                //echo "    " . $row["id"] . " " . $row["name"] . "<br>";
            }
        } else {
            //echo $search[$i] . ": no data selected<br>";
        }
    }
    $threshold = mb_strlen($s, 'utf-8') / 2;
    echo "<script>alert('以下為資料庫內相似的書籍，請檢查是否有您要找的書籍\u000a";
    $flag = 0;
    for($i = 1; $i < 200; $i = $i + 1){
        if($cnt[$i] > $threshold){
            $flag = 1;
            $select = "SELECT name, subject, publisher FROM book WHERE id='$i'";
            $result = $connection->query($select);
            if($result->num_rows > 0){
                $row = $result -> fetch_assoc();
                echo $row["publisher"] . "    " . $row["subject"] . "    " . $row["name"] . "\u000a";
            }
        }
    }
    if($flag == 0){
        echo "\u000a沒有相似的書籍！";
    }
    echo "');</script>";
}
?>