<?php
echo "<head><meta name='robots' content='noindex'></head>";
session_start();
if(!$_SESSION["login"]){
    echo "<script>alert('permission denied'); location.href='loginCMS.php';</script>";
}

require_once "../databaseLogin.php";
$connection = new mysqli($hostname, $username, $password, $database);
if($connection->error) die("database connection error!");
//else echo "Success!";
$connection->set_charset("utf8");

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $get_subject = $_GET["subject"];
    //echo $get_subject;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_FILES['picture']['error'] === UPLOAD_ERR_OK){
        $id = $_POST["book"];
        $clientId = 'bea210f369c761e';
        $img = file_get_contents($_FILES['picture']['tmp_name']);
        $curl_post_array = array('image' => base64_encode($img));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $clientId));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_array);
        $curl_result = curl_exec($curl);
        curl_close ($curl);
        $Received_JsonParse = json_decode($curl_result, true);

        if ($Received_JsonParse['success'] == true) {
            $ImgURL = $Received_JsonParse['data']['link'];
            echo $ImgURL."<br>";
            
            $update = "UPDATE book SET picture='$ImgURL' WHERE id='$id'";
            if($connection->query($update) === true){
                echo "update success";
            } else {
                echo $connection->error;
            }
        } else {
            echo "Error<br/><br/>".$Received_JsonParse['data']['error'];
        };


        /*echo $_FILES['picture']['name'] . "<br>" . $_FILES['picture']['type'];
        
        if(file_exists('upload/'.$_FILES['picture']['name'])){
            echo 'Already existed';
        } else {
            $file = $_FILES['picture']['tmp_name'];
            $size = getimagesize($file);
            $width = $size[0]; $height = $size[1];
            echo "<br>" . $_FILES['picture']['size']/1024 . "KB, " . $width . "x" . $width . "<br>";
            
            $tmp = explode('.', $_FILES['picture']['name']);
            $pic_name = round(microtime(true)) . '.' . end($tmp);
            $new_name = 'upload/' . $pic_name;
            $id = $_POST["book"];

            if($_FILES['picture']['size'] > 200*1024){ //200KB
                $r = sqrt($_FILES['picture']['size'] / 200 / 1024);
                $new_width = (int)($width / $r);
                $new_height = (int)($height / $r);
                
                $src = imagecreatefromstring(file_get_contents($file));
                $dst = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagedestroy($src);
                imagejpeg($dst, $new_name);

                echo "resized: " . filesize($new_name)/1024 . "KB, " . $new_width . "x" . $new_height . "<br>";
            }
        
            $update = "UPDATE book SET picture='$pic_name' WHERE id='$id'";
            if($connection->query($update) === true){
                echo "update success";
            } else {
                echo $connection->error;
            }
            
            
        }*/
    } else {
        echo $_FILES['picture']['error'];
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
    <label>?????????</label>
    <select class="form-select" name="subject" onchange="window.location='<?php echo $PHP_SELF;?>?subject='+this.value" >
        <option value="    " >    </option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
        <option value="??????" <?php if(isset($get_subject) && $get_subject ==="??????") echo "selected";?>>??????</option>
    </select><br>

    <label>?????????</label>
    <select class="form-select" name="book">
    <option></option>
    <?php
    if(isset($get_subject)){
        $select = "SELECT * from book WHERE subject='$get_subject'";
        $result = $connection->query($select);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value=".$row['id'].">".$row['name'].'&nbsp&nbsp'.$row['publisher']."</option>";
            }
        } else {
            echo "error";
        }
    }?></select><br>
    <input type="file" name="picture"><br>
    <input type="submit">
</form>