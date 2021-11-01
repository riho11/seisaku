<?php
    session_start();
	session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/img.css">
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
require_once 'loginnav.php';

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
        $_SESSION['img']=$_POST["img"];
        $pdo = null;
?>
<main>
    <img src="img/tanosimi-hiyoko.png" alt="たのしみ"  width="200px">
    <p>変更しました</p>
    <p>ページを移動すると反映します。</p>
</main>
<?php
// フッター部分呼び出し
endif;
require_once 'footer.php';
?>
    </div>
</body>
</html>