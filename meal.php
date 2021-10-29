<?php
    session_start();
	session_regenerate_id(true);
?>
<!-- マイページ -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜運動記録</title>
</head>
<body>
    <div id="wrapper">
<?php    
    if(!isset($_SESSION["email"])):
    
//ナビ部分呼び出し
    require_once 'nav.php';
?>
    <style>.error-name{ display:none;}</style>
<div class="error">
    <img src="img/shinyazangyou-hiyoko.png" alt="error" width="300px">
    <p>通信に失敗しました</p>
    <p>ログインしなおしてください</p>
    <p><a href='login.php'>ログインページ</a></p>
</div>
<?php else: 
    
//ナビ部分呼び出し
require_once 'loginnav.php';?>
<main>
<style>.firsticon{ display:none;}.error-name{padding-right: 50px;}main{padding: 50px; text-align:center;}</style>
<img src="img/white-helmet-hiyoko.png" alt="工事中" width="300px"><br>
<body>
    <p>工事中</p>
</main>
<?php
// フッター部分呼び出し
endif;
require_once 'footer.php';
?>
    </div>
</body>
</html>