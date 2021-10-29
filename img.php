<?php
    session_start();
	session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="img.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜アイコン変更</title>
</head>
<body>
    <div id="wrapper">
<?php
// DB呼び出し
    require_once 'db.php';
    
    if(!isset($_SESSION["email"])):
    
//ナビ部分呼び出し
    require_once 'nav.php';
?>
<main>
    <img src="img/shinyazangyou-hiyoko.png" alt="error" width="300px">
    <p>通信に失敗しました</p>
    <p>ログインしなおしてください</p>
    <p><a href='login.php'>ログインページ</a></p>
</main>

<?php else: 
    
//ナビ部分呼び出し
require_once 'loginnav.php';?>
<main>
    <p>アイコン画像を変更します。</p>
    <p>※変更すると以前の画像は消えてしまいます！</p><br>
    <p>現在の画像↓</p>
    <img src="<?php echo $_SESSION['img'];?>" alt="アイコン画像" class="img">
    <form action="img1.php" enctype="multipart/form-data" method="post">
        <input name="image" type="file">
        <input type="submit" value="変更する">
    </form>
    <br>
    <a href="mypage.php">変更しない</a>
<?php // キャンセルボタンを押された場合、画像削除
    if(isset($_POST['back'])) {
        unlink($_SESSION['imgname']);
    } 
?>
</main>
<?php
// フッター部分呼び出し
endif;
require_once 'footer.php';
?>
    </div>
</body>
</html>