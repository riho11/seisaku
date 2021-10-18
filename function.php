<?php

// 数値を「男,女」表示へ変更
function gender($gender){
    if($gender == 0):
        echo "男"; 
    elseif($gender == 1):
        echo "女";
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
function weight_difference($Initial_setting,$gole){
    if($Initial_setting <= $gole):
        echo "達成しました！";
    else:
        echo "目標まで残り　" . $Initial_setting - $gole . "kg";
    endif;
}

// 体脂肪の目標を達成した場合
function bodyfat_difference($Initial_setting,$gole){
    if($Initial_setting <= $gole):
        echo "達成しました！";
    else:
        echo "目標まで残り　" . $Initial_setting - $gole . "%";
    endif;
}