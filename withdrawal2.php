<?php
    session_start();
	session_regenerate_id(true);
?>
<!-- 退会画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/withdrawal.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>ゆるゆるdiet｜退会画面</title>
</head>
<body>
    <div id="wrapper">
<?php
//DB呼び出し
    require_once 'db.php';

    if(!isset($_SESSION["email"])):
    //ナビ部分呼び出し
        require_once 'nav.php';
?>
<main>
    <div class="error">
        <img src="img/shinyazangyou-hiyoko.png" alt="error" width="300px">
        <p>通信に失敗しました</p>
        <p>ログインしなおしてください</p>
        <p><a href='login.php'>ログインページ</a></p>
    </div>
</main>
<?php else: 
    $errors = array();
    
// ↓登録情報確認↓
    $pass = null;
    if(!isset($_POST["pass"]) || !strlen($_POST["pass"])):
        $errors["pass"] = "パスワードを入力してください";
    elseif(!preg_match("/^[a-zA-Z0-9]{6,12}$/",$_POST["pass"])):
        $errors["pass"] = "パスワードの形式が違います";
    else:
        $pass = $_POST["pass"];
    endif;

    //SQL実行(SELECT)
    $stmt=$pdo->prepare("SELECT `id`,`email`,`pass` FROM `regist` WHERE `email`=:email");
    $stmt->bindParam(':email',$_SESSION["email"]);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    $stmt=null;
    if($_SESSION["email"] === $result["email"]):
        if(!password_verify($_POST["pass"],$result["pass"])):
            $errors["pass"] = "パスワードが違います";
        endif;
    endif;
?>
<?php
if (count($errors)): 
//ナビ部分呼び出し
require_once 'loginnav.php';?>
<main>
    <ul class="error">
        <li><img src="img/goukyu.png" alt="泣く" width="300px"></li>
<?php foreach($errors as $error): ?>
        <li><?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8"); ?></li>
<?php endforeach; ?>
        <li><a href="mypage.php">マイページに戻る</a></li>
    </ul>
</main>
<?php else:
    //SQL実行(DELEET)
    $stmt=$pdo->prepare("DELETE FROM `regist` WHERE `email`=:email");
    $stmt->bindParam(':email',$_SESSION["email"]);
    $stmt->execute();
    $stmt=null;

    $_SESSION = array();
    if (isset($_COOKIE[session_name()])):
        setcookie(session_name(), '', time()-1000);
    endif;
    session_destroy();
    //ナビ部分呼び出し
    require_once 'nav.php';?>
    <main class="change">
        <p><img src="img/ja-ne.png" alt="じゃあね" width="300px"></p>
        <p>退会しました。</p>
        <p><a href="regist.php">新規登録</a></p>
    </main>
<?php endif;
$pdo = null;?>
<?php
// フッター部分呼び出し
endif;
$pdo=null;
    require_once 'footer.php';?>
</div>
</body>
</html>
        