<?php

include_once("connect.php");

$arr = array();

if(isset($_POST['UserId'])){
    if(isTaken($con,$_POST['UserId'],$_POST['Level'])){
        $arr['success'] = 0;
    }else{
        $arr['success'] = 1;
    }
    echo json_encode($arr);
}

function isTaken($con,$UserId,$Level){
    $SQL = "";
    if($Level==0){
        $SQL = "SELECT * FROM student WHERE StuId= '".$UserId."';";
    }else{
        $SQL = "SELECT * FROM teacher WHERE TeacherId= '".$UserId."';";
    }
    
    $res = mysqli_query($con, $SQL);
    $cnt = mysqli_num_rows($res);
    if($cnt==0){
        return 0;
    }else{
        return 1;
    }
}