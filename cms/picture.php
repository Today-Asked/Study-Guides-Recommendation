<?php
require_once "auth.php";

require_once "../databaseLogin.php";
require "../connectDB.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_FILES['picture']['error'] === UPLOAD_ERR_OK){
        $id = $_POST["book"];
        $img = file_get_contents($_FILES['picture']['tmp_name']);
        $curl_post_array = array('image' => base64_encode($img));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $imgurClientId));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_array);
        $curl_result = curl_exec($curl);
        curl_close ($curl);
        $Received_JsonParse = json_decode($curl_result, true);

        if ($Received_JsonParse['success'] == true) {
            $ImgURL = $Received_JsonParse['data']['link'];
            echo "image URL: " . $ImgURL."<br>";
            
            $data = [$ImgURL, $id];
            $update = "UPDATE book SET picture=? WHERE id=?";
            $result = $connection->prepare($update);
            try {
                if($result->execute($data)){
                    echo "更新成功<br>";
                } else {
                    echo "更新失敗<br>";
                }
            } catch (PDOException $error) {
                echo "更新失敗<br>";
            }
        } else {
            echo "Imgur API 出錯<br/><br/>" . $Received_JsonParse['data']['error'];
        }
    } else {
        echo "上傳檔案時出錯<br>" . $_FILES['picture']['error'];
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="noindex">
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
            <label>科目：</label>
            <select class="form-select" id="subject" name="subject" onchange="window.location='<?php echo $_SERVER['PHP_SELF'];?>?subject='+this.value" >
                <option value="國文">國文</option>
                <option value="數學">數學</option>
                <option value="英文">英文</option>
                <option value="物理">物理</option>
                <option value="化學">化學</option>
                <option value="地科">地科</option>
                <option value="生物">生物</option>
                <option value="自然">自然</option>
                <option value="歷史">歷史</option>
                <option value="地理">地理</option>
                <option value="公民">公民</option>
                <option value="社會">社會</option>
                <option value="其他">其他</option>
            </select><br>

            <label>書名：</label>
            <select class="form-select" name="book">
            <option></option>
            <?php
            if(isset($_GET["subject"])){
                $get_subject = $_GET["subject"];
                echo "<script type='text/javascript'>document.getElementById('subject').value='" . $get_subject . "';</script>";
                $select = "SELECT * from book WHERE subject=:subject";
                $result = $connection->prepare($select);
                $result->bindValue(':subject', $get_subject);
                $result->execute();
                if($result->rowCount() > 0){
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value=".$row['id'].">".$row['name'].'&nbsp&nbsp'.$row['publisher']."</option>";
                    }
                } else {
                    echo "error";
                }
            }?></select><br>
            <input type="file" name="picture"><br>
            <input type="submit">
        </form>
    </body>
</html>