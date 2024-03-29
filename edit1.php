<?php
    session_start();
	session_regenerate_id(true);
?>
<!-- 編集画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/edit.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <title>ゆるゆるdiet｜編集画面</title>
</head>
<body>
    <div id="wrapper">
<?php
//DB呼び出し
    require_once 'db.php';
    
    $errors = array();
    if(!isset($_SESSION["email"])):
    
//ナビ部分呼び出し
    require_once 'nav.php';
?>
<main>
    <div class="error">
        <img src="img/shinyazangyou-hiyoko.png" alt="error" width="300px">
        <p>通信に失敗しました</p>
        <p>ログインしなおしてください</p>
        <p><a href='login.php'>ログインページ</a></p>
    </div>
</main>
<?php else: 

//ナビ部分呼び出し
require_once 'loginnav.php';

// ↓登録情報↓
        $namae = null;
        if(!isset($_POST["namae"]) || !strlen($_POST["namae"])):
            $errors["namae"] = "ニックネームを入力してください";
        elseif(strlen($_POST["namae"]) > 40):
            $errors["namae"] = "ニックネームが長すぎます";
        else:
            $namae = $_POST["namae"];
            $_SESSION['namae']=$_POST["namae"];
        endif;
        
        $sex = null;
        if(!isset($_POST["sex"])):
            $errors["sex"] = "性別を選択してください";
        else:
            $sex = $_POST["sex"];
        endif;

        $year = null;
        if(!isset($_POST["year"])):
            $errors["year"] = "生年月日の年を入力してください";
        else:
            $year = $_POST["year"];
        endif;
    
        $month = null;
        if(!isset($_POST["month"])):
            $errors["month"] = "生年月日の月を選択してください";
        elseif($_POST["year"] > date("Y") || $_POST["year"] < "1900"):
            $errors["birth"] = "正しい生年月日を選択してください";
            $month = $_POST["month"];
        elseif($_POST["year"] === date("Y")):
            if($_POST["month"] > date("m")):
                $errors[""] = "正しい生年月日を選択してください";
            endif;
            $month = $_POST["month"];
        else:
            $month = $_POST["month"];
        endif;
    
        $day = null;
        if(!isset($_POST["day"])):
            $errors["day"] = "生年月日の日を選択してください";
        elseif($_POST["month"] === date("m")):
            if($_POST["day"] > date("d")):
                $errors[""] = "正しい生年月日を選択してください";
            endif;
            $day = $_POST["day"];
        else:
            $day = $_POST["day"];
        endif;

        $height = null;
        if(!isset($_POST["height"]) || !strlen($_POST["height"])):
            $errors["height"] = "身長を入力してください";
        elseif(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["height"])):
            $errors["height"] = "身長の形式が違います";
        else:
            $height = $_POST["height"];
        endif;

        $goal_weight = null;
        if(!isset($_POST["goal_weight"]) || !strlen($_POST["goal_weight"])):
            $errors["goal_weight"] = "体重を入力してください";
        elseif(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["goal_weight"])):
            $errors["goal_weight"] = "体重の形式が違います";
        else:
            $goal_weight = $_POST["goal_weight"];
        endif;

        $goal_bodyfat = null;
        if(strlen($_POST["goal_bodyfat"])):
            if(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["goal_bodyfat"])):
                $errors["goal_bodyfat"] = "目標体脂肪の形式が違います";
            endif;
            $goal_bodyfat = $_POST["goal_bodyfat"];
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
        else:
            $goal_day = $_POST["goal_day"];
        endif;

    if(!checkdate($month, $day, $year)):
        $errors["checkdate"] = "存在しない日付です";
    endif;

        if(count($errors)):?> 
            <main>
                <ul class="error">
                    <li><img src="img/goukyu.png" alt="泣く" width="300px"></li>
<?php foreach($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?></li>
<?php endforeach; ?>
                    <li><a href="mypage.php">マイページへ戻る</a></li>
                </ul>
            </main>
    <?php else:
            //SQL実行(UPDATE)
            $sql = 'UPDATE `regist`INNER JOIN `schedule` ON `regist`.`id` = `schedule`.`regist_id` SET `namae`=:namae ,`sex`=:sex , `year`=:year , `month`=:month , `day`=:day , `height`=:height , `goal_weight`=:goal_weight , `goal_bodyfat`=:goal_bodyfat , `goal_year`=:goal_year , `goal_month`=:goal_month , `goal_day`=:goal_day WHERE `email` = :email';
            $stmt = $pdo -> prepare($sql);
            $stmt->bindParam(':namae',$namae);
            $stmt->bindParam(':sex',$sex);
            $stmt->bindParam(':year',$year);
            $stmt->bindParam(':month',$month);
            $stmt->bindParam(':day',$day);
            $stmt->bindParam(':height',$height);
            $stmt->bindParam(':goal_weight',$goal_weight);
            $stmt->bindParam(':goal_bodyfat',$goal_bodyfat);
            $stmt->bindParam(':goal_year',$goal_year);
            $stmt->bindParam(':goal_month',$goal_month);
            $stmt->bindParam(':goal_day',$goal_day);
            $stmt->bindParam(':email',$_SESSION['email']);
            $stmt->execute();
?>
    <main class="change">
        <img src="img/tanosimi-hiyoko.png" alt="踊るひよこ" width="300px">
        <p>変更しました</p>
        <p><a href='mypage.php'>マイページへ</a></p>
    </main>
<?php  
        $pdo = null;
        endif;
// フッター部分呼び出し
    endif; 
    require_once 'footer.php';
?>
</body>
</html>