<?php
    session_start();
	session_regenerate_id(true);
?>
<!-- マイページ -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/communication.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜みんなで交流</title>
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
require_once 'loginnav.php';?>
<main>
<?php
// Warningエラーもcatchする
function error_handler($severity, $message, $filename, $lineno) {
throw new ErrorException($message, 0, $severity, $filename, $lineno);
}
set_error_handler('error_handler');
try { // 目標設定がされていない場合、例外処理で目標設定画面へ
// SQL実行(scheduleとregistを選択)
      $sql = "SELECT * FROM `regist` INNER JOIN `schedule` ON regist . id = schedule . regist_id  WHERE `email`=:email";
      $stmt=$pdo->prepare($sql);
      $stmt->bindParam(":email",$_SESSION["email"]);
      $stmt->execute();
      $result=$stmt->fetch(PDO::FETCH_ASSOC);
      $stmt = null;
      if($result["regist_id"] === $result["id"]):
          // 目標未設定の場合、Warningエラーを発生させる
      endif;
  } catch(Exception $e) {?>
  <!-- アイコンを非表示 -->
    <style>.firsticon{ display:none;}.error-name{padding-right: 50px;}main{padding: 50px;}</style>
    <img src="img/tumi-piyo.png" alt="泣く" width="300px"><br><?php
      echo "目標が設定されていません<br>";
      echo "目標を設定しましょう！<br>";
      echo "<p><a href='schedule.php'>目標設定へ</a></p>";?>
    </main>
<?php
    require_once 'footer.php';?>
</div>
</body>
</html>
<?php    exit();
    }?>
<?php
    $stmt=$pdo->prepare("SELECT * FROM `regist` WHERE `email`=:email");
    $stmt->bindParam(":email",$_SESSION["email"]);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;

    $errors = array();

    //POSTなら保存処理実行
    if($_SERVER['REQUEST_METHOD'] === 'POST'):
    // ↓登録情報↓
        $namae = null;
        if(!isset($_POST["namae"]) || !strlen($_POST["namae"])):
            $errors["namae"] = "ニックネームを入力してください";
        elseif(strlen($_POST["namae"]) > 40):
            $errors["namae"] = "ニックネームが長すぎます";
        else:
            $namae = $_POST["namae"];
        endif;

    //ひとことが正しく入力されているかチェック
        $comment = null;
        if(!isset($_POST['comment']) || !strlen($_POST['comment'])):
            $errors['comment'] = 'ひとことを入力してください';
        elseif(strlen($_POST['comment']) > 200):
            $errors['comment'] = 'ひとことは200文字以内で入力してください';
        else:
            $comment = $_POST['comment'];
        endif;
//エラーがなければ保存
        if(count($errors) === 0):
            $date = date('Y-m-d H:i:s');
            $sql='INSERT INTO `comment`(`regist_id`,`date`,`comment`,`namae`) VALUES(:regist_id,:date,:comment,:namae)';
            $stmt = $pdo -> prepare($sql);
            $stmt->bindParam(':regist_id',$result["id"]);
            $stmt->bindParam(':date',$date);
            $stmt->bindParam(':comment',$comment);
            $stmt->bindParam(':namae',$namae);
            $stmt->execute();
            $stmt = null;
        endif;
    endif;
?>
<body>
    <h1>みんなで応援しあおう！</h1>
    <p>ここはみんなが参加できるコミュニティです。</p>
    <p>ゆるゆるdiet会員のみんなと交流しよう！</p>
    <p>※最新の10件のみ表示されます。</p>
    <div class="community">

        <form action="communication.php" method="POST">
            <?php if (count($errors) > 0): ?>
            <ul class="error_list">
                <?php foreach ($errors as $error): ?>
                <li class="error">
                    <?php echo htmlspecialchars($error,ENT_QUOTES,'UTF-8'); ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        名前:<input type="text" id="namae" name="namae" value="<?php echo $result["namae"]; ?>" required><br>
        ひとこと:<textarea id="comment" name="comment" rows="2"  cols="40"></textarea><br>
        <input type="submit" class="btn-border" name="submit" value="送信">
        </form>
<?php
// 書き込み内容呼び出し
    $stmt=$pdo->prepare("SELECT * FROM `comment` INNER JOIN `img` ON `comment`.`regist_id` = `img`.`regist_id` ORDER BY `date` DESC LIMIT 10");
    $stmt->execute();
    $prepare=$stmt->fetchall(PDO::FETCH_ASSOC);
    $stmt = null;
    foreach ($prepare as $array):?>
        <form action="communication.php" method="POST">
            <img src="<?php echo $array["img"];?>" alt="アイコン画像" class='comment-icon'><?php echo $array["namae"];?>さん
            <div class="speech-balloon">
                <span class="box-title">投稿番号：<?php echo $array["id"];?></span>
                <p><?php echo nl2br($array["comment"]);?></p>
                <p><?php echo $array["date"];?>　<a href="#link">削除</a></p>
            </div>
        </form>
        <?php
        echo "<br>";
    endforeach;
?>
<a id="link"></a>
<form action="communication.php" method="GET">
    削除したい投稿番号を入力してください<br>
    <input type="number" name="delete" required>
    <input type="submit" name="submit" value="削除">
</form>
<?php
$mistake = array();
// 自分のコメントか確認し削除
try{
    if(isset($_GET["delete"])):
        $stmt=$pdo->prepare("SELECT `id`,`regist_id` FROM `comment` WHERE `id`=:id");
        $stmt->bindParam(':id',$_GET["delete"]);
        $stmt->execute();
        $str=$stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        if($str["regist_id"] === $result["id"]):
            //SQL実行(DELEET)
            $stmt=$pdo->prepare("DELETE FROM `comment` WHERE `id`=:id");
            $stmt->bindParam(':id',$_GET["delete"]);
            $stmt->execute();
            $stmt=null;
        else:
            $alert = "<script>alert('ほかの人のコメントは消せません')</script>";
            echo $alert;
        endif;
    endif;
} catch (Exception $e) {
    $alert = "<script>alert('投稿番号が間違っています')</script>";
    echo $alert;
}
?>
    </div>
</main>
<?php
// フッター部分呼び出し
endif;
require_once 'footer.php';
?>
    </div>
</body>
</html>