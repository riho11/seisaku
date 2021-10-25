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
    <link rel="stylesheet" href="mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>ゆるゆるdiet｜退会画面</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'loginnav.php';

    if(isset($_SESSION["email"])):
?>
<h1><span style="color:red">退会</span>画面</h1>
    <form action="withdrawal1.php" method="post">
        <table class="form-table">
            <tr>
                <th>メールアドレス</th>
                <td><?php echo $_SESSION["email"]; ?></td>
            </tr>
            <tr>
                <th><label for="pass"><span class="hissu">必須</span>パスワード</label></th>
                <td><input type="password" id="pass" name="pass" placeholder="******" required></td>
                <td><span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span></td>
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
                </script>
                <td>(6～12文字以内)</td>
            </tr>
            <tr>
            <td colspan="3"><input class="btn btn-border" type="submit" value="退会"></td>
            </tr>
        </table>
    </form>
    
<?php else: ?>
	<p>ログインしなおしてください</p>
	<p><a href='login.php'>ログインページ</a></p>
<?php endif; ?>
        </main>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
    $pdo = null;
?>
    </div>
</body>
</html>