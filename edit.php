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
        //SQL実行(SELECT)
	    $stmt=$pdo->prepare("SELECT * FROM `regist` INNER JOIN `schedule` ON `regist`.`id` = `schedule`.`regist_id` WHERE `email`=:email");
        $stmt->bindParam(":email",$_SESSION["email"]);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
?>
    <main>
        <div id="form">
<!-- 編集フォーム -->
            <h1><span class="under">登録編集画面</span></h1>
            <form action="edit1.php" method="POST">
                <table class="form-table">
                    <tr>
                        <th><label for="namae">ニックネーム</label></th>
                        <td><input type="text" id="namae" name="namae" value="<?php echo $result["namae"]; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="sex">性別</label></th>
                        <?php if($result["sex"] === 0): ?>
                            <td><input type="radio" id="sex" name="sex" value="0" checked>男
                            <input type="radio" id="sex" name="sex" value="1">女</td>
                        <?php else: ?>
                            <td><input type="radio" id="sex" name="sex" value="0">男
                            <input type="radio" id="sex" name="sex" value="1" checked>女</td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><label for="birth">生年月日</label></th>
                        <td colspan="2">
                            <input type="text" id="year" name="year" value="<?php echo $result["year"]; ?>" required>
                            年
                            <select id="month" name="month">
                                <option value="<?php echo $result["month"]; ?>"><?php echo $result["month"]; ?></option>
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
                            <select id="day" name="day">    
                                <option value="<?php echo $result["day"]; ?>"><?php echo $result["day"]; ?></option>
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
                        <th><label for="height">身長</label></th>
                        <td><input type="text" id="height" name="height" value="<?php echo $result["height"]; ?>" required> cm</td>
                    </tr>
                    <tr>
                        <th><label for="goal_weight">目標体重</label></th>
                        <td><input type="text" id="goal_weight" name="goal_weight" value="<?php echo $result["goal_weight"]; ?>" required> kg</td>
                    </tr>
                    <tr>
                        <th><label for="goal_bodyfat">目標の体脂肪</label></th>
                        <td><input type="text" id="goal_bodyfat" name="goal_bodyfat" value="<?php echo $result["goal_bodyfat"]; ?>"> %</td>
                    </tr>
                    <tr>
                        <th><label for="goal_period">目標期間</label></th>
                        <td>
                            <select id="goal_year" name="goal_year">
                                <option value="<?php echo $result["goal_year"]; ?>"><?php echo $result["goal_year"]; ?></option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>
                            年
                            <select id="goal_month" name="goal_month">
                                <option value="<?php echo $result["goal_month"]; ?>"><?php echo $result["goal_month"]; ?></option>
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
                            <select id="goal_day" name="goal_day">    
                                <option value="<?php echo $result["goal_day"]; ?>"><?php echo $result["goal_day"]; ?></option>
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
                    <tr class="tr-center">
                        <td colspan="3"><input class="btn-border" type="submit" value="登録"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
<?php 
    $pdo = null;
    endif; 
// フッター部分呼び出し
    require_once 'footer.php';
?>
</body>
</html>