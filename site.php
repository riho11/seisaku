<!-- サイトについて -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/site.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>ゆるゆるdiet｜サイトについて</title>
</head>
<body>
    <div id="wrapper">
<?php    
if(!isset($_SESSION["email"])):  
//ナビ部分呼び出し
    require_once 'nav.php';
// サイトの中身呼び出し
    require_once 'site.html';
else:     
//ナビ部分呼び出し
require_once 'loginnav.php';
// サイトの中身呼び出し
require_once 'site.html';

// フッター部分呼び出し
endif;
    require_once 'footer.php';
?>
    </div>
</body>
</html>