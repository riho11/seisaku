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
    <link rel="stylesheet" href="withdrawal.css">
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
<div class="error">
    <img src="img/shinyazangyou-hiyoko.png" alt="error" width="300px">
    <p>通信に失敗しました</p>
    <p>ログインしなおしてください</p>
    <p><a href='login.php'>ログインページ</a></p>
</div>
<?php else: 
    
//ナビ部分呼び出し
require_once 'loginnav.php';
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

if(count($errors)):?>
<ul class="error">
    <li>
        <img src="img/goukyu.png" alt="泣く" width="300px">
    </li>
<?php foreach($errors as $error): ?>
    <li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
    </li>
<?php endforeach; ?>
    <li><a href="mypage.php">マイページに戻る</a></li>
</ul>
 <?php else:?>

    <form action="withdrawal2.php" method="post" class="withdrawal-form">
        <input type="hidden" name="email" value="<?php echo $_SESSION["email"]; ?>">
        <input type="hidden" name="pass" value="<?php echo $pass; ?>">
        <table class="withdrawal">
            <tr>
                <td><img src="img/batsumaru.png" alt="error" width="300px"></td>
            </tr>
            <tr>
                <td>退会するとすべての記録が削除されます。</td> 
            </tr>
            <tr>
                <td>元に戻すことはできません。</td> 
            </tr>
            <tr>
                <td>本当に退会しますか？</td> 
            </tr>
            <tr class="tr-center">
                <td><input class="btn-border" type="submit" value="退会">
                <input class="btn-border" type="button" value="戻る" onclick="history.go(-1)"></td>
            </tr>
        </table>
    </form>
<?php endif;?>
<!-- フッター部分呼び出し -->
<?php
endif;
$pdo=null;
    require_once 'footer.php';?>
</div>
</body>
</html>