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
    <link rel="stylesheet" href="regist.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜お問い合わせ</title>
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
    
//ナビ部分呼び出し
require_once 'loginnav.php';?>
<!-- アイコンを非表示 -->
<style>.firsticon{ display:none;}.error-name{padding-right: 50px};</style>
    <main>
        <div id="form">
            <h1><span class="under">お問い合わせフォーム</span></h1>
		    <form action="inquiry1.php" method="POST">
                <table class="form-table">
                    <tr>
                        <th><label for="namae"><span class="hissu">必須</span>名前</label></th>
                        <td><input type="text" id="namae"  name="namae" size="40" value="<?php echo $_SESSION["namae"]; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="email"><span class="hissu">必須</span>メールアドレス</label></th>
                        <td><input type="email" id="email" name="email" size="40" value="<?php echo $_SESSION['email']; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="tel">連絡先電話番号</label></th>
                        <td><input id="tel" name="tel" type="tel" size="40" placeholder="080-1234-5678"></td>
                    </tr>
                    <tr>
                        <th class="comment"><span class="hissu">必須</span>お問い合わせ内容</th>
                        <td><textarea name="comment" id="comment" cols="45" rows="4" placeholder="お問い合わせ内容を入力してください。" required></textarea></td>
                    </tr>
                    <tr class="tr-center">
			            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                        <td colspan="2"><input class="btn-border" type="submit" value="送信"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
<!-- フッター部分呼び出し -->
<?php
endif;
    require_once 'footer.php';
    $pdo = null;
?>
    </div>
</body>
</html>