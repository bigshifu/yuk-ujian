<?php

    include_once('connect.php');

    session_start();

    $QContent = $_POST['QContent'];
    $QChoice = $_POST['QChoice'];
    $QCorrect = $_POST['QCorrect'];
    $QScore = $_POST['QScore'];
    $TeacherId = $_SESSION['UserId'];

    $RecordSQL = "INSERT INTO Question VALUES(null,'$QContent','$QCorrect',$QScore,$TeacherId,NOW(),'$QChoice');";

    $res = mysqli_query($con, $RecordSQL);

    $arr = array();

    if($res){
        $arr['success'] = 1;
        $arr['message'] = "Entri Pertanyaan Berhasil";
        echo json_encode($arr);
    }else{
        $arr['success'] = 0;
        $arr['message'] = 'Operasi Data Gagal: '.mysqli_error($con);
        echo json_encode($arr);
    }