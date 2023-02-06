<?php
echo "<head><meta name='robots' content='noindex'></head>";
session_start();
if(!$_SESSION["login"]){
    echo "<script>alert('permission denied'); location.href='/index.php';</script>";
}
//echo $_SESSION["login"];
?>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>
    function review(id, pass){
        if(pass == 1) url = "/cms/reviewMsg.php?review=1&id=" + id;
        else url = "/cms/reviewMsg.php?review=0&id=" + id;
        location.href = url;
    }
</script>
</head>
<body style='margin: 1%'></body>

<?php
require_once "../databaseLogin.php";
$connection = new mysqli($hostname, $username, $password, $database);
if($connection->error) die("database connection error!");
//else echo "Success!";
$connection->set_charset("utf8");

function createTable($review, $connection){
    if($review === 0) echo "<h2>未審核</h2><br>";
    else if($review === 1) echo "<h2>審核通過</h2><br>";
    else echo "<h2>審核未通過</h2>";

    $select = "SELECT * FROM msgBoard where review='$review'";
    $result = $connection->query($select);
    if($result -> num_rows == 0){
        echo "no data<br>";
        return;
    }
    echo "<table cellpadding=7 align=center border='1' class='table table-hover table-bordered'>\n<tr>\n";
    if($review === 0) echo "<th width='90px'>review&nbsp;</th>\n";
    echo "<th>id</th>\n<th>類別</th>\n<th>timestamp</th>\n<th>標題</th>\n<th>留言</th>\n</tr>";
    while($row = $result -> fetch_assoc()){
        if($row["category"] == 0) $type = "讀書技巧";
        else $type = "心情";
        if($review === 0){
            echo "<td><button class='btn btn-outline-secondary' type='button' onclick='review(" . $row['id'] . ", 1)'>通過</button><br><br>";
            echo "<button class='btn btn-outline-secondary' type='button' onclick='review(" . $row['id'] . ", 0)'>不通過</button></td>";
        }
        echo "<td>" . $row["id"] . "</td>\n";
        echo "<td>" . $type . "</td>\n";
        echo "<td>" . $row["time"] . "</td>\n";
        echo "<td>" . $row["title"] . "</td>\n";
        echo "<td>" . $row["msg"] . "</td>\n";     
        echo "</tr>";   
    }
    echo "</table>";
}

createTable(0, $connection);
createTable(1, $connection);
createTable(-1, $connection);

if(isset($_GET["id"])){
    $id = $_GET["id"];
    if($_GET["review"] == 1) $review = 1;
    else $review = -1;
    $update = "UPDATE msgBoard SET review='$review' WHERE id='$id'";
    $connection->query($update);
    if($review == 1){
        $select = "SELECT redeemCode FROM msgBoard WHERE id='$id'";
        $result = $connection->query($select);
        if($result->num_rows > 0){
            $row = $result -> fetch_assoc();
            if($row["category"] == 0){
                $redeemCode = $row["redeemCode"];
                $fields = [ 'redeemCode' => $redeemCode ];
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
            }
        } else {
            echo "error when finding redeemCode";
        }
    }
    echo "<script>location.href='/cms/reviewMsg.php'</script>";
}
?>