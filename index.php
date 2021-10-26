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
        <div class="text_main">
            <h1>ゆる～くダイエットはじめませんか？</h1><br>
            <p>ゆるゆるdietは毎日の体重、体脂肪などを記録できるサイトです。</p>
            <p>ゆる～くダイエットしても良し！健康管理に使っても良し！</p>
            <p>ゆるゆるっと記録しましょう。</p>
            <br><br>
            <a href="regist.php" class="start">はじめる</a>
        </div>
        <div class="nyoro_img">
            <img src="img/nyoronyoro-gif.gif" alt="" width="100px">
            <img src="img/nyoronyoro-gif.gif" alt="" width="100px">
            <img src="img/nyoronyoro-gif.gif" alt="" width="100px">
            <img src="img/nyoronyoro-gif.gif" alt="" width="100px">
        </div>
    </main>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
    </div>
</body>
</html>