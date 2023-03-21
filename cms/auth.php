<?php
session_start();
if(!$_SESSION["login"]):
    header("HTTP/1.1 401 Unauthorized");
?>
<!DOCTYPE html>
<html>
    <head>
        <script>
            alert('permission denied');
        </script>
        <meta http-equiv="refresh" content="5; url=/loginCMS.php">
    </head>
    <body>
        <h1>401 Unauthorized</h1>
        page will redirect to login page in 5 sec...
    </body>
</html>
<?php
exit;
endif;
?>