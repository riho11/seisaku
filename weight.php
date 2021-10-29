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
    <link rel="stylesheet" href="weight.css">
    <link rel="shortcut icon" href="img/taiju.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <title>ゆるゆるdiet｜体重記録</title>
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
<?php
// Warningエラーもcatchする
function error_handler($severity, $message, $filename, $lineno) {
throw new ErrorException($message, 0, $severity, $filename, $lineno);
}
set_error_handler('error_handler');
try { // 目標設定がされていない場合、例外処理で目標設定画面へ
// SQL実行(scheduleとregistを選択)
      $sql = "SELECT * FROM `regist` INNER JOIN `schedule` ON regist . id = schedule . regist_id  WHERE `email`=:email";
      $stmt=$pdo->prepare($sql);
      $stmt->bindParam(":email",$_SESSION["email"]);
      $stmt->execute();
      $result=$stmt->fetch(PDO::FETCH_ASSOC);
      $stmt = null;
      if($result["regist_id"] === $result["id"]):
          // 目標未設定の場合、Warningエラーを発生させる
      endif;
  } catch(Exception $e) {?>
  <!-- アイコンを非表示 -->
    <style>.firsticon{ display:none;}.error-name{padding-right: 50px;}main{padding: 50px;}</style>
    <img src="img/tumi-piyo.png" alt="泣く" width="300px"><br><?php
      echo "目標が設定されていません<br>";
      echo "目標を設定しましょう！<br>";
      echo "<p><a href='schedule.php'>目標設定へ</a></p>";?>
    </main>
<?php
    require_once 'footer.php';?>
</div>
</body>
</html>
<?php    exit();
    }?>
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
                        <th class="bodyfat"><label for="record_bodyfat">体脂肪</label></th>
                        <td><input type="text" id="record_bodyfat" name="record_bodyfat"  placeholder="20" > %</td>
                    </tr>
                    <tr class="tr-center">
                        <td colspan="2"><input class="btn-border" type="submit" value="登録"></td>
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
		<ul class="error">
			<li>
          <img src="img/goukyu.png" alt="泣く" width="300px">
			</li>
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


<?php 
// 日々の体重を取得
  $stmt=$pdo -> prepare("SELECT * FROM `weight` WHERE `regist_id`=:regist_id ORDER BY `date` ASC");
  $stmt->bindParam(':regist_id',$_SESSION["id"]);
  $stmt->execute();
  $response=$stmt->fetchall(PDO::FETCH_ASSOC);
  $stmt = null;
// 初期の体重、体脂肪
  $sql = "SELECT `weight`,`bodyfat` FROM `regist` INNER JOIN `schedule` ON regist . id = schedule . regist_id  WHERE `email`=:email";
  $stmt=$pdo->prepare($sql);
  $stmt->bindParam(":email",$_SESSION["email"]);
  $stmt->execute();
  $initial_value=$stmt->fetch(PDO::FETCH_ASSOC);
  $stmt = null;
?>

<!-- 押したら表示されるボタン-->
<form action="weight.php" method="POST">
    <button name="week" value="一週間">一週間</button>
    <button name="month" value="一カ月">一カ月</button>
</form>
<p>※初期値は登録した場合のみ表示されます</p>


<!-- 折れ線グラフ -->
    <div class="chart">
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
echo "'" ."初期体重" ."'". ',';
// 1週間分の日付取得
$week_past = date("Y-m-d",strtotime("-6 day"));
$week_last = date("Y-m-d",strtotime("last day of previous month")); //先月の末尾取得
$str_past = explode("-",$week_past);
$str_last = explode("-",$week_last);
if(date("d") > $str_past[2]):
// 今日の日付より１週間前の日付が小さい場合(月をまたがない場合)
  for($i = $str_past[2]; $i <= date("d"); $i++){
    echo "'" .$i ."'". ',';
  }
else:
// 今日の日付より１週間前の日付が大きい場合(月をまたぐ場合)
  for($i = $str_past[2]; $i <= $str_last[2]; $i++){
    echo "'" .$i ."'". ',';
  }
  for($i = 1; $i <= date("d"); $i++){
    echo "'" .$i ."'". ',';
  }
endif;
?>],
      datasets: [
        {
          label: '体重',
          spanGaps: true, // 欠損値を補完
          data: [<?php 
// 初期値
echo $initial_value["weight"] . ',';
// １週間以内にDBにある日付を取得
$exist_date=Array();
$week_past = date("Y-m-d",strtotime("-6 day"));
foreach($response as $array):
  if($week_past <= $array["date"]):
    array_push($exist_date,$array["date"]);
  endif;
endforeach;
// 現在から１週間分の日付を取得
$every_date = Array();
$week_past = date("Y-m-d",strtotime("-6 day"));
$week_last = date("Y-m-d",strtotime("last day of previous month")); //先月の末尾取得
$str_past = explode("-",$week_past);
$str_last = explode("-",$week_last);
$Ym = date("Y-m-");
  if(date("d") > $str_past[2]):
    for($i = $str_past[2]; $i <= date("d"); $i++){
      array_push($every_date,$Ym .$i);
    }
  else:
    for($i = $str_past[2]; $i <= $str_last[2]; $i++){
      array_push($every_date,$Ym .$i);
    }
    for($i = 1; $i <= date("d"); $i++){
      array_push($every_date,$Ym .$i);
    }
  endif;
// DBに存在しない日を取得、配列の最後にNULLを追加
$diff=array_diff($every_date, $exist_date);
$null=Array();
foreach($diff as $dif):
  array_push($null,$dif."-"."'"."NULL"."'");
endforeach;
// DBに存在する日を取得、配列の最後に体重を追加
$exist=Array();
$week_past = date("Y-m-d",strtotime("-6 day"));
foreach($response as $array):
if($week_past <= $array["date"]):
  array_push($exist,$array["date"] . '-'.$array["record_weight"]);
endif;
endforeach;
// 一つの配列に入れ、若い日付に直す。体重の値のみ取り出す。
$merge=array_merge($exist,$null);
sort($merge);
foreach($merge as $me):
  $str_weight = explode("-",$me);
  echo $str_weight[3]. ',';
endforeach;
?>],
          lineTension: 0,
          borderColor: "#ec4343",
          backgroundColor: "#00000000"
        },
        {
          label: '体脂肪',
          spanGaps: true, // 欠損値を補完
          data: [<?php 
echo $initial_value["bodyfat"] . ',';
// DBに存在する日を取得、配列の最後に体脂肪を追加
$exist=Array();
$week_past = date("Y-m-d",strtotime("-6 day"));
foreach($response as $array):
if($week_past <= $array["date"]):
  array_push($exist,$array["date"] . '-'.$array["record_bodyfat"]);
endif;
endforeach;
// 一つの配列に入れ、若い日付に直す。体脂肪の値のみ取り出す。
$merge=array_merge($exist,$null);
sort($merge);
foreach($merge as $me):
  $str_weight = explode("-",$me);
  echo $str_weight[3]. ',';
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
      labels: [<?php 
echo "'" ."初期体重" ."'". ',';
// １カ月分の日付取得
$month_past = date("Y-n-d",strtotime("-1 month"));
$month_last = date("Y-n-d",strtotime("last day of previous month")); //先月の末尾取得
$str_past = explode("-",$month_past);
$str_last = explode("-",$month_last);
$now_month = date("n");
// 今日の日付より１カ月前の日付が大きい場合(月をまたぐ場合)
  for($i = $str_past[2]; $i <= $str_last[2]; $i++){
    echo "'" .$str_last[1].".".$i ."'". ',';
  }
  for($i = 1; $i <= date("d"); $i++){
    echo "'" .$now_month.".".$i ."'". ',';
  }?>],
      datasets: [
        {
          label: '体重',
          spanGaps: true, // 欠損値を補完
          data: [ <?php 
// 初期値
echo $initial_value["weight"] . ',';
// １カ月以内にDBにある日付を取得
$exist_month=Array();
$month_past = date("Y-m-d",strtotime("-1 month"));
foreach($response as $array):
  if($month_past <= $array["date"]):
    array_push($exist_month,$array["date"]);
  endif;
endforeach;
// １カ月分の日付取得
$every_month = Array();
$month_past = date("Y-m-d",strtotime("-1 month"));
$month_last = date("Y-m-d",strtotime("last day of previous month")); //先月の末尾取得
$str_past = explode("-",$month_past);
$str_last = explode("-",$month_last);
$Ym = date("Y-m-");
$Ym_lastmonth = date("Y-") . $str_last[1] ."-";
// 今日の日付より１カ月前の日付が大きい場合(月をまたぐ場合)
  for($i = $str_past[2]; $i <= $str_last[2]; $i++){
    array_push($every_month,$Ym_lastmonth.$i);
  }
  for($i = 01; $i <= date("d"); $i++){
    $sprintf = sprintf("%02d",$i);
    array_push($every_month,$Ym.$sprintf);
  }
// DBに存在しない日を取得、配列の最後にNULLを追加
$diff=array_diff($every_month, $exist_month);
$null=Array();
foreach($diff as $dif):
  array_push($null,$dif."-"."'"."NULL"."'");
endforeach;
// DBに存在する日を取得、配列の最後に体重を追加
$exist=Array();
foreach($response as $array):
if($month_past <= $array["date"]):
  array_push($exist,$array["date"] . '-'.$array["record_weight"]);
endif;
endforeach;
// 一つの配列に入れ、若い日付に直す。体重の値のみ取り出す。
$merge=array_merge($exist,$null);
sort($merge);
foreach($merge as $me):
  $str_weight = explode("-",$me);
  echo $str_weight[3]. ',';
endforeach;
?>],
          lineTension: 0,
          borderColor: "#ec4343",
          backgroundColor: "#00000000"
        },
        {
          label: '体脂肪',
          spanGaps: true, // 欠損値を補完
          data: [ <?php 
// 初期値
echo $initial_value["bodyfat"] . ',';
// DBに存在する日を取得、配列の最後に体脂肪を追加
$exist=Array();
foreach($response as $array):
if($month_past <= $array["date"]):
  array_push($exist,$array["date"] . '-'.$array["record_bodyfat"]);
endif;
endforeach;
// 一つの配列に入れ、若い日付に直す。体脂肪の値のみ取り出す。
$merge=array_merge($exist,$null);
sort($merge);
foreach($merge as $me):
  $str_weight = explode("-",$me);
  echo $str_weight[3]. ',';
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

</main>
<?php endif; 
    $pdo = null;?>
<!-- フッター部分呼び出し -->
<?php
endif;
    require_once 'footer.php';?>
</div>
</body>
</html>