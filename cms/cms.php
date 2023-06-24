<?php
require_once "auth.php";
?>
<!DOCTYPE HTML5>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>後台索引頁</title>
    <meta name="robots" content="noindex">
    <style>
        .content{
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .list-group{
            width: 80%;
            max-width: 600px;
        }
        img{
            height: 100%;
        }
        .list-group-item{
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="list-group">
            <a href="./reviewComment.php" type="button" class="list-group-item list-group-item-action" aria-current="true">
                <div>
                    <img src="star.png">審核評論
                </div>
            </a>
            <a href="./reviewMsg.php" type="button" class="list-group-item list-group-item-action" aria-current="true">
                <div>
                    <img src="comment.png"> 審核留言
                </div>
            </a>
            <a href="./alterComment.php" type="button" class="list-group-item list-group-item-action" aria-current="true">
                <div>
                    <img src="bin.png"> 刪除資料（評論 or 書籍）
                </div>
            </a>
            <a href="./picture.php" type="button" class="list-group-item list-group-item-action" aria-current="true">
                <div>
                    <img src="upload.png"> 更新封面圖片
                </div>
            </a>
            <a href="./recalculateData.php" type="button" class="list-group-item list-group-item-action" aria-current="true">
                <div>
                    <img src="calculator.png"> 
                    重新計算 book 資料表
                </div>
                <div>（按下此連結就會執行！）</div>
            </a>
        </div>
    </div>
</body>