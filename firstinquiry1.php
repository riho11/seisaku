<?php
    session_start();
	session_regenerate_id(true);
//クリックジャッキングという透明なリンクを正常サイトの上にのせて悪意のあるサイトへ誘導するものへの対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
//トークンを確認する。ハッシュの比較をするhash_equals()を使用
//第1引数と第2引数が同じならtrue、違えばfalseが返る
if(!(hash_equals($_POST['token'],$_SESSION['token']))){
	echo "正しくアクセスしてください";
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-1000);
	}
	session_destroy();
	exit();
}?>

<!-- お問い合わせ -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/regist.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜お問い合わせ</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
    $errors=array();

    $namae = null;
    if(!isset($_POST["namae"]) || !strlen($_POST["namae"])):
        $errors["namae"] = "名前を入力してください";
    elseif(strlen($_POST["namae"]) > 40):
        $errors["namae"] = "名前が長すぎます";
    else:
        $namae = $_POST["namae"];
    endif;

    $email = null;
    if(!isset($_POST["email"]) || !strlen($_POST["email"])):
        $errors["emaill"] = "メールアドレスを入力してください";
    elseif(strlen($_POST["email"]) > 40):
        $errors["email"] = "メールアドレスが長すぎます";
    elseif(!preg_match("/^[a-zA-Z0-9]+[a-zA-z0-9\._-]*@[a-zA-Z0-9_-]+.[a-zA-Z0-9\._-]+$/",$_POST["email"])):
        $errors["email"] = "メールアドレスの形式が誤っています";
    else:
        $email = $_POST["email"];
    endif;
    
    $tel = null;
    if(strlen($_POST["tel"])):
        if(!preg_match("/^0[1-9][0-9]{8,9}$/",$_POST["tel"])):
            $errors["tel"] = "電話番号の形式が違います";
        elseif(strlen($_POST["tel"]) > 11):
            $errors["tel"] = "電話番号が長すぎます";
        endif;
        $tel = $_POST["tel"];
    else:
        $tel = "なし";
    endif;

    $comment = null;
    if(!isset($_POST["comment"]) || !strlen($_POST["comment"])):
        $errors["comment"] = "コメントを入力してください";
    elseif(strlen($_POST["comment"]) > 500):
        $errors["comment"] = "コメントが長すぎます";
    else:
        $comment = $_POST["comment"];
    endif;

    if(count($errors)):
    ?>

        <main>
            <ul class="error">
			    <li><img src="img/goukyu.png" alt="泣く" width="300px"></li>
    <?php foreach($errors as $error): ?>
                <li><?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?></li>
    <?php endforeach; ?>
                <li><a href="firstinquiry.php">お問い合わせ画面に戻る</a></li>
            </ul>
        </main>
    <?php else: ?>
        <main>
            <div id="form">
                <h1><span class="under">お問い合わせ内容確認</span></h1>
                <table class="table-check">
                    <tr>
                        <th>名前</th>
                        <td><?php echo htmlspecialchars($namae,ENT_QUOTES,"UTF-8"); ?></td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td><?php echo htmlspecialchars($email,ENT_QUOTES,"UTF-8"); ?></td>
                    </tr>
                    <tr>
                        <th>連絡先電話番号</th>
                        <td><?php echo htmlspecialchars($tel,ENT_QUOTES,"UTF-8"); ?></td>
                    </tr>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td><?php echo nl2br(htmlspecialchars($comment,ENT_QUOTES,"UTF-8")); ?></td>
                    </tr>
                </table>
                <form action="firstinquiry2.php" method="post">
                    <input type="hidden" name="namae" value="<?php echo $namae; ?>">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="tel" value="<?php echo $tel; ?>">
                    <input type="hidden" name="comment" value="<?php echo nl2br($comment); ?>">
                    <table>
                        <tr>
                            <td colspan="2">以上で、お間違いないでしょうか？</td>
                        </tr>
                        <tr class="tr-center">
			                <input type="hidden" name="token" value=<?php echo $_POST['token']; ?>>
                            <td><input class="btn-border" type="submit" value="登録"></td>
                            <td><input class="btn-border" type="button" value="戻る" onclick="history.go(-1)"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
<?php endif; ?>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
    </div>
</body>
</html>