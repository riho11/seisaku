<!-- 新規登録画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="regist.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜新規会員登録</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
//関数呼び出し
    require_once 'function.php';
//DB呼び出し
    require_once 'db.php';
?>
    <main>
<?php
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
        $errors["pass"] = "ニックネームが長すぎます";
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

	if(count($errors)):
?>

		<ul>
<?php foreach($errors as $error): ?>
			<li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
			</li>
<?php endforeach; ?>
			<li><a href="regist.php">登録画面に戻る</a></li>
		</ul>
<?php else: ?>
        <main>
            <h1><span class="under">新規会員登録確認</span></h1>
            <table class="table-check">
                <tr>
                    <th>ニックネーム</th>
                    <td><?php echo htmlspecialchars($namae,ENT_QUOTES,"UTF-8"); ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?php echo htmlspecialchars($email,ENT_QUOTES,"UTF-8"); ?></td>
                </tr>
                <tr>
                    <!-- パスワード表示されないようにする -->
                    <th>パスワード</th>
                    <td><?php echo htmlspecialchars($pass,ENT_QUOTES,"UTF-8"); ?></td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td><?php gender($sex); ?></td>
                </tr>
                    <th>生年月日</th>
                    <td><?php echo htmlspecialchars($year,ENT_QUOTES,"UTF-8"); ?>年
                    <?php echo htmlspecialchars($month,ENT_QUOTES,"UTF-8"); ?>月
                    <?php echo htmlspecialchars($day,ENT_QUOTES,"UTF-8"); ?>日</td>
                </tr>
                <tr>
                    <th>身長</th>
                    <td><?php echo htmlspecialchars($height,ENT_QUOTES,"UTF-8"); ?>cm</td>
                </tr>
                <tr>
                    <th>現在の体重</th>
                    <td><?php echo htmlspecialchars($weight,ENT_QUOTES,"UTF-8"); ?>kg</td>
                </tr>
            </table>
            <form action="regist2.php" method="post">
                <input type="hidden" name="namae" value="<?php echo $namae; ?>">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="pass" value="<?php echo $pass; ?>">
                <input type="hidden" name="sex" value="<?php echo $sex; ?>">
                <input type="hidden" name="year" value="<?php echo $year; ?>">
                <input type="hidden" name="month" value="<?php echo $month; ?>">
                <input type="hidden" name="day" value="<?php echo $day; ?>">
                <input type="hidden" name="height" value="<?php echo $height; ?>">
                <input type="hidden" name="weight" value="<?php echo $weight; ?>">
                <table>
                    <tr>
                        <td colspan="2">以上で、お間違いないでしょうか？</td>
                    </tr>
                    <tr class="tr-center">
                        <td><input class="btn btn-border" type="submit" value="登録"></td>
                        <td><input class="btn btn-border" type="button" value="戻る" onclick="history.go(-1)"></td>
                    </tr>
                </table>
            </form>
        </main>
<?php endif; ?>
    </div>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
</body>
</html>