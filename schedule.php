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
//DB呼び出し
    require_once 'db.php';

// Warningエラーもcatchする
    function error_handler($severity, $message, $filename, $lineno) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }
    set_error_handler('error_handler');

try { //既に画像が書き込まれた場合、プライマリーキーのためエラーが出るが例外処理をさせる
// SQL取得(registを取得)、画像を自動で保存
    $stmt=$pdo->prepare("SELECT * FROM `regist` WHERE `email`=:email");
    $stmt->bindParam(":email",$_SESSION["email"]);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $_SESSION["id"] = $result["id"];
    if($_SESSION["email"] === $result["email"]): 
        $referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : null;
        $target_host = '/seisaku/regist1.php';
        if( parse_url( $referer )["path"] === $target_host ):
            $date = date('Y-m-d H:i:s');
            $img = "img/sample.png";
            $sql='INSERT INTO `img`(`created_at`,`img`,`regist_id`) VALUES(:created_at,:img,:regist_id)';
            $stmt = $pdo -> prepare($sql);
            $stmt->bindParam(':created_at',$date);
            $stmt->bindParam(':img',$img);
            $stmt->bindParam(':regist_id',$result["id"]);
            $stmt->execute();
            echo "<p>登録完了！</p>";
        endif;
    endif;
} catch(Exception $e) {
    // 何も表示しない
    }
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
    <p>目標を設定しましょう。</p>
    <div id="form">
<!-- 新規登録フォーム -->
        <h1><span class="under">目標設定</span></h1>
        <form action="schedule1.php" method="POST">
            <table class="form-table">
                <tr>
                    <th><label for="goal_weight"><span class="hissu">必須</span>目標体重</label></th>
                    <td class="goal_weight"><input type="text" id="goal_weight" name="goal_weight" placeholder="50" required> kg</td>
                </tr>
                <tr>
                    <th id="goal_period"><label for="goal_period"><span class="hissu">必須</span>目標期間</label></th>
                </tr>
                <tr>
                    <td class="goal_period" colspan="2">
                        <select id="goal_year" name="goal_year" required>
                            <option value="" disabled selected style="display:none;">-</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                        年
                        <select id="goal_month" name="goal_month" required>
                            <option value="" disabled selected style="display:none;">-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        月
                        <select id="goal_day" name="goal_day" required>    
                            <option value="" disabled selected style="display:none;">-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                        </select>
                        日
                    </td>
                </tr>
                <tr>
                    <th><label for="bodyfat">現在の体脂肪</label></th>
                    <td><input type="text" id="bodyfat" name="bodyfat"  placeholder="50" > %</td>
                </tr>
                <tr>
                    <th><label for="goal_bodyfat">目標の体脂肪</label></th>
                    <td><input type="text" id="goal_bodyfat" name="goal_bodyfat" placeholder="20"> %</td>
                </tr>
                <tr class="tr-center">
                    <td colspan="2"><input class="btn-border" type="submit" value="登録"></td>
                </tr>
            </table>
        </form>
    </div>
</main>

<!-- フッター部分呼び出し -->
<?php
endif;
require_once 'footer.php';
?>
</div>
</body>
</html>