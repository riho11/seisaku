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
    <link rel="stylesheet" href="css/mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <title>ゆるゆるdiet｜マイページ</title>
</head>
<body>
    <div id="wrapper">
<?php
// DB呼び出し
    require_once 'db.php';
// 関数呼び出し
    require_once 'function.php';
    
    if(!isset($_SESSION["email"])):
    
//ナビ部分呼び出し
    require_once 'nav.php';
?>
    <style>.error-name{ display:none;}</style>
<div class="error">
    <img src="img/shinyazangyou-hiyoko.png" alt="error" width="300px">
    <p>通信に失敗しました</p>
    <p>ログインしなおしてください</p>
    <p><a href='login.php'>ログインページ</a></p>
</div>
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
    <style>.firsticon{ display:none;}.error-name{padding-right: 50px;}main{padding: 50px; text-align:center;}</style>
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
<?php   exit();
        }

    if($_SESSION["email"] === $result["email"]):
?>
        <div class="topmy">
            <h1>マイページ</h1>
            <p><a href="edit.php">編集</a>
            <a href="withdrawal.php">退会</a></p>
        </div>
<!-- 残り日数計算 -->
        <table class="goaldate">
            <tr>
                <th><?php echo $result["goal_year"] . '年' . $result["goal_month"] . '月' . $result["goal_day"] . '日'; ?>までにやせる！</th>
            </tr>
            <tr>
                <td>
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
                </td>
            </tr>
        </table>

<!-- 体重、体脂肪の現在などの記録 -->
        <table class="record-table">
            <tr>
                <th></th>
                <th>体重</th>
                <th>体脂肪</th>
            </tr>
            <tr>
                <td>初期　</td>
                <td><?php echo $result["weight"] . "kg"; ?></td>
                <td><?php echo null($result["bodyfat"]); ?></td>
            </tr>
            <tr>
                <td>現在　</td>
                <td>
            <?php 
                try { // 現在の体重が設定されていない場合、例外処理で初期の体重を記載
                    // SQL実行(weight選択)
                    $stmt=$pdo->prepare("SELECT * FROM `weight` WHERE `regist_id`=:regist_id ORDER BY date DESC");
                    $stmt->bindParam(":regist_id",$result["regist_id"]);
                    $stmt->execute();
                    $record=$stmt->fetch(PDO::FETCH_ASSOC);
                    $stmt = null;
                     echo $record["record_weight"] . "kg";
                 } catch(Exception $e) {
                     echo $result["weight"] . "kg";
                 } ?></td>
                 <td>
                <?php
                try{ // 現在の体脂肪が記録されていない場合、初期の体脂肪を記載
                    if(is_null($record["record_bodyfat"])):
                        echo null($result["bodyfat"]);
                    else:
                        echo $record["record_bodyfat"] . " ％";
                    endif;
                } catch(Exception $e){
                    echo null($result["bodyfat"]);
                } ?></td>
            </tr>
            <tr>
                <td>目標　</td>
                <td><?php echo $result["goal_weight"] . "kg"; ?></td>
                <td><?php echo null($result["goal_bodyfat"]); ?></td>
            </tr>
            <tr class="goal-table">
                <td>目標まで残り</td>
                <td>
                <?php 
                try{ // 目標までの残り体重。現在の体重が設定されていない場合、例外処理で初期の体重を記載
                    weight_difference($record["record_weight"],$result["goal_weight"]);
                } catch(Exception $e){
                    weight_difference($result["weight"],$result["goal_weight"]);
                } ?></td>
                <td>
                <?php
                // 体脂肪の残り目標
                if(is_null($result["goal_bodyfat"])):
                    echo "目標が未設定です";
                elseif(isset($record["record_bodyfat"])):
                    bodyfat_difference($record["record_bodyfat"],$result["goal_bodyfat"]);
                elseif(isset($result["bodyfat"])):
                    bodyfat_difference($result["bodyfat"],$result["goal_bodyfat"]);
                elseif(is_null($result["bodyfat"])):
                    echo "体脂肪が未設定です";
                endif;?></td>
            </tr>
        </table>


    
        <h1 class="myh1">私のプロフィール</h1>
            <table class="mytable">
                <tr>
                    <th>ニックネーム</th>
                    <td><?php echo $result["namae"]; ?></td>
                    <th>ＢＭＩ</th>
                    <td>
                    <?php
                    // BMI診断
                    try{ // 現在の体重が記録されていない場合、初期の体重にて計算
                        $bmisum = bmi($record["record_weight"],$result["height"]);
                        echo round($bmisum,1) ."";
                        bmi_judgment(round($bmisum,1));
                    } catch(Exception $e){
                        $bmisum = bmi($result["weight"],$result["height"]);
                        echo round($bmisum,1);
                        bmi_judgment(round($bmisum,1));
                    }?>
                    </td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td><?php gender($result["sex"]); ?></td>
                    <th>適正体重</th>
                    <td><?php
                    // 適正体重を四捨五入表示
                    echo Appropriate_weight($result["height"]) . "kg";?></td>
                </tr>
                <tr>
                    <th rowspan="2">生年月日</th>
                    <td><?php echo $result["year"] ."年" . $result["month"] ."月". $result["day"] ."日"; ?></td>
                    <th>美容体重</th>
                    <td><?php
                    echo "" . beauty_weight($result["height"]) . "kg";?></td>
                </tr>
                <tr>
                    <td>現在の年齢　<?php 
                    $age = current_age($result["month"],$result["day"],$result["year"]);
                    echo $age; ?></td>
                    <th>モデル体重</th>
                    <td><?php
                    echo "" . model_weight($result["height"]) . "kg";?></td>
                </tr>
                <tr>
                    <th>身長</th>
                    <td><?php echo $result["height"] . "cm"; ?></td>
                    <th></th>
                    <td></td>
                </tr>
            </table>
            
            <p class="basics">あなたの現在の基礎代謝量は<br>
                <span><?php
                // 基礎代謝(国立健康・栄養研究所の式)
                    $age = current_age($result["month"],$result["day"],$result["year"]);
                    try { // 現在の体重が設定されていない場合、例外処理で初期の体重を記載
                        if($result["sex"] == 0):
                            echo basicsman($record["record_weight"],$result["height"],$age) . "kcal/日";
                        elseif($result["sex"] == 1):
                            echo basicswoman($record["record_weight"],$result["height"],$age) . "kcal/日";
                        endif;
                    } catch(Exception $e) {
                        if($result["sex"] == 0):
                            echo basicsman($result["weight"],$result["height"],$age) . "kcal/日";
                        elseif($result["sex"] == 1):
                            echo basicswoman($result["weight"],$result["height"],$age) . "kcal/日";
                        endif;
                    }
            ?></span>
            です。</p>
<?php
    endif;
    $pdo=null;
?>
        </main>
<?php
// フッター部分呼び出し
endif;
require_once 'footer.php';
?>
    </div>
</body>
</html>