<?php

error_reporting(E_ALL & ~E_DEPRECATED);
include_once("connect.php");
session_start();

if(isset($_POST['operation']))
{
    if($_POST['operation']=="ShowTable")
    {
        echo json_encode(ReadTable($con));
    }

    if($_POST['operation']=="ShowDropdown")
    {
        echo json_encode(ShowDropdown($con));
    }

    if($_POST['operation']=="CreateSet")
    {
        $sAuthor = $_SESSION['UserName'];

        if(isset($_POST['sName']) && isset($_POST['sQid']))
        {
            $sQid  = $_POST['sQid'];
            $sName = $_POST['sName']; 
            $arr_res = array();
            if(CreateSet($con,$sName,$sQid,$sAuthor))
            {
                $arr_res['success'] = 1;
            }else{
                $arr_res['success'] = 0;
                $arr_res['message'] = mysqli_error($con);
            }
            echo json_encode($arr_res);
        }
    }

}

function ShowDropdown($con)
{
    $SQL = "SELECT QsetId AS sQid,QsetName AS sName FROM question_sets;";
    $res = mysqli_query($con, $SQL);
    $arr = array();
    while($row = mysqli_fetch_array($res))
    {
        $arr[] = $row;
    }
    return $arr;
}

function ReadTable($con)
{
    $SQL = "SELECT * FROM question;";
    $res = mysqli_query($con, $SQL);
    $arr = array();
    while($row = mysqli_fetch_array($res))
    {
        $arr[] = $row;
    }
    return $arr;
}

function CreateSet($con,$Name,$Qid,$Author)
{
    $SQL = "INSERT INTO question_sets(QsetName,Qinclude,CreateTime,Author) VALUES('$Name','$Qid',NOW(),'$Author');";
    $CreateRes = mysqli_query($con, $SQL);
    if($CreateRes)
    {
        return true;
    }
    return false;
}
