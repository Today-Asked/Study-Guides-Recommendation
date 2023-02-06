<?php

require_once "databaseLogin.php";

$connection = new mysqli($hostname, $username, $password, $database);

if($connection->error) die("database connection error!");

//else echo "Success!";

$connection->set_charset("utf8");



function test_input($data) {

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    return $data;

}



$subject = $search = $category = $exam = '%%';



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
<link rel="shortcut icon" type="image/x-icon" href="icon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="query.css">

    <script language='javascript'>

        function detail(id) {

            window.open('/detail.php?id='+id, '_blank');

        }

    </script>

    <title>瀏覽清單</title>
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

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"

                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"

                    aria-labelledby="offcanvasNavbarLabel">

                    <div class="offcanvas-header">

                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">早安</h5>

                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"

                            aria-label="Close"></button>

                    </div>

                    <div class="offcanvas-body">

                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                            <li class="nav-item">

                                <a class="nav-link" aria-current="page" href="index.php">回首頁</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="about.html">About us</a>
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

                                <a class="nav-link" href="message_board.php">留言板</a>

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

    <!--放著占位子-->



    <!-- 查詢 -->

    

        <div class="wrapping" style="margin-bottom: -15px; min-height: 100%;">

            <center>

        <div class="content">

                <h1 style="text-align: center">查詢推薦清單</h1>

                <p>歡迎光臨，請問今天想找點什麼樣的書呢？</p>

                <div>

                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post"

                        class="form-inline">

                        <div class="subject column col-xs-6 col-sm-3" style="display: inline-block;">

                            <label>依科目搜尋</label>

                            <select class="form-select" name="subject">

                                <option></option>

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

                            </select>

                        </div>



                        <div class="exam column col-xs-6 col-sm-3" style="display: inline-block;">

                            <label>依適用考試搜尋</label>

                            <select class="form-select" name="exam">

                                <option></option>

                                <option value="學測">學測</option>

                                <option value="分科測驗">分科測驗</option>

                                <option value="全民英檢">全民英檢</option>

                                <option value="多益">多益</option>

                                <option value="段考">段考</option>

                                <option value="其他">其他</option>

                            </select></div>



                        <div class="category column col-xs-12 col-sm-3" style="display: inline-block;">

                            <label>依類別搜尋</label>

                            <select class="form-select" name="category">

                                <option></option>

                                <option value="工具書">工具書</option>

                                <option value="閱讀測驗/克漏字">閱讀測驗/克漏字</option>

                                <option value="寫作">寫作</option>

                                <option value="翻譯">翻譯</option>

                                <option value="地毯式複習講義">地毯式複習講義</option>

                                <option value="周計畫">周計畫</option>

                                <option value="題庫">題庫</option>

                                <option value="模擬題本">模擬題本</option>

                                <option value="歷屆試題">歷屆模考題</option>

                                <option value="歷屆試題">歷屆試題</option>

                                <option value="其他">其他</option>

                            </select>

                        </div>

                        <div class="bookName column col-xs-12 col-sm-3" style="display: inline-block;">

                            <label>依書名搜尋</label>

                            <input type='text' name='bookName' class='form-control'>

                        </div>

                        <br>



                        <button type='submit' class="btn btn-outline-success" style="margin: 2%">

                                搜尋 <i class="bi bi-search"></i>

                        </button>



                    </form>

                </div>



            </div>

                



            <!-- 顯示 -->



            <div class="content">

            <?php

                if($_SERVER['REQUEST_METHOD'] == "POST"){

                    if(empty($_POST['subject']) && empty($_POST['bookName']) && empty($_POST['category']) && empty($_POST['exam'])){

                        echo "<script language='javascript'>alert('搜尋條件不能全部空白');location.href='/query.php';</script>";

                    }

                    if(!empty($_POST['subject'])) $subject = $subject . test_input($_POST['subject']);

                    if(!empty($_POST['category'])) $category = $category . test_input($_POST['category']);

                    if(!empty($_POST['exam'])) $exam = $exam . test_input($_POST['exam']);

                    if(!empty($_POST['bookName'])){

                        $bookName = test_input($_POST['bookName']);

                        $split = preg_split('//u', $bookName);

                        $search = '';

                        foreach ($split as $i){

                            $search = $search . $i . "%%";

                        }

                        //$search : mysql 搜尋用

                    } else {

                        //echo "<script language='javascript'>window.console.log('bookName is empty.');</script>";

                    }

                    //echo "<script language='javascript'>window.console.log('" . $subject . " / " . $search . " / " . $category . " / " . $exam . "');</script>";

                    

                    $select = "SELECT * FROM book WHERE subject LIKE '$subject' AND name LIKE '$search' AND 

                        category LIKE '$category' AND exam LIKE '$exam' ORDER BY overall DESC, dataAmount DESC";

                    //echo "<script language='javascript'>window.console.log('" . $select . "');</script>";



                    $result = $connection->query($select);

                    echo "<h1 style='text-align: center;'>搜尋結果</h1>";

                    if($result->num_rows > 0){
                        echo "<p>點按書籍封面看更多詳細資料</p>";

                        while($row = $result->fetch_assoc()){

                            echo "<div class='card mb-0' type='button' onclick='detail(" . $row['id'] . ")' target='_blank' style='max-width: 500px; display: inline-block; margin: 1%' height: 100%;>\n";

                            echo "<div class='row g-0'>\n";

                            echo "<div class='col-md-4 sm-6'>\n";

                            echo "<img src=" . $row['picture'] . " class='img-fluid rounded-start' alt=" . $row['name'] . ">\n</div>\n";



                            echo "<div class='col-md-7 sm-6'>\n<div class='card-body'>\n";

                            echo "<h5 class='card-title'>" . $row['name'] . "</h5>\n";

                            echo "<p class='card-text' style='color: gray'>" . $row['subject'] . ' / ' . $row['exam'] . ' / ' . $row['category'] . "</p>\n";

                            if($row['dataAmount'] == 0){

                                echo "<p class='card-text'><small>尚無人評論</small></p>\n</div>\n</div>\n</div>\n</div>";

                            } else {

                                echo "<p class='card-text'><small>&#11088 " . round($row['overall'], 1) . "<br>目前評論人數：" . $row['dataAmount'] . "</small></p>\n</div>\n</div>\n</div>\n</div>";

                            }

                        }

                    } else {

                        echo "<p>沒有符合條件的書籍</p>";

                    }
                    echo '<p>找不到想要的書嗎？分享給學長姐請他們來新增評論吧！</p>';
                    echo '<a href="https://social-plugins.line.me/lineit/share?url=https://study-guides.dstw.dev/questionnaire.php"><img src="line.png" style="width:2em; margin: 0 0.5em 0.5em;"></a>';
                    echo '<a href="fb-messenger://share/?link=https://study-guides.dstw.dev/questionnaire.php"><img src="messenger.png" style="width:2em; margin: 0 0.5em 0.5em;"></a>';
                }
		                ?>

            </div>

        </div>

        </center>
        <footer style="margin: 0px; padding: 20px; background-color: rgb(217, 217, 217); text-align: center;  position: sticky;">
            <a href="https://github.com/Today-Asked/Study-Guides-Recommendation" target="_blank" style="color:#000000"><small>Github</small></a>
            &nbsp;
            <a href="https://www.instagram.com/study_guides_recommend/" target="_blank" style="color:#000000"><small>Instagram</small></a>
            &nbsp;
            <a href="mailto:study.guides.recommend@gmail.com" target="_blank" style="color:#000000"><small>Contact us</small></a>
        </footer>
        <a href="#" style="position: fixed; bottom: 1%; right: 1%;"><img src="top.png" style="height: 2.5em;"></a>

</body>