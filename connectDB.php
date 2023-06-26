<?php
require_once "databaseLogin.php";
//function connectDB(){
    try{
        $connection = new PDO("mysql:host=" . $hostname . ";port=3306;dbname=" . $database. ";charset=utf8mb4", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "connected successfully";
    } catch(PDOException $error) {
        throw new PDOException($error->getMessage());
    }
    /*$sql = "SELECT * FROM book WHERE id = :id";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', '37');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $result["name"];*/
    //return $connection;
//}
?>