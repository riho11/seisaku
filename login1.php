<?php
session_start();
session_regenerate_id(true);

//DB呼び出し
    require_once 'db.php';

    if($_SERVER["REQUEST_METHOD"]!=="POST"):
        $pdo=null;
        exit("直接アクセス禁止");
    endif;
//SQL実行
    $stmt=$pdo->prepare("SELECT `id`,`email`,`pass`,`namae` FROM `regist` WHERE `email`=:email");
    $stmt->bindParam(":email",$_POST["email"]);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    if($result):
        if(password_verify($_POST["pass"],$result["pass"])):
                $_SESSION['email']=$_POST["email"];
                $_SESSION['pass']=$_POST["pass"];
                $_SESSION["namae"] = $result["namae"];
                $_SESSION["id"] = $result["id"];
    // 画像表示
                $stmt=$pdo->prepare("SELECT `img` FROM `img` WHERE `regist_id`=:regist_id");
                $stmt->bindParam(":regist_id",$result["id"]);
                $stmt->execute();
                $img=$stmt->fetch(PDO::FETCH_ASSOC);
                $stmt = null;
                $_SESSION["img"] = $img["img"];
                header("Location: http://".$_SERVER['HTTP_HOST']."/seisaku/mypage.php");
        else:
            $errors = "パスワードが違います";
        endif;
    else:
        $errors = "ユーザーが存在しません";
    endif;
    $stmt = null;
    if(isset($errors)):
?>
<!-- ログイン画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/regist.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜ログイン</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
?>
<div  class="error">
    <p><img src="img/goukyu.png" alt="泣く" width="300px"></p>
    <p><?php echo $errors; ?></p>
    <p class="sukima"><input class="btn-border" type="button" value="戻る" onclick="history.go(-1)"></p>
    </div>
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