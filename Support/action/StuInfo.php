<?php

session_start();

header("Content-Type:text/html;charset=utf-8");
error_reporting(0);

include_once("connect.php");
mysqli_query($con, 'set names utf8');

$UserId = $_SESSION['UserId'];

$CONDITIONS = "";
if(isset($_POST['setid']))
{
    if($_POST['setid']=='all'||$_POST['setid']=='-1')
    {
        $CONDITIONS = "";
    }else{
        $CONDITIONS = "AND Qset=".$_POST['setid'];
    }
}

$page = $_POST['currentPage'] ? intval($_POST['currentPage']) : 1;

$perPageNums = 5;
$offset = ($page - 1) * $perPageNums;

$sql1 = "SELECT question.Qid,question.QScore,question.QAnswer,question.Qcontent,question.QChoice,StuScore,StuChoise,TestTime FROM testhistory,question WHERE StuId=$UserId AND question.qid=testhistory.qid $CONDITIONS limit $offset,$perPageNums;";

$sql2 = "SELECT count(*) count FROM testhistory WHERE StuId=$UserId $CONDITIONS;";

$sql3 = "SELECT total FROM GradeView WHERE StuId=$UserId;";

$sql4 = "SELECT MAX(loginTime) as loginTime FROM loginhistory WHERE Stuid=$UserId and isTeacher=0;";

    //echo $sql1."<br>".$sql2;
$resource1 = mysqli_query($con, $sql1);
$resource2 = mysqli_query($con, $sql2);
$count = mysqli_fetch_assoc($resource2);
$result = array();
while ($row = mysqli_fetch_assoc($resource1)) {
    $result[] = $row;
}

$ar = array();

$rr = mysqli_query($con, $sql3);

if(mysqli_num_rows($rr)<1){
    $ar['total'] = 0;
}else{
    $resource3 = mysqli_fetch_array($rr);
    $ar['total'] = $resource3['total'];
}

$resource4 = mysqli_fetch_array(mysqli_query($con, $sql4));

$ar['lastTime'] = $resource4['loginTime']; 

$result[] = $ar;

    ///echo $sql1."<br>".$sql2."<br>";
    //echo "<pre>";
    //print_r($resource4['loginTime']);
echo json_encode(array('datas' => $result, 'total' => $count['count']));
?>