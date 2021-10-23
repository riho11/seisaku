<?php

// 数値を「男,女」表示へ変更
function gender($gender){
    if($gender == 0):
        echo "男"; 
    elseif($gender == 1):
        echo "女";
    endif;
}

// 現在の年齢計算
function current_age($month,$day,$year){
    if(date("m") > $month):
        return date("Y") - $year;
    elseif(date("m") == $month):
        if(date("d") > $day):
            return date("Y") - $year;
        elseif(date("d") == $day):
            return date("Y") - $year;
        else:
            return date("Y") - $year - 1;
        endif;
    else:
        return date("Y") - $year - 1;
    endif;
}

// 体脂肪がNULLの時、未設定と表示
function null($null){
    if(is_null($null)):
        echo "未設定";
    else:
        echo " $null ％";
    endif;
}

// 体重の目標を達成した場合
function weight_difference($record,$gole){
    if($record <= $gole):
        echo "達成しました！";
    else:
        echo "目標まで残り　" . $record - $gole . "kg";
    endif;
}

// 体脂肪の目標を達成した場合
function bodyfat_difference($record,$gole){
    if($record <= $gole):
        echo "達成しました！";
    else:
        echo "目標まで残り　" . $record - $gole . "%";
    endif;
}

//BMI診断計算式
function bmi($weight,$height){
    $bmiheight = $height / 100;
    $bmisum = $weight / ($bmiheight * $bmiheight);
    return $bmisum;
}

//BMI判定
function bmi_judgment($judgment){
    if($judgment <= 18.4):
        echo "低体重です";
    elseif($judgment <= 24.9):
        echo "標準";
    elseif($judgment <= 29.9):
        echo "肥満（1度）";
    elseif($judgment <= 34.9):
        echo "肥満（2度）";
    elseif($judgment <= 39.9):
        echo "肥満（3度）";
    else:
        echo "肥満（4度）";
    endif;
}

//適正体重
function appropriate_weight($height){
    $bmiheight = $height / 100;
    $appropriate = ($bmiheight * $bmiheight) * 22;
    return round($appropriate,1);
}

//美容体重
function beauty_weight($height){
    $bmiheight = $height / 100;
    $beauty = ($bmiheight * $bmiheight) * 20;
    return round($beauty,1);
}

//モデル体重
function model_weight($height){
    $bmiheight = $height / 100;
    $model = ($bmiheight * $bmiheight) * 18;
    return round($model,1);
}

//国立健康・栄養研究所の式(男性)
function basicsman($weight,$height,$age){
    $basicsman = (0.1238 + (0.0481 * $weight) + (0.0234 * $height) - (0.0138 * $age) - 0.5473) * 1000 / 4.186;
    return round($basicsman,0);
}

//国立健康・栄養研究所の式(女性)
function basicswoman($weight,$height,$age){
    $basicswoman = (0.1238 + (0.0481 * $weight) + (0.0234 * $height) - (0.0138 * $age) - 0.5473 * 2) * 1000 / 4.186;
    return round($basicswoman,0);
}

