<?php
    session_start();
	session_regenerate_id(true);
?>
<!-- 退会画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/withdrawal.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>ゆるゆるdiet｜退会画面</title>
</head>
<body>
    <div id="wrapper">
<?php
    if(!isset($_SESSION["email"])):
//ナビ部分呼び出し
    require_once 'nav.php';
?>
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
<h1><span style="color:red">退会</span>画面</h1>
    <form action="withdrawal1.php" method="post">
        <table class="form-table">
            <tr>
                <th>メールアドレス</th>
                <td><?php echo $_SESSION["email"]; ?></td>
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
            <tr class="tr-center">
                <td colspan="2"><input class="btn-border" type="submit" value="退会する"></td>
            </tr>
        </table>
    </form>
</main>
<!-- フッター部分呼び出し -->
<?php
endif;
    require_once 'footer.php';?>
</div>
</body>
</html>