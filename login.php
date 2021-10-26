<!-- ログイン画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="regist.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>ゆるゆるdiet｜ログイン</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'nav.php';
?>
        <main>
            <div id="form">
<!-- ログインフォーム -->
                <h1><span class="under">ログイン</span></h1>
                <form action="login1.php" method="POST">
                    <table class="form-table">
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