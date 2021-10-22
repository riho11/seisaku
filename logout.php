<?php
    session_start();
	session_regenerate_id(true);
?>
<!-- ログアウト画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="login.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜ログアウト</title>
</head>
<body>
    <div id="wrapper">
<!-- ナビ部分呼び出し -->
<?php
    require_once 'nav.php';

	if(!isset($_SESSION['email'])):
		exit("直接アクセス禁止");
	endif;
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])):
		setcookie(session_name(), '', time()-1000);
	endif;
	session_destroy();
?>
	<p>ログアウトしました</p>
	<p><a href='login.php'>ログインページ</a></p>
	<p><a href="index.php">トップページ</a></p>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
</body>
</html>
