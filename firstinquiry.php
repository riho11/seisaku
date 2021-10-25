<?php
    session_start();
	session_regenerate_id(true);
//クリックジャッキングという透明なリンクを正常サイトの上にのせて悪意のあるサイトへ誘導するものへの対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

// トークン生成し、セッションを使用しセキュリティ強化
//uniqid()でユニークかつランダムな文字列を生成
	$_SESSION['token']=uniqid('',true);;
?>
<!-- お問い合わせ -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="inquiry.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜お問い合わせ</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
?>
<main>
    <div id="form">
        <h1><span class="under">お問い合わせフォーム</span></h1>
        <form action="firstinquiry1.php" method="POST">
            <table class="form-table">
                <tr>
                    <th><label for="namae"><span class="hissu">必須</span>名前</label></th>
                    <td><input type="text" id="namae" name="namae" placeholder="山田太郎" required></td>
                </tr>
                <tr>
                    <th><label for="email"><span class="hissu">必須</span>メールアドレス</label></th>
                    <td><input type="email" id="email" name="email" placeholder="sample@sample.jp" required></td>
                </tr>
                <tr>
                    <th><label for="tel">連絡先電話番号</label></th>
                    <td><input id="tel" name="tel" type="tel" size="40" placeholder="080-1234-5678"></td>
                </tr>
                <tr>
                    <th><span class="hissu">必須</span>お問い合わせ内容</th>
                    <td><textarea name="comment" id="comment" cols="45" rows="4" placeholder="お問い合わせ内容を入力してください。" required></textarea></td>
                </tr>
                <tr>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                    <td colspan="2"><input class="btn btn-border" type="submit" value="送信"></td>
                </tr>
            </table>
        </form>
    </div>
</main>          
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
    </div>
</body>
</html>