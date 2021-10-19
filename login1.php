<!-- ログイン画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="login.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜ログイン</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
//DB呼び出し
    require_once 'db.php';

    if($_SERVER["REQUEST_METHOD"]!=="POST"):
        $pdo=null;
        exit("直接アクセス禁止");
    endif;
//SQL実行
    $stmt=$pdo->prepare("SELECT `email`,`pass`,`namae` FROM `regist` WHERE `email`=:email");
    $stmt->bindParam(":email",$_POST["email"]);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    if($result):
        if(password_verify($_POST["pass"],$result["pass"])):
                session_start();
                session_regenerate_id(true);
                $_SESSION['email']=$_POST["email"];
                $_SESSION['pass']=$_POST["pass"];
                $_SESSION["namae"] = $result["namae"];
                header("Location: http://".$_SERVER['HTTP_HOST']."/seisaku/login2.php");
        else:
            $errors = "パスワードが違います";
        endif;
    else:
        $errors = "ユーザーが存在しません";
    endif;
    $stmt = null;
    if(isset($errors)):
?>
    <p><?php echo $errors; ?></p>
    <p><a href="login.php">ログイン画面に戻る</a></p>
<?php
    endif;
    $pdo = null;
?>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
    </div>
</body>
</html>