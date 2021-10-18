<?php
//DB接続情報
    $dbname = 'mysql:host=localhost;dbname=diet;charset=utf8';
    $id = 'root';
    $pw = '';

    try{
//DB取得情報
        $pdo=new PDO($dbname,$id,$pw,array(PDO::ATTR_EMULATE_PREPARES => false));
    }
    catch(PDOException $e){
        exit('データベース接続失敗'.$e->getMessage());
    }