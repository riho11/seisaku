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
    <link rel="stylesheet" href="mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜マイページ</title>
</head>
<body>
    <div id="wrapper">
<?php
// ナビ部分呼び出し
    require_once 'loginnav.php';
// DB呼び出し
    require_once 'db.php';
// 関数呼び出し
    require_once 'function.php';
    
    if(isset($_SESSION["email"])):
?>
    <main>
        <h1>マイページ</h1>
    <?php
    // Warningエラーもcatchする
    function error_handler($severity, $message, $filename, $lineno) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }
    set_error_handler('error_handler');
    try { // 目標設定がされていない場合、例外処理で目標設定画面へ
// SQL実行(scheduleとregistを選択)
            $sql = "SELECT * FROM `schedule` INNER JOIN `regist` ON schedule . regist_id = regist . id INNER JOIN `weight` ON  WHERE `email`=:email";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":email",$_SESSION["email"]);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
            if($result["regist_id"] === $result["id"]):
                // 目標未設定の場合、Warningエラーを発生させる
            endif;
        } catch(Exception $e) {
            echo "目標が設定されていません<br>";
            echo "目標を設定しましょう！<br>";
            echo "<p><a href='schedule.php'>目標設定へ</a></p>";?>
</main>
<?php
        require_once 'footer.php';?>
    </div>
</body>
</html>
<?php       exit();
        }

    if($_SESSION["email"] === $result["email"]):
    ?>
            <table border="1">
                <tr>
                    <th>ニックネーム</th>
                    <td><?php echo $result["namae"]; ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?php echo $result["email"]; ?></td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td><?php gender($result["sex"]); ?></td>
                </tr>
                <tr>
                    <th>生年月日</th>
                    <td><?php echo $result["year"] ."年" . $result["month"] ."月". $result["day"] ."日"; ?></td>
                </tr>
                <tr>
                    <th>身長</th>
                    <td><?php echo $result["height"] . "cm"; ?></td>
                </tr>
                <tr>
                    <th rowspan="3">体重</th>
                    <td>初期　<?php echo $result["weight"] . "kg"; ?></td>
                </tr>
                <tr>
                    <td>目標　<?php echo $result["goal_weight"] . "kg"; ?></td>
                </tr>
                <tr>
                    <td><?php weight_difference($result["weight"],$result["goal_weight"]);?></td>
                </tr>
                <tr>
                    <th rowspan="3">体脂肪</th>
                    <td>初期　<?php echo null($result["bodyfat"]); ?></td>
                </tr>
                <tr>
                    <td>目標　<?php echo null($result["goal_bodyfat"]); ?></td>
                </tr>
                <tr>
                    <td><?php if(is_null($result["bodyfat"]) || is_null($result["goal_bodyfat"])):
                                        echo "体脂肪が未設定です";
                                    else:
                                        bodyfat_difference($result["bodyfat"],$result["goal_bodyfat"]); 
                                    endif; ?></td>
                </tr>

<!-- 残り日数計算 -->
                <tr>
                    <td>目標日</td>
                    <td><?php echo $result["goal_year"] . '-' . $result["goal_month"] . '-' . $result["goal_day"]; ?></td>
                </tr>
                <tr><td colspan="2">
                    <?php
                    $date1 = new DateTime($result["goal_year"] . '-' . $result["goal_month"] . '-' . $result["goal_day"] . '24:0:0'); 
                    $date2 = new DateTime(); 
                    $diff = $date2->diff($date1); // 目標と現在の差分を求める
                    if ($diff->invert == 1 ):
                        echo "過ぎています";
                    elseif($diff->days == 1):
                        echo "明日です";
                    elseif($diff->days == 0):
                        echo "本日です";
                    else:
                        echo $diff->format('残り%a日');
                    endif;
                    ?>
                </td></tr>
            </table>
<?php
// BMI診断

 // 画像表示
            $stmt=$pdo->prepare("SELECT `img` FROM `img`WHERE `regist_id`=:regist_id");
            $stmt->bindParam(":regist_id",$result["regist_id"]);
            $stmt->execute();
            $img=$stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
?>
    <p><img src="<?php echo $img["img"]; ?>" alt="設定画像"  width="30%" height="30%"></p>
    <?php
        endif;
        $pdo=null;
    ?>
    <p><a href="edit.php">編集</a></p>
    <p><a href="edit.php">パスワードの変更</a></p>
    <p><a href="edit.php">メールアドレスの変更</a></p>
    <p><a href="img.php">画像変更</a></p>
<br>
	<p><a href='logout.php'>ログアウト</a></p>
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