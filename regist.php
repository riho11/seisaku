<!-- 新規登録画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="regist.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>ゆるゆるdiet｜新規会員登録</title>
</head>
<body>
    <div id="wrapper">
<!-- ナビ部分呼び出し -->
<?php
    require_once 'nav.php';
?>
        <main>
            <div id="form">
<!-- 新規登録フォーム -->
                <h1><span class="under">新規会員登録</span></h1>
                <form action="regist1.php" method="POST">
                    <table class="form-table">
                        <tr>
                            <th><label for="namae"><span class="hissu">必須</span>ニックネーム</label></th>
                            <td><input type="text" id="namae" name="namae" placeholder="山田太郎" required></td>
                        </tr>
                        <tr>
                            <th><label for="email"><span class="hissu">必須</span>メールアドレス</label></th>
                            <td><input type="email" id="email" name="email" placeholder="sample@sample.jp" required></td>
                        </tr>
                        <tr>
                            <th><label for="pass"><span class="hissu">必須</span>パスワード</label></th>
                            <td><input type="password" id="pass" name="pass" placeholder="******" required>
                            <div class="annotation"><span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
<!-- パスワード表示、非表示設定 -->
                            <script>
                                function pushHideButton() {
                                    var txtPass = document.getElementById("pass");
                                    var btnEye = document.getElementById("buttonEye");
                                    if (txtPass.type === "text") {
                                    txtPass.type = "password";
                                    btnEye.className = "fa fa-eye";
                                    } else {
                                    txtPass.type = "text";
                                    btnEye.className = "fa fa-eye-slash";
                                    }
                                }
                            </script>(6～12文字以内)</div></td>
                        </tr>
                    <!-- パスワード(確認)：<input type="password" name="pass2" >確認の為、同じパスワードを入力してください。<br> -->
                        <tr>
                            <th><label for="sex"><span class="hissu">必須</span>性別</label></th>
                            <td><input type="radio" id="sex" name="sex" value="0">男
                            <input type="radio" id="sex" name="sex" value="1">女
                            <div class="annotation">※診断に必要な項目です。</div></td>
                        </tr>
                        <tr>
                            <th><label for="birth"><span class="hissu">必須</span>生年月日</label></th>
                            <td>
                                <select id="year" name="year" required>
                                    <option value="" disabled selected style="display:none;">-</option>
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
                                <select id="month" name="month" required>
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
                                <select id="day" name="day" required>    
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
                            <th><label for="height"><span class="hissu">必須</span>身長</label></th>
                            <td><input type="text" id="height" name="height" placeholder="160" required> cm</td>
                        </tr>
                        <tr>
                            <th><label for="weight"><span class="hissu">必須</span>現在の体重</label></th>
                            <td><input type="text" id="weight" name="weight"  placeholder="50" required> kg</td>
                        </tr>
                        <tr class="tr-center">
                            <td colspan="2"><input class="btn btn-border" type="submit" value="登録"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
            
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
    </div>
</body>
</html>