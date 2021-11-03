<?php
    session_start();
	session_regenerate_id(true);

//DB呼び出し
    require_once 'db.php';

    $errors = array();
    
    if($_SERVER["REQUEST_METHOD"] !== "POST"):
        $pdo = null;
        exit("直接アクセス禁止");
    endif;

// ↓登録情報↓
    $namae = null;
    if(!isset($_POST["namae"]) || !strlen($_POST["namae"])):
        $errors["namae"] = "ニックネームを入力してください";
    elseif(strlen($_POST["namae"]) > 40):
        $errors["namae"] = "ニックネームが長すぎます";
    else:
        $namae = $_POST["namae"];
    endif;

    $email = null;
    if(!isset($_POST["email"]) || !strlen($_POST["email"])):
        $errors["email"] = "メールアドレスを入力してください";
    elseif(strlen($_POST["email"]) > 40):
        $errors["email"] = "メールアドレスが長すぎます";
    elseif(!preg_match("/^[a-zA-Z0-9]+[a-zA-z0-9\._-]*@[a-zA-Z0-9_-]+.[a-zA-Z0-9\._-]+$/",$_POST["email"])):
        $errors["email"] = "メールアドレスの形式が誤っています";
    else:
//SQL実行(SELECT)
        $stmt=$pdo->prepare("SELECT `pass` FROM `regist` WHERE `email` =:email");
        $stmt->bindParam(':email',$_POST["email"]);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        if($result):
            $errors["email"] = "このメールアドレスは登録済みです";
        else:
            $email = $_POST["email"];
        endif;
        $stmt = null;
    endif;

    $pass = null;
    if(!isset($_POST["pass"]) || !strlen($_POST["pass"])):
        $errors["pass"] = "パスワードを入力してください";
    elseif(!preg_match("/^[a-zA-Z0-9]{6,12}$/",$_POST["pass"])):
        $errors["pass"] = "パスワードの形式が違います";
    else:
        $pass = $_POST["pass"];
        $hash = password_hash($pass,PASSWORD_DEFAULT);
    endif;

    $sex = null;
    if(!isset($_POST["sex"])):
        $errors["sex"] = "性別を選択してください";
    else:
        $sex = $_POST["sex"];
    endif;

    $year = null;
    if(!isset($_POST["year"])):
        $errors["year"] = "生年月日の年を選択してください";
    else:
        $year = $_POST["year"];
    endif;

    $month = null;
    if(!isset($_POST["month"])):
        $errors["month"] = "生年月日の月を選択してください";
    elseif( $_POST["year"] > date("Y") ||  $_POST["year"] < "1900"):
        $errors["birth"] = "正しい生年月日を選択してください";
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

    $weight = null;
    if(!isset($_POST["weight"]) || !strlen($_POST["weight"])):
        $errors["weight"] = "体重を入力してください";
    elseif(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["weight"])):
        $errors["weight"] = "体重の形式が違います";
    else:
        $weight = $_POST["weight"];
    endif;

    if(!checkdate($month, $day, $year)):
        $errors[""] = "存在しない日付です";
    endif;
    
    $_SESSION['email']=$_POST["email"];
    $_SESSION['pass']=$_POST["pass"];
    $_SESSION["namae"] = $_POST["namae"];

    if(count($errors)===0):
    //SQL実行
        $sql='INSERT INTO `regist`(`namae`,`email`,`pass`,`sex`,`year`,`month`,`day`,`height`,`weight`) VALUES(:namae,:email,:pass,:sex,:year,:month,:day,:height,:weight)';
        $stmt = $pdo -> prepare($sql);
        $stmt->bindParam(':namae',$namae);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':pass',$hash);
        $stmt->bindParam(':sex',$sex);
        $stmt->bindParam(':year',$year);
        $stmt->bindParam(':month',$month);
        $stmt->bindParam(':day',$day);
        $stmt->bindParam(':height',$height);
        $stmt->bindParam(':weight',$weight);
        $stmt->execute();
        $stmt = null;
    endif;
    $pdo = null;
?>
<?php if (count($errors)): ?>

<!-- 新規登録画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/regist.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜新規会員登録</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
?>
    <ul class="error">
			<li>
                <img src="img/goukyu.png" alt="泣く" width="300px">
			</li>
<?php foreach($errors as $error): ?>
        <li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8"); ?>
        </li>
<?php endforeach; ?>
        <li><a href="regist.php">登録画面に戻る</a></li>
    </ul>
<?php else:
header("Location: http://".$_SERVER['HTTP_HOST']."/seisaku/schedule.php");
endif;
//フッター部分呼び出し
    require_once 'footer.php';
?>
    </div>
</body>
</html>
