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
    <link rel="stylesheet" href="mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <title>ゆるゆるdiet｜編集画面</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'loginnav.php';
//DB呼び出し
    require_once 'db.php';
    
    if(isset($_SESSION["email"])):
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
                    <!-- <tr>
                        <th><label for="email">メールアドレス</label></th>
                        <td><input type="email" id="email" name="email" placeholder="sample@sample.jp"></td>
                    </tr> -->
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
                            <select id="year" name="year">
                                <option value="<?php echo $result["year"]; ?>"><?php echo $result["year"]; ?></option>
                                <option value="1920">1920</option>
                                <option value="1921">1921</option>
                                <option value="1922">1922</option>
                                <option value="1923">1923</option>
                                <option value="1924">1924</option>
                                <option value="1925">1925</option>
                                <option value="1926">1926</option>
                                <option value="1927">1927</option>
                                <option value="1928">1928</option>
                                <option value="1929">1929</option>
                                <option value="1930">1930</option>
                                <option value="1931">1931</option>
                                <option value="1932">1932</option>
                                <option value="1933">1933</option>
                                <option value="1934">1934</option>
                                <option value="1935">1935</option>
                                <option value="1936">1936</option>
                                <option value="1937">1937</option>
                                <option value="1938">1938</option>
                                <option value="1939">1939</option>
                                <option value="1940">1940</option>
                                <option value="1941">1941</option>
                                <option value="1942">1942</option>
                                <option value="1943">1943</option>
                                <option value="1944">1944</option>
                                <option value="1945">1945</option>
                                <option value="1946">1946</option>
                                <option value="1947">1947</option>
                                <option value="1948">1948</option>
                                <option value="1949">1949</option>
                                <option value="1950">1950</option>
                                <option value="1951">1951</option>
                                <option value="1952">1952</option>
                                <option value="1953">1953</option>
                                <option value="1954">1954</option>
                                <option value="1955">1955</option>
                                <option value="1956">1956</option>
                                <option value="1957">1957</option>
                                <option value="1958">1958</option>
                                <option value="1959">1959</option>
                                <option value="1960">1960</option>
                                <option value="1961">1961</option>
                                <option value="1962">1962</option>
                                <option value="1963">1963</option>
                                <option value="1964">1964</option>
                                <option value="1965">1965</option>
                                <option value="1966">1966</option>
                                <option value="1967">1967</option>
                                <option value="1968">1968</option>
                                <option value="1969">1969</option>
                                <option value="1970">1970</option>
                                <option value="1971">1971</option>
                                <option value="1972">1972</option>
                                <option value="1973">1973</option>
                                <option value="1974">1974</option>
                                <option value="1975">1975</option>
                                <option value="1976">1976</option>
                                <option value="1977">1977</option>
                                <option value="1978">1978</option>
                                <option value="1979">1979</option>
                                <option value="1980">1980</option>
                                <option value="1981">1981</option>
                                <option value="1982">1982</option>
                                <option value="1983">1983</option>
                                <option value="1984">1984</option>
                                <option value="1985">1985</option>
                                <option value="1986">1986</option>
                                <option value="1987">1987</option>
                                <option value="1988">1988</option>
                                <option value="1989">1989</option>
                                <option value="1990">1990</option>
                                <option value="1991">1991</option>
                                <option value="1992">1992</option>
                                <option value="1993">1993</option>
                                <option value="1994">1994</option>
                                <option value="1995">1995</option>
                                <option value="1996">1996</option>
                                <option value="1997">1997</option>
                                <option value="1998">1998</option>
                                <option value="1999">1999</option>
                                <option value="2000">2000</option>
                                <option value="2001">2001</option>
                                <option value="2002">2002</option>
                                <option value="2003">2003</option>
                                <option value="2004">2004</option>
                                <option value="2005">2005</option>
                                <option value="2006">2006</option>
                                <option value="2007">2007</option>
                                <option value="2008">2008</option>
                                <option value="2009">2009</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                            </select>
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
        endif; ?>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
</body>
</html>