<?php

include_once("connect.php");

session_start();

if(isset($_POST['target']) && isset($_POST['Qid']))
{
    if($_POST['target']=='Question')
    {
        echo json_encode(DeleteFromQuestion($con,$_POST['Qid']));
    }else{
        echo json_encode(DeleteFromSet($con,$_POST['target'],$_POST['Qid']));
    }
}else{
    $res = array();
    $res['success'] = 0;
    $res['message'] = "POST ERROR...";
    echo json_encode($res);
}

function DeleteFromSet($con,$Setid,$targetid)
{
    $target = $targetid;
    $target = str_replace('Q','',$target);
    $SQL2 = "DELETE FROM testhistory WHERE Qid=$target AND Qset='$Setid';";
    $SQL3 = "UPDATE question_sets SET Qinclude=REPLACE(Qinclude,'Q$target','') WHERE QsetId='$Setid';";

    $res = array();

    if(mysqli_query($con, $SQL2) && mysqli_query($con, $SQL3))
    {
        $res['success'] = 1;
    }else{
        $res['success'] = 0;
        $res['message'] = "DeleteFromSet::".mysqli_error($con);
    }

    return $res;
}

function DeleteFromQuestion($con,$targetid)
{
    $target = $targetid;
    $target = str_replace('Q','',$target);
    $SQL1 = "DELETE FROM Question WHERE Qid=$target;";
    $SQL2 = "DELETE FROM testhistory WHERE Qid=$target;";
    $SQL3 = "UPDATE question_sets SET Qinclude=REPLACE(Qinclude,$target,'') WHERE Qinclude LIKE 'Q$target';";

    $res = array();

    if(mysqli_query($con, $SQL3) && mysqli_query($con, $SQL2) && mysqli_query($con, $SQL1))
    {
        $res['success'] = 1;
    }else{
        $res['success'] = 0;
        $res['message'] = "target:".$target."::".mysqli_error($con, );
    }

    return $res;
}