<?php 
// ＊＊＊1週間体重チャート＊＊＊
function week_weight(){
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
  for($i=$week_past; $i <= date("Y-m-d"); $i++):
    array_push($every_date,$i);
  endfor;
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
}
?>

<?php 
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
  for($i=$week_past; $i <= date("Y-m-d"); $i++):
    array_push($every_date,$i);
  endfor;
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
  array_push($exist,$array["date"] . '-'.$array["record_bodyfat"]);
endif;
endforeach;
// 一つの配列に入れ、若い日付に直す。体重の値のみ取り出す。
$merge=array_merge($exist,$null);
sort($merge);
foreach($merge as $me):
  $str_weight = explode("-",$me);
  echo $str_weight[3]. ',';
endforeach;
?>



<?php 
$month_past = date("Y-m-d",strtotime("-1 month"));
foreach($response as $array):
  if($month_past < $array["date"]):
    $str_date = explode("-",$array["date"]);
    echo $str_date[1].".".$str_date[2]. ',';
  endif;
endforeach;
?>


<?php 
$week = ['日','月','火','水','木','金','土'];
$week_past = date("Y-m-d",strtotime("-6 day"));
  for($i = $week_past; $i <= date("Y-m-d"); $i++){
    $str = explode("-",$i);
    $date=date('w',strtotime($i));
    echo "'" .$str[2] . $week[$date] ."'". ',';
  }
?>
<?php 
$month_past = date("Y-m-d",strtotime("-1 month"));
  for($i = $month_past; $i <= date("Y-m-d"); $i++){
    $str = explode("-",$i);
    echo "'" .$str[1].$str[2]."'". ',';
  }
?>