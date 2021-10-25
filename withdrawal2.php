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
    <link rel="stylesheet" href="mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>ゆるゆるdiet｜退会画面</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
//DB呼び出し
    require_once 'db.php';

if(isset($_SESSION["email"])):
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

    if(count($errors)===0):
        //SQL実行(SELECT)
        $stmt=$pdo->prepare("SELECT `id`,`email`,`pass` FROM `regist` WHERE `email`=:email");
        $stmt->bindParam(':email',$_SESSION["email"]);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        if($_POST["email"] === $result["email"]):
            if(password_verify($_POST["pass"],$result["pass"])):
            //SQL実行(DELEET)
                $stmt=$pdo->prepare("DELETE FROM `regist` WHERE `email`=:email");
                $stmt->bindParam(':email',$_SESSION["email"]);
                $stmt->execute();
                $stmt=null;
            endif;
        endif;
    endif;      
?>
<?php if (count($errors)): ?>
    <ul>
<?php foreach($errors as $error): ?>
        <li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8"); ?>
        </li>
<?php endforeach; ?>
        <li><a href="regist.php">登録画面に戻る</a></li>
    </ul>
<?php else:?>
	<p>退会しました。</p>
    <p><a href="regist.php">新規登録</a></p>
<?php endif;
$pdo = null;
$_SESSION = array();
if (isset($_COOKIE[session_name()])):
    setcookie(session_name(), '', time()-1000);
endif;
session_destroy();

else: ?>
	<p>ログインしなおしてください</p>
	<p><a href='login.php'>ログインページ</a></p>
<?php endif;
//フッター部分呼び出し
require_once 'footer.php';
?>
        </main> 
    </div>
</body>
</html>
        