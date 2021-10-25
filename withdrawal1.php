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
    require_once 'loginnav.php';

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

if(count($errors)):?>
<ul>
<?php foreach($errors as $error): ?>
    <li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
    </li>
<?php endforeach; ?>
    <li><a href="regist.php">登録画面に戻る</a></li>
</ul>
 <?php else:?>

    <form action="withdrawal2.php" method="post">
        <input type="hidden" name="email" value="<?php echo $_SESSION["email"]; ?>">
        <input type="hidden" name="pass" value="<?php echo $pass; ?>">
        <table>
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
                <td><input class="btn btn-border" type="submit" value="退会"></td>
                <td><input class="btn btn-border" type="button" value="戻る" onclick="history.go(-1)"></td>
            </tr>
        </table>
    </form>
<?php endif;
else: ?>
	<p>ログインしなおしてください</p>
	<p><a href='login.php'>ログインページ</a></p>
<?php endif; ?>
        </main>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
    $pdo = null;
?>
    </div>
</body>
</html>