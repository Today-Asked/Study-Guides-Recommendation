<?php

require_once "databaseLogin.php";

$connection = new mysqli($hostname, $username, $password, $database);

if($connection->error) die("database connection error!");

//else echo "Success!";

$connection->set_charset("utf8");



$bookId = $_GET['id'];

$bookDetail = "SELECT * FROM book WHERE id='$bookId'";

$result = $connection->query($bookDetail);

if($result->num_rows > 0) {

  while($row = $result->fetch_assoc()){

    $subject = $row['subject'];

    $name = $row['name'];

    $exam = $row['exam'];

    $publisher = $row['publisher']; 

    $picture = $row['picture'];

    $category = $row['category'];

    $dataAmount = $row['dataAmount'];

    $overall = $row['overall'];

    $content = $row['content'];

    $difficulty = $row['difficulty'];

    $answer = $row['answer'];

    $layout = $row['layout'];

  }

} else {

  echo "<script>alert('查無此書');location.href='/query.php'</script>";

}

function _date($str){
  $result = "";
  $result = $str[0] . $str[1] . $str[2] . $str[3] . " 年 " . $str[4] . $str[5] . " 月 " . $str[6] . $str[7] . " 日 ";
  return $result;
  
}

?>



<!DOCTYPE html>

<html lang="en">



<head>

      <!-- Global site tag (gtag.js) - Google Analytics -->

      <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZXCEF0Q5KK"></script>

    <script>

        window.dataLayer = window.dataLayer || [];

        function gtag(){dataLayer.push(arguments);}

        gtag('js', new Date());



        gtag('config', 'G-ZXCEF0Q5KK');

    </script>

  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"

    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"

    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">

  </script>

  <link rel="icon" type="image/x-icon" href="icon.ico">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo $name;?></title>

  <link rel="stylesheet" type="text/css" href="detail.css">

  <script>

    window.onload=function(){

      if(window.screen.width >= 600){

        container = document.getElementById("container");

        nrHeight = document.getElementById("name_rating").clientHeight.toString();

        container.setAttribute("style","height: " + nrHeight + "px");

        //alert("EY!")

      }

    }

  </script>
  <script>
        function fixing()
        {
            alert("新功能，施工中");
        }
    </script>

</head>



<body>

  <div id="header">

    <nav class="navbar navbar-light fixed-top" style="background-color: #94c0af" ;>

      <div class="container-fluid">

        <a class="navbar-brand" href="index.php"><img src="https://i.imgur.com/vkflx0C.png"

            style="object-fit: cover; height: 55px;"></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"

          aria-controls="offcanvasNavbar">

          <span class="navbar-toggler-icon"></span>

        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

          <div class="offcanvas-header">

            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">早安</h5>

            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

          </div>

          <div class="offcanvas-body">

            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

              <li class="nav-item">

                <a class="nav-link" aria-current="page" href="index.php">回首頁</a>

              </li>

              <li class="nav-item">

                <a class="nav-link" href="query.php">瀏覽清單</a>

              </li>

              <li class="nav-item">

                <a class="nav-link" href="newBook.php">新增參考書</a>

              </li>

              <li class="nav-item">

                <a class="nav-link" href="questionnaire.php">撰寫回饋</a>

              </li>

              <li class="nav-item">

                <a class="nav-link" href="#" onclick="javascript:fixing()">留言板</a>

              </li>

              <li>

                <a class="nav-link" href="https://forms.gle/H1e8fs6Pp2gPj3xZ9" target="_blank">

                  <span style="color: rgb(150, 79, 144)">填寫意見回饋表單 <i class="bi bi-pencil-square"></i></span>

                </a>

              </li>

            </ul>

          </div>

        </div>

      </div>

    </nav>

  </div>

  <div class="head">hi</div>

  <div class="wrapping" style="margin-bottom: -5px; min-height: 100%;">

    <div class="content">

      <div class="detail"> 

          <div class="container" id="container">

            <img id = "image" class="image" src=<?php echo $picture;?> alt="<?php echo $name;?>"> <!--這裡放圖片-->

          </div>

          <div class="name_rating" id="name_rating" style="display: inline-block;">

            <h2><?php echo $name?></h2>

            <p style="color: #2a906b"><?php echo $exam . ' / ' .  $subject . ' / ' . $category;?></p>

            <p class="rating">綜合給分 &#11088 <?php echo round($overall, 1);?> </p>

            <p class="rating">內容豐富程度 &#11088 <?php echo round($content, 1);?></p>

            <p class="rating">難易度 &#11088 <?php echo round($difficulty, 1);?></p>

            <p class="rating">詳解詳細程度 &#11088 <?php echo round($answer, 1);?></p>

            <p class="rating">排版/美編/顏色 &#11088 <?php echo round($layout, 1);?></p>

            <p style="color:rgb(124, 124, 124)">（評分人數：<?php echo $dataAmount;?>）</p>

          </div>

      </div>

      <br>

      <div>

        <h3 style="margin: 5px;">其他評價</h3>

        <?php

        $select = "SELECT date, comment FROM questionnaire WHERE book='$bookId' AND review=1 ORDER BY id DESC";

        $_result = $connection->query($select);

        //echo "<script language='javascript'>window.console.log('" . $connection->error . "');</script>";

        if($_result->num_rows > 0){

          while($_row = $_result->fetch_assoc()){

            if(!empty($_row['comment'])){

              echo "<div class='comment'>\n";
              
              echo "<small style='color:rgb(142, 138, 138);'>" . _date($_row['date']) . "</small><br>";

              echo "<span>" . nl2br($_row['comment']) . "</span>\n</div>";

            }

          }

        } else {

          echo "<span>尚無人評論</span>";

        }

        ?>

      </div>
      <div>
        <center>
          <button class="btn btn-outline-success" style="margin: 2%;" onclick="location.href='/questionnaire.php?subject=<?php echo $subject?>&book=<?php echo $bookId?>'">去評論</button>
          <button class="btn btn-outline-success" style="margin: 2%;" onclick="">找二手</button>
        </center>
      </div>

    </div>

  </div>
  
  <footer style="margin: 0px; padding: 20px; background-color: rgb(217, 217, 217); text-align: center;  position: sticky;">

      Copyright © 2022 玉米糖粉. All rights reserved.<br>

      111 級雄女資研出品<br>

      Contact us: 

      <a href="mailto:study.guides.recommend@gmail.com" target="_blank"><small>study.guides.recommend@gmail.com</small></a>

    </footer>
    <a href="#" style="position: fixed; bottom: 1%; right: 1%;"><img src="top.png" style="height: 2.5em;"></a>
