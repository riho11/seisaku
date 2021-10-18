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

// SQL取得(img,registを取得)
        $stmt=$pdo->prepare("SELECT * FROM `img` INNER JOIN `regist` ON img . regist_id = regist . id WHERE `email`=:email");
        $stmt->bindParam(":email",$_SESSION["email"]);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        if($_SESSION["email"] === $result["email"]):
            //更新前の画像を消す処理
            $unfile = $result["img"];
            if($_SESSION['imgname'] !== $unfile): // (フォルダ名が異なる場合のみ処理…リロード対策)
                if(file_exists($unfile)):
                    unlink($unfile);
                endif;
            endif;
// SQL実行(UPDATE)
            $sql = 'UPDATE `img` SET `created_at`=:created_at ,`img`=:img WHERE `regist_id` = :regist_id';
            $stmt = $pdo -> prepare($sql);
            $stmt->bindParam(':created_at',$_POST["created_at"]);
            $stmt->bindValue(':img',$_POST["img"]);
            $stmt->bindParam(':regist_id',$result["id"]);
            $stmt->execute();
            $stmt = null;
        endif;
        $pdo = null;
?>
<p>変更しました</p>
<?php
    else: ?>
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