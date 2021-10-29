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
    <link rel="stylesheet" href="mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜ログアウト</title>
</head>
<body>
    <div id="wrapper">
<?php
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

	$_SESSION = array();
	if (isset($_COOKIE[session_name()])):
		setcookie(session_name(), '', time()-1000);
	endif;
	session_destroy();

// ナビ部分呼び出し
    require_once 'nav.php';
?>
<style>main{padding: 50px; text-align:center;}</style>
<main>
	<p><img src="img/ja-ne.png" alt="error" width="300px"></p>
	<p>ログアウトしました</p><br>
	<p><a href='login.php'>ログインページ</a></p>
</main>
<!-- フッター部分呼び出し -->
<?php
endif;
    require_once 'footer.php';
?>
</body>
</html>
