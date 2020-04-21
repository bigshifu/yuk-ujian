<?php

    session_start();

    include_once("connect.php");

    $UserName = "";
    $UserId = "";
    $UserPassword = "";
    $UserLevel = -1;

    $arr = array();
    if(isset($_POST['UserName']) && isset($_POST['Password']) && isset($_POST['UserId'])){
        $UserName = $_POST['UserName'];
        $UserId = $_POST['UserId'];
        $UserPassword = $_POST['Password'];
        $UserLevel = $_POST['UserLevel'];

        $StuSignUp = "Insert into student values('".$UserId."','".$UserName."','".$UserPassword."');";
        $TecherSignUp = "Insert into teacher values('".$UserId.",'".$UserName."','".$UserPassword."');";
        if($UserLevel==0)
        {
            $res = mysqli_query($con, $StuSignUp);
        }else if($UserLevel==1){
            $res = mysqli_query($con, $TecherSignUp);
        }
        
        if($res){
            $arr['success'] = 1;
            $arr['message'] = "Pendaftaran Berhasil".mysqli_error();
            echo json_encode($arr);
            ///echo "YES";
        }else{
            $arr['success'] = 0;
            $arr['message'] = "ID Mungkin Sudah digunakan\n"."ERROR: ".mysqli_error();
            echo json_encode($arr);
            ///echo $StuSignUp;
        }
    }else{
        $arr['success'] = 0;
        $arr['message'] = "Permintaan gagal";
        echo json_encode($arr);
    }

    

