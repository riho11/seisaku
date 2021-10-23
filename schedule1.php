<?php
    session_start();
	session_regenerate_id(true);
?>
<!-- 目標設定画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="schedule.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜目標設定</title>
</head>
<body>
    <div id="wrapper">
<!-- アイコンを非表示 -->
<style>.firsticon{ display:none;}</style>
<?php
//ナビ部分呼び出し
    require_once 'loginnav.php';
//DB呼び出し
    require_once 'db.php';
    
    $errors = array();

    if(isset($_SESSION["email"])):

// ↓登録情報↓
    $goal_weight = null;
    if(!isset($_POST["goal_weight"]) || !strlen($_POST["goal_weight"])):
        $errors["goal_weight"] = "体重を入力してください";
    elseif(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["goal_weight"])):
        $errors["goal_weight"] = "体重の形式が違います";
    else:
        $goal_weight = $_POST["goal_weight"];
    endif;

    $goal_year = null;
    if(!isset($_POST["goal_year"])):
        $errors["goal_year"] = "目標日の年を選択してください";
    else:
        $goal_year = $_POST["goal_year"];
    endif;

    $goal_month = null;
    if(!isset($_POST["goal_month"])):
        $errors["goal_month"] = "目標日の月を選択してください";  
    else:
        $goal_month = $_POST["goal_month"];
    endif;

    $goal_day = null;
    if(!isset($_POST["goal_day"])):
        $errors["goal_day"] = "目標日の日を選択してください";
    elseif($_POST["goal_year"] === date("Y")):
        if($_POST["goal_month"] <= date("m") && $_POST["goal_day"] <= date("d")):
            $errors[""] = "未来の日付を選択してください";
        endif;
        $goal_day = $_POST["goal_day"];
    else:
        $goal_day = $_POST["goal_day"];
    endif;

    $bodyfat = null;
    if(strlen($_POST["bodyfat"])):
        if(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["bodyfat"])):
            $errors["bodyfat"] = "体脂肪の形式が違います";
        endif;
        $bodyfat = $_POST["bodyfat"];
    endif;

    $goal_bodyfat = null;
    if(strlen($_POST["goal_bodyfat"])):
        if(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["goal_bodyfat"])):
            $errors["goal_bodyfat"] = "目標体脂肪の形式が違います";
        endif;
        $goal_bodyfat = $_POST["goal_bodyfat"];
    endif;

    if(count($errors)===0):
// SQL取得
        $stmt=$pdo->prepare("SELECT `id`,`email` FROM `regist` WHERE `email`=:email");
        $stmt->bindParam(":email",$_SESSION["email"]);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        if($_SESSION["email"] === $result["email"]):
            // imgの画像情報をSESSIONに取得
            $stmt=$pdo->prepare("SELECT `img`,`regist_id` FROM `img` WHERE `regist_id`=:regist_id");
            $stmt->bindParam(":regist_id",$result["id"]);
            $stmt->execute();
            $img=$stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
            $_SESSION["img"] = $img["img"];
            // 「schedule」内に$result["id"]と同じregist_idが存在しないか確認
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM `schedule` WHERE `regist_id`=:regist_id");
            $stmt->bindParam(":regist_id",$result["id"]);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $stmt = null;
            if($count === 0):
//SQL保存
                $sql='INSERT INTO `schedule`(`goal_weight`,`goal_year`,`goal_month`,`goal_day`,`bodyfat`,`goal_bodyfat`,`regist_id`) VALUES(:goal_weight,:goal_year,:goal_month,:goal_day,:bodyfat,:goal_bodyfat,:regist_id)';
                $stmt = $pdo -> prepare($sql);
                $stmt->bindParam(':goal_weight',$goal_weight);
                $stmt->bindParam(':goal_year',$goal_year);
                $stmt->bindParam(':goal_year',$goal_year);
                $stmt->bindParam(':goal_month',$goal_month);
                $stmt->bindParam(':goal_day',$goal_day);
                $stmt->bindParam(':bodyfat',$bodyfat);
                $stmt->bindParam(':goal_bodyfat',$goal_bodyfat);
                $stmt->bindParam(':regist_id',$result["id"]);
                $stmt->execute();
                $stmt = null;
            else: ?>
                <p>既に目標は設定されています</p> 
                <style>.goal{ display: none; }</style><!-- 登録完了を非表示 -->
<?php       endif;
        endif;
    endif;
    $pdo = null;
?>
<?php if (count($errors)): ?>
    <ul>
<?php foreach($errors as $error): ?>
        <li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
        </li>
<?php endforeach; ?>
        <li><a href="schedule.php">目標画面に戻る</a></li>
    </ul>
<?php else:?>
    <p class="goal">登録完了しました</p>
    <p><a href="mypage.php">マイページへ</a></p>
<?php endif; ?>
<?php else: ?>
<p>ログインしなおしてください</p>
<p><a href='login.html'>ログインページ</a></p>
<?php endif; ?>
<!-- フッター部分呼び出し -->
<?php
require_once 'footer.php';
?>
</div>
</body>
</html>