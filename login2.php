<?php
    session_start();
	session_regenerate_id(true);
?>
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
    require_once 'loginnav.php';
//DB呼び出し
    require_once 'db.php';
    
    if(isset($_SESSION["email"])):
?>
    <h1>会員ページ</h1>
<?php
    $stmt=$pdo->prepare("SELECT * FROM `regist` WHERE `email`=:email");
    $stmt->bindParam(":email",$_SESSION["email"]);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    if($_SESSION["email"] === $result["email"]):
        echo "<p>" . $result["namae"] . " 様いらっしゃいませ</p>";
        echo "<h2>会員情報</h2>";
    endif;
    $pdo=null;
?>
<br>
	<p><a href='logout.php'>ログアウト</a></p>
<?php else: ?>
	<p>ログインしなおしてください</p>
	<p><a href='login.html'>ログインページ</a></p>
<?php endif; ?>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
    </div>
</body>
</html>