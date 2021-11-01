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
$errors = array();

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
		<ul class="error">
			<li>
                <img src="img/goukyu.png" alt="泣く" width="300px">
			</li>
    <?php foreach($errors as $error): ?>
            <li>
    <?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
            </li>
    <?php endforeach; ?>
            <li><a href="mypage.php">マイページに戻る</a></li>
        </ul>
        <?php else:?>
        <main>
            <p>この画像で間違いないですか？</p>
            <p><img src="<?php echo $filename; ?>" alt="送信画像"  width="300px"></p>
            <form action="img2.php" enctype="multipart/form-data" method="post">
                <input type="hidden" name="created_at" value="<?php echo $date; ?>">
                <input type="hidden" name="img" value="<?php echo $filename; ?>">
                <input type="submit" name="register" value="変更">
            </form>
            <br>
            <form action="img.php" method="post">
                <input type="submit" name="back" value="やっぱり、やめる">
            </form> 
        </main>
        
<script>// メニューバーを押した場合の注意メッセージ
const arr = document.getElementsByTagName("a");
 
 for (let i = 0; i < arr.length; i++) {
   arr[i].onclick = (e) => { alert('登録、キャンセルいずれかを選択してください'); e.preventDefault(); };
 }
</script>

    <?php endif; ?>
</main>
<?php
// フッター部分呼び出し
endif;
require_once 'footer.php';
?>
    </div>
</body>
</html>