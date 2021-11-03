<?php
session_start();
session_regenerate_id(true);

header('X-FRAME-OPTIONS: SAMEORIGIN');

if(!(hash_equals($_POST['token'],$_SESSION['token']))){
	echo "正しくアクセスしてください";
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-1000);
	}
	session_destroy();
	exit();
}

//送信先アドレス
$mail='pinooniq0301@gmail.com';
//メールの言語と文字コード設定
	mb_language('japanese');
	mb_internal_encoding('UTF-8');

	$email=$_POST["email"];
	$namae=$_POST["namae"];
	$tel=$_POST["tel"];
	$comment=$_POST['comment'];
	$subject="お問い合わせ";
	$body=$comment."\n".$namae."\n".$email;//メール本文作成
	$from="From:info@aaa.aa";
    
	$result=mb_send_mail($mail,$subject,$body,$from);
?>

<!-- お問い合わせ -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/regist.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜お問い合わせ送信完了</title>
</head>
<body>
    <div id="wrapper">
<?php
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
    
//ナビ部分呼び出し
require_once 'loginnav.php';

 if($result): ?>
	<main class="change">
    	<img src="img/tanosimi-hiyoko.png" alt="踊る" width="300px">
		<p>送信完了</p>
 	</main>
<?php else: ?>
	<main class="error">
    	<img src="img/goukyu.png" alt="泣く" width="300px">
		<p>送信失敗</p>
 	</main>
<?php endif; ?>
<?php
// フッター部分呼び出し
	endif;
    require_once 'footer.php';
    $pdo = null;
?>
    </div>
</body>
</html>