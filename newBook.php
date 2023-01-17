<?php
require_once "databaseLogin.php";
$connection = new mysqli($hostname, $username, $password, $database);
if($connection->error) die("database connection error!");
$connection->set_charset("utf8");
//echo $connection -> character_set_name();
$subject = $name = $publisher = $date = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $subject = test_input($_POST["subject"]);
    $name = test_input($_POST["name"]);
    $exam = test_input($_POST["exam"]);
    $category = test_input($_POST["category"]);
    $publisher = test_input($_POST["publisher"]);
    //echo "<script language='javascript'>window.console.log('" . $publisher . "')</script>";

    if($_FILES['picture']['error'] === UPLOAD_ERR_OK){
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
            $insert = "INSERT INTO book (subject, name, exam, category, publisher, picture) 
                VALUES ('$subject', '$name', '$exam', '$category', '$publisher', '$ImgURL')";
            
            if($connection->query($insert) === true){
                echo "<script language='javascript'>alert('成功新增書籍，感謝您的幫忙！');location.href='/newBook.php';</script>";
                //echo "success";
            } else {
                echo "<script language='javascript'>alert('抱歉，資料庫發生錯誤，請再試一次');location.href='/newBook.php';</script>";
                //echo "an error occurred when inserted into database";
            }
        } else {
            echo "<script language='javascript'>window.console.log('**" . $curl_result . "')</script>";
        }
    } else {
        echo "<script language='javascript'>window.console.log('an error occurred when uploading picture')</script>";
        echo "<script language='javascript'>alert('抱歉，上傳圖片發生錯誤，請再試一次');location.href='/newBook.php';</script>";
    }
    
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE HTML5>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZXCEF0Q5KK"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-ZXCEF0Q5KK');
    </script>
    <script>
        $('document').ready(function(){
            $("#bookname").blur(function(){
                var search = $(this).val();
                //console.log("search: " + search);
                if(search != ''){
                    loadData(search);
                }
            })

            function loadData(query){
                $.ajax({
                    url: "/search.php",
                    method: "get",
                    data: {
                        search: query
                    },
                    success: function(data){
                        $("#searchResult").html(data);
                    },
                    error: function(error){
                        console.log(error);
                    }
                })
            }
        });
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
    <title>新增參考書</title>
    <!--<meta charset="UTF-8">-->
    <script src="book_questionnaire.js"></script>
    <style>
        @media (min-width: 200px){
            .content{
                margin: 5% 10% 5%;
            }
            .head{
                margin-top: 60px;
            }
        }
        @media (min-width: 768px){
            .content{
                margin: 5% 10% 5%;
            }
            .head{
                margin-top: 55px;
            }
        }
        @media (min-width: 992px) {
            .content{
                margin: 5% 20% 5%;
            }
            .head{
                margin-top: 40px;
            }
        }
        @media (min-width: 1200px) {
            .content{
                margin: 5% 30% 5%;
            }
            .head{
                margin-top: 30px;
            }
        }
    </style>
</head>

<body>
    <script>
        function fixing(){
            alert("施工中 就跟雄女的大門一樣");
        }
    </script>
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
                                <a class="nav-link" href="query.php">瀏覽清單</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="newBook.php">新增參考書</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="questionnaire.php">撰寫回饋</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tips.html">其他小知識！</a>
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
    <div class="head" id="searchResult">你沒看到你沒看到你沒看到</div>
    <!--放著占位子-->
<div class="wrapping" style="margin-bottom: -20px; min-height: 100%;">
    <div class="content">

        <h1 style="text-align: center">新增參考書
            <button type="button" data-bs-toggle="modal" data-bs-target="#Modal" style="border: none; background: none;">
                <i class="bi bi-question-circle-fill" style="font-size: 0.7em; color: rgb(139, 139, 139);"></i>
            </button>
        </h1>

        <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">使用說明</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="fakeIllustration">
                        欸嘿嘿謝謝尼願意點進來，最愛你了(被拖走<br><hr>
                        不...不是啦，我是說，書名要打完整，否則會造成別人困擾餒。
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">好...好喔</button>
                    </div>
                </div>
            </div>
        </div>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" id="book"
            class="needs-validation" novalidate enctype="multipart/form-data">
            <label>科目：</label>
            <select class="form-select" name="subject" required>
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
            <div>
                <label for="bookname">書本完整名稱：</label>
                <input class="form-control" type="text" name="name" id="bookname" required>
                <div class="invalid-feedback">
                    請輸入書名
                </div><br>
            </div>

            <label>適用考試：</label>
            <!--<input type="text" name="exam" value="學測">-->
            <select class="form-select" name="exam" required>
                <option value="學測">學測</option>
                <option value="分科測驗">分科測驗</option>
                <option value="全民英檢">全民英檢</option>
                <option value="多益">多益</option>
                <option value="段考">段考</option>
                <option value="其他">其他</option>
            </select>
            <br>

            <label>類別：</label>
            <!--<input type="text" name="category" value="工具書">-->
            <select class="form-select" name="category" required>
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
            <br>

            <label>出版社：</label>
            <!--<input type="text" name="publisher" value="龍騰">-->
            <select class="form-select" name="publisher" required>
                <option value="龍騰">龍騰</option>
                <option value="翰林">翰林</option>
                <option value="南一">南一</option>
                <option value="全華">全華</option>
                <option value="康熹">康熹</option>
                <option value="晟景">晟景</option>
                <option value="泰宇">泰宇</option>
                <option value="三民">三民</option>
                <option value="華逵">華逵</option>
                <option value="康寧泰順書坊">康寧泰順書坊</option>
                <option value="LiveABC">LiveABC</option>
                <option value="AMC">AMC</option>
                <option value="常春藤">常春藤</option>
                <option value="其他">其他</option>
            </select>
            <br>
            
            <div class="mb-3">
            <label for="formFile" class="form-label">上傳參考書封面</label>
            <input type="file" class="form-control" name="picture" id="formFile" accept="image/*" required>
            </div>
            <script>
                var file = document.getElementById('formFile');

                file.onchange = function(e) {
                    var ext = this.value.match(/\.([^\.]+)$/)[1];
                    switch (ext) {
                        case 'jpg':
                        case 'jpeg':
                        case 'bmp':
                        case 'png':
                        case 'tif':
                            break;
                        default:
                            alert('叫你上傳圖片是不是聽不懂人話?');
                            this.value = '';
                    }
                };
            </script>
            <center><input type="submit" class="btn btn-outline-success" style="margin-bottom: 5%;"></center>
        </form>
    </div>
    </div>
    <footer style="margin: 0px; padding: 20px; background-color: rgb(217, 217, 217); text-align: center; position: sticky;">
        Copyright © 2022 玉米糖粉. All rights reserved.<br>
        111 級雄女資研出品<br>
        Contact us:  
        <a href="mailto:study.guides.recommend@gmail.com" target="_blank"><small>study.guides.recommend@gmail.com</small></a>
    </footer>
    <a href="#" style="position: fixed; bottom: 1%; right: 1%;"><img src="top.png" style="height: 2.5em;"></a>
    
</body>