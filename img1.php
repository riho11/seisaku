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

    $errors = array();
    
    if(isset($_SESSION["email"])):
// SQL(フォルダ名につけるidの取得)
        $stmt=$pdo->prepare("SELECT `id` FROM `regist` WHERE `email`=:email");
        $stmt->bindParam(":email",$_SESSION["email"]);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;

// 画像判定
        $e_code = $_FILES['image']['error'];
        if ($e_code!=0) :
            $errors[""] = "ファイル送信エラー";
        endif;
        
        $filename = 'created_at/' . $result["id"] . $_FILES['image']['name'];
        $result = @move_uploaded_file($_FILES['image']['tmp_name'], $filename);
        if (!$result):
            $errors[""] = "ファイル保存エラー";
        endif;
        $date = date('Y-m-d H:i:s');
        $_SESSION['imgname'] = $filename;
?>  
    <?php if (count($errors)): ?>
        <ul>
    <?php foreach($errors as $error): ?>
            <li>
    <?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
            </li>
    <?php endforeach; ?>
            <li><a href="mypage.php">マイページに戻る</a></li>
        </ul>
        <?php else:?>
        <p><img src="<?php echo $filename; ?>" alt="送信画像"></p>
        <form action="img2.php" enctype="multipart/form-data" method="post">
            <input type="hidden" name="created_at" value="<?php echo $date; ?>">
            <input type="hidden" name="img" value="<?php echo $filename; ?>">
            <input type="submit" name="register" value="登録">
        </form>
        <form action="img.php" method="post">
            <input type="submit" name="back" value="キャンセル">
        </form> 
        
<script>// メニューバーを押した場合の注意メッセージ
const arr = document.getElementsByTagName("a");
 
 for (let i = 0; i < arr.length; i++) {
   arr[i].onclick = (e) => { alert('登録、キャンセルいずれかを選択してください'); e.preventDefault(); };
 }
</script>

    <?php endif; ?>
<?php else: ?>
	<p>ログインしなおしてください</p>
	<p><a href='login.html'>ログインページ</a></p>
<?php endif; ?>
        </main>
<?php
// フッター部分呼び出し
    require_once 'footer.php';
?>
    </div>
</body>
</html>