<?php
    session_start();
	session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜アイコン変更</title>
</head>
<body>
    <div id="wrapper">
<?php
// ナビ部分呼び出し
    require_once 'loginnav.php';
// DB呼び出し
    require_once 'db.php';
    
    if(isset($_SESSION["email"])):
?>

    <form action="img1.php" enctype="multipart/form-data" method="post">
        <input name="image" type="file"><br>
        <input type="submit" value="アップロード">
    </form>
<?php // キャンセルボタンを押された場合、画像削除
    if(isset($_POST['back'])) {
        unlink($_SESSION['imgname']);
    } 
?>
<?php else: ?>
	<p>ログインしなおしてください</p>
	<p><a href='login.php'>ログインページ</a></p>
<?php endif; ?>
        </main>
<?php
// フッター部分呼び出し
    require_once 'footer.php';
?>
    </div>
</body>
</html>