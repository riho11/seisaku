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
        
        if(count($errors) === 0):
    //SQL実行(SELECT)
          $stmt=$pdo->prepare("SELECT `id`,`email` FROM `regist` WHERE `email`=:email");
          $stmt->bindParam(":email",$_SESSION["email"]);
          $stmt->execute();
          $result=$stmt->fetch(PDO::FETCH_ASSOC);
          $stmt = null;
          if($_SESSION["email"] === $result["email"]):
            // 同じ日付がないか確認
            $date = new DateTime();
            $date = $date->format('Ymd');
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM`weight` WHERE `regist_id`=:regist_id AND `date`=:date");
            $stmt->bindParam(":regist_id",$result["id"]);
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


<?php // 日々の体重を取得
    $stmt=$pdo -> prepare("SELECT * FROM `weight` WHERE `regist_id`=:regist_id ORDER BY `date` ASC");
    $stmt->bindParam(':regist_id',$_SESSION["id"]);
    $stmt->execute();
    $response=$stmt->fetchall(PDO::FETCH_ASSOC);
    $stmt = null;
?>


<!-- 押したら表示されるボタン-->
<form action="weight.php" method="POST">
    <button name="week" value="一週間">一週間</button>
    <button name="month" value="一カ月">一カ月</button>
    <button name="year" value="一年">一年</button>
</form>
<p>※記録した日のみが表示されます</p>
<p>未登録は０になります</p>


<!-- 折れ線グラフ -->
        <div style="width:800px;" >
    <canvas id="chart"></canvas>
  </div>

<!-- 一週間表示 -->
<?php if(isset($_POST["week"])): ?>
  <script>
  var ctx = document.getElementById("chart");
  var myLineChart = new Chart(ctx, {
    // グラフの種類：折れ線グラフを指定
    type: 'line',
    data: {
      // x軸の各メモリ 
      labels: [<?php 
$week_past = date("Y-m-d",strtotime("-6 day"));
foreach($response as $array):
  if($week_past <= $array["date"]):
    $str = explode("-",$array["date"]);
    echo $str[2]. ',';
  endif;
endforeach;
?>],
      datasets: [
        {
          label: '体重',
          spanGaps: true, // 欠損値を補完
          data: [<?php
$week_past = date("Y-m-d",strtotime("-6 day"));
foreach($response as $array):
  if($week_past <= $array["date"]):
    echo $array["record_weight"] . ',';
  endif;
endforeach;
?>],
          lineTension: 0,
          borderColor: "#ec4343",
          backgroundColor: "#00000000"
        },
        {
          label: '体脂肪',
          spanGaps: true, // 欠損値を補完
          data: [ // 体脂肪取得
<?php
$week_past = date("Y-m-d",strtotime("-6 day"));
foreach($response as $array):
  if($week_past <= $array["date"]):
    echo $array["record_bodyfat"] . ',';
  endif;
endforeach; 
?>],
          lineTension: 0,
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

<!-- 一カ月表示 -->
<?php elseif(isset($_POST["month"])): ?>
  <script>
  var ctx = document.getElementById("chart");
  var myLineChart = new Chart(ctx, {
    // グラフの種類：折れ線グラフを指定
    type: 'line',
    data: {
      labels: [ // 日にち取得
<?php 
$month_past = date("Y-m-d",strtotime("-1 month"));
foreach($response as $array):
  if($month_past < $array["date"]):
    $str_date = explode("-",$array["date"]);
    echo $str_date[1].".".$str_date[2]. ',';
  endif;
endforeach;
?>],
      datasets: [
        {
          label: '体重',
          spanGaps: true, // 欠損値を補完
          data: [ // 体重取り出し
<?php
$month_past = date("Y-m-d",strtotime("-1 month"));
foreach($response as $array):
  if($month_past < $array["date"]):
    echo $array["record_weight"] . ',';
  endif;
endforeach;
?>],
          lineTension: 0,
          borderColor: "#ec4343",
          backgroundColor: "#00000000"
        },
        {
          label: '体脂肪',
          spanGaps: true, // 欠損値を補完
          data: [ // 体脂肪取得(NULLの時０を代入)
<?php
$month_past = date("Y-m-d",strtotime("-1 month"));
foreach($response as $array):
  if($month_past < $array["date"]):
    echo $array["record_bodyfat"] . ',';
  endif;
endforeach; 
?>],
          lineTension: 0,
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

<!-- 一年表示 -->
<?php elseif(isset($_POST["year"])): ?>
  <script>
  var ctx = document.getElementById("chart");
  var myLineChart = new Chart(ctx, {
    // グラフの種類：折れ線グラフを指定
    type: 'line',
    data: {
      // x軸の各メモリ 
      labels: [ // 日にち取得
<?php 
  $year_past = date("Y-m-d",strtotime("-1 year"));
  foreach($response as $array):
    if($year_past < $array["date"]):
      $str_date = explode("-",$array["date"]);
      echo $str_date[1].".".$str_date[2]. ',';
    endif;
  endforeach;
?>],
      datasets: [
        {
          label: '体重',
          spanGaps: true, // 欠損値を補完        
          data: [ // 体重取り出し
<?php
$year_past = date("Y-m-d",strtotime("-1 year"));
foreach($response as $array):
  if($year_past < $array["date"]):
    echo $array["record_weight"] . ',';
  endif;
endforeach;
?>],
          lineTension: 0,
          borderColor: "#ec4343",
          backgroundColor: "#00000000"
        },
        {
          label: '体脂肪',
          spanGaps: true, // 欠損値を補完   
          data: [ // 体脂肪取得
<?php
$year_past = date("Y-m-d",strtotime("-1 year"));
foreach($response as $array):
  if($year_past < $array["date"]):
    echo $array["record_bodyfat"] . ',';
  endif;
endforeach;
?>],
          lineTension: 0,
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

<?php endif; ?>

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