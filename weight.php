<?php
    session_start();
	session_regenerate_id(true);
?>
<!-- 体重記録 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="mypage.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <title>ゆるゆるdiet｜体重記録</title>
</head>
<body>
    <div id="wrapper">
<?php
//ナビ部分呼び出し
    require_once 'loginnav.php';
//DB呼び出し
    require_once 'db.php';

    if(isset($_SESSION["email"])):
?>
    <main>
        <div id="form">
<!-- 記録フォーム -->
            <h1><span class="under">体重記録</span></h1>
            <form action="weight.php" method="POST">
                <table class="form-table">
                    <tr>
                        <th><label for="record_weight"><span class="hissu">必須</span>体重</label></th>
                        <td><input type="text" id="record_weight" name="record_weight" placeholder="50" required> kg</td>
                    </tr>
                    <tr>
                        <th><label for="record_bodyfat">体脂肪</label></th>
                        <td><input type="text" id="record_bodyfat" name="record_bodyfat"  placeholder="20" > %</td>
                    </tr>
                    <tr>
                        <td colspan="3"><input class="btn btn-border" type="submit" value="登録"></td>
                    </tr>
                </table>
            </form>
        </div>
<?php
// 体重がセットされた時のみ実行↓
    if(isset($_POST["record_weight"]) > 0):
        $errors = array();

        $record_weight = null;
        if(strlen($_POST["record_weight"])):
            if(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["record_weight"])):
                $errors["record_weight"] = "体重の形式が違います";
            endif;
            $record_weight = $_POST["record_weight"];
        endif;

        $record_bodyfat = null;
        if(strlen($_POST["record_bodyfat"])):
            if(!preg_match("/^\d{1,3}\.?\d{1}$/",$_POST["record_bodyfat"])):
                $errors["record_bodyfat"] = "体脂肪の形式が違います";
            endif;
            $record_bodyfat = $_POST["record_bodyfat"];
        endif;
        
        if(count($errors)===0):
    //SQL実行(SELECT)
            $stmt=$pdo->prepare("SELECT `id`,`email` FROM `regist`WHERE `email`=:email");
            $stmt->bindParam(":email",$_SESSION["email"]);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
            if($_SESSION["email"] === $result["email"]):
                $date = new DateTime();
                $date = $date->format('Ymd');
                $stmt = $pdo -> prepare("SELECT COUNT(*) FROM`weight`WHERE `date`=:date");
                $stmt->bindParam(":date",$date);
                $stmt->execute();
                $count = $stmt->fetchColumn();
                $stmt = null;
                if($count === 0):
    //SQL保存
                    $sql='INSERT INTO `weight`(`date`,`record_weight`,`record_bodyfat`,`regist_id`) VALUES(:date,:record_weight,:record_bodyfat,:regist_id)';
                    $stmt = $pdo -> prepare($sql);
                    $stmt->bindParam(':date',$date);
                    $stmt->bindParam(':record_weight',$record_weight);
                    $stmt->bindParam(':record_bodyfat',$record_bodyfat);
                    $stmt->bindParam(':regist_id',$result["id"]);
                    $stmt->execute();
                    $stmt = null;
                else: ?>
                    <p>既に本日の体重は入力しました</p> 
                    <p>また明日入力お願いします</p> 
                    <style>.goal{ display: none; }</style><!-- 登録完了を非表示 -->
    <?php   endif;
            endif;
        endif;
        $pdo = null;
?>

<?php if (count($errors)): ?>
    <ul>
<?php foreach($errors as $error): ?>
        <li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8"); ?>
        </li>
<?php endforeach; ?>
    </ul>
<?php else:?>
    <p class="goal">登録完了しました</p>
<?php endif;
 endif;// 体重がセットされた時のみ実行↑
?>


<!-- 折れ線グラフ -->
        <div style="width:800px;" >
    <canvas id="chart"></canvas>
  </div>
  <script>
  var ctx = document.getElementById("chart");
  var myLineChart = new Chart(ctx, {
    // グラフの種類：折れ線グラフを指定
    type: 'line',
    data: {
      // x軸の各メモリ
      labels: ['1月', '2月', '3月', '4月', '5月', '6月', '7月','8月','9月','10月','11月','12月'],
      datasets: [
        {
          label: '体重',

          data: [27, 26, 31, 25, 30, 22, 27, 26],
          borderColor: "#ec4343",
          backgroundColor: "#00000000"
        },
        {
          label: '体脂肪',
          data: [18, 21, 24, 22, 21, 19, 18, 20],
          borderColor: "#2260ea",
          backgroundColor: "#00000000"
        }
      ],
    },
    options: {
      title: {
        display: true,
        text: '体重グラフ'
      },
      scales: {
        yAxes: [{
          ticks: {
            suggestedMax: 100,
            suggestedMin: 0,
            stepSize: 10,  // 縦メモリのステップ数
            callback: function(value, index, values){
              return  value +  'kg'  // 各メモリのステップごとの表記（valueは各ステップの値）
            }
          }
        }]
      },
    }
  });
  
  
  </script>

<?php else: ?>
	<p>ログインしなおしてください</p>
	<p><a href='login.php'>ログインページ</a></p>
<?php endif; ?>
        </main>
<!-- フッター部分呼び出し -->
<?php
    require_once 'footer.php';
?>
    </div>
</body>
</html>