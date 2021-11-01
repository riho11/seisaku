<!-- 新規登録画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/regist.css">
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
                            <th id="birth"><label for="birth"><span class="hissu">必須</span>生年月日</label></th>
                        </tr>
                        <tr>
                            <td class="birth" colspan="2">
                                <input type="text" id="year" name="year" required>
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
                            <td colspan="2"><input class="btn-border" type="submit" value="登録"></td>
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