<?php

error_reporting(E_ALL & ~E_DEPRECATED);
include_once("connect.php");

session_start();
$UserId = "";
$UserPassword = "";
$UserLevel = -1;
if(isset($_POST['UserId']) && isset($_POST['UserPassword']) && isset($_POST['UserLevel'])){
    $UserId       = $_POST['UserId'];
    $UserPassword = md5($_POST['UserPassword']);
    $UserLevel    = $_POST['UserLevel'];
}

$LoginStuSQL     = "SELECT StuName,StuPassword,StuId FROM student WHERE StuId='".$UserId."';";
$LoginTeacherSQL = "SELECT TeacherName,TeacherId,TeacherPassword FROM teacher WHERE TeacherId='".$UserId."';";
$check = "";
$name = "";
$path = "";

if($UserLevel==0){
    $res = mysqli_query($con, $LoginStuSQL);
    $check = "StuPassword";
    $name = "StuName";
    $path = "Student.php";
}else if($UserLevel==1){
    $res = mysqli_query($con, $LoginTeacherSQL);
    $check = "TeacherPassword";
    $name = "TeacherName";
    $path = "Teacher.php";
}

$LoginInfo = "INSERT INTO loginhistory VALUES('".$UserId."','".$UserLevel."',NOW());";

if($res){
    $arr = mysqli_fetch_array($res, MYSQLI_ASSOC);
    if($arr[$check]==$UserPassword && $UserPassword!=""){
        $_SESSION['level'] = $UserLevel;
        $_SESSION['UserId'] = $UserId;
        $_SESSION['UserName'] = $arr[$name];
        $_SESSION['LoginTime'] = date("Y-m-d H:i:s");
        $r = mysqli_query($con, $LoginInfo);
        if($r){
            header("location: ../../$path"); 
        }else{
            echo "<script>alert('Login gagal, kesalahan database'".mysqli_error($con).");</script>";
            echo "<script>window.location.href='../../index.php';</script>";
        }
        
    }else{
        echo "<script>alert('Login gagal, periksa username dan password');</script>";
        echo "<script>window.location.href='../../index.php';</script>";
    }
}

mysqli_close($con);
