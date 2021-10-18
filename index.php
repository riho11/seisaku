<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜トップページ</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
?>
        <main>
            <p><a href="regist.php">新規登録</a></p>
            <p><a href="login.php">ログイン</a></p>
        </main>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
    </div>
</body>
</html>