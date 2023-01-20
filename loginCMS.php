<?php
session_start();
require_once "databaseLogin.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $account = $_POST["account"];
    $password = $_POST["password"];
    echo "<script>console.log('" . $account . "  " . $password ."');</script>";
    if($account === $acc && $password === $pwd){
        $_SESSION["login"] = true;
        echo "<script>location.href = '/cms/cms.php';</script>";
    } else {
        echo "wrong account name or password";
    }
}
?>
<head>
    <title>後台登入</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        #login{
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translateY(-40%);
            transform: translateX(-50%);
            border-width: 2px;
            border-color: rgb(200, 200, 200);
            border-style: solid; 
            border-radius: 5px;
            padding: 2%;
        }
    </style>
</head>
<body>
    <center> 
        <div id="login">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">帳號：</label>
                    <input name = "account" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">密碼：</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-secondary" style="margin: 2%">送出</button>
            </form>
        </div>
    </center>
</body>