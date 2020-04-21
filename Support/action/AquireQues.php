<?php

include_once("connect.php");

session_start();

$Userid = $_SESSION['UserId'];

$setid = "";
if(isset($_SESSION['setid']))
{
    $setid = $_SESSION['setid'];
}

$arr = array();

/*** 
$AquireSQL = "SELECT Qcontent,QScore,QChoice,Qid From question WHERE Qid=ANY(SELECT Qid FROM question LEFT JOIN  
                (SELECT Qid as i from testhistory WHERE testhistory.StuId=$Userid) as t1  
                    ON question.Qid=t1.i WHERE t1.i IS NULL);";

$CountSQL = "SELECT COUNT(*) as num From question WHERE Qid=ANY(SELECT Qid FROM question LEFT JOIN  
                (SELECT Qid as i from testhistory WHERE testhistory.StuId=$Userid) as t1  
                    ON question.Qid=t1.i WHERE t1.i IS NULL);";

$DONE = "SELECT COUNT(*) as done FROM testhistory WHERE stuid=$Userid;";
$ALL = "SELECT COUNT(*) as allQues FROM question;";
$SCORE = "SELECT total FROM GradeView WHERE stuid=$Userid;";
***/

$CONDITONS = "";

$SQL_CONDITINS = "SELECT * FROM question_sets WHERE QsetId=$setid;";

$set_res = mysqli_query($con, $SQL_CONDITINS);

if($set_res)
{
    $row = mysqli_fetch_array($set_res);
    $Qid = substr(str_replace('Q',',',$row['Qinclude']),1);
    $CONDITONS = $Qid;
}

$AquireSQL = "SELECT Qcontent,QScore,QChoice,Qid From question WHERE Qid=ANY(SELECT Qid FROM question LEFT JOIN  
                (SELECT Qid as i from testhistory WHERE testhistory.StuId=$Userid AND Qset=$setid) as t1  
                    ON question.Qid=t1.i WHERE t1.i IS NULL AND Qid IN($CONDITONS));";

$CountSQL = "SELECT COUNT(*) as num From question WHERE Qid=ANY(SELECT Qid FROM question LEFT JOIN  
                (SELECT Qid as i from testhistory WHERE testhistory.StuId=$Userid AND Qset=$setid) as t1  
                    ON question.Qid=t1.i WHERE t1.i IS NULL AND Qid IN($CONDITONS));";

$DONE = "SELECT COUNT(*) as done FROM testhistory WHERE stuid=$Userid AND Qset=$setid;";
$ALL = "SELECT COUNT(*) as allQues FROM question WHERE Qid IN($CONDITONS);";
$SCORE = "SELECT total FROM GradeView WHERE stuid=$Userid;";

$_d = mysqli_fetch_array(mysqli_query($con, $DONE)); 
$_a = mysqli_fetch_array(mysqli_query($con, $ALL)); 
$_t = mysqli_fetch_array(mysqli_query($con, $SCORE)); 
$percent = "";

if($_a['allQues']!=0){
    $percent = round(($_d['done']/$_a['allQues'])*100,2);
    $percent .= '%';
}else{
    $percent = "运算错误";
}


$res = mysqli_query($con, $CountSQL);
$cnt = mysqli_fetch_array($res);

if ($cnt['num'] == 0) {
    $percent = "100%";
    ///echo $CountSQL;
    $arr['success'] = 2;
    $arr['total'] = $_t['total'];
    $arr['percent'] = $percent;
    $arr['rest'] = 0;
    info($con,$Userid,$arr);
    echo json_encode($arr);
    return;
}

$res = mysqli_query($con, $AquireSQL);
$ques = array();
if ($res) {
    while ($row = mysqli_fetch_array($res)) {
        $ques[] = $row;
    }
    ///echo "<pre>";
    ///print_r($ques);
    $num = rand(0, $cnt['num'] - 1);
    $arr = $ques[$num];
    $arr['success'] = 1;
    $arr['rest'] = $cnt['num'] - 1;
} else {
    $arr['success'] = "0";
    $arr['message'] = "Operasi Data Gagal: " . mysqli_error($con);
    ///echo $AquireSQL;
}

info($con, $Userid,$arr);

function info($con, $Userid,&$arr)
{

    $TestSQL1 = "SELECT SUM(StuScore) as total FROM testhistory WHERE StuId=$Userid;";
    $TestSQL2 = "SELECT COUNT(*) as correctNum FROM testhistory WHERE StuId=$Userid AND StuScore<>0;";
    $TestSQL3 = "SELECT COUNT(*) as wrongNum FROM testhistory WHERE StuId=$Userid AND StuScore=0;";
    $TestSQL4 = "SELECT COUNT(*) as allNum FROM question;";

    $total = mysqli_fetch_array(mysqli_query($con, $TestSQL1));
    $right = mysqli_fetch_array(mysqli_query($con, $TestSQL2));
    $wrong = mysqli_fetch_array(mysqli_query($con, $TestSQL3));
    $allNum = mysqli_fetch_array(mysqli_query($con, $TestSQL4));

    if ($total['total'] == "") {
        $arr['total'] = 0;
    } else {
        $arr['total'] = $total['total'];
    }

    if ($right['correctNum'] == "") {
        $arr['correctNum'] = 0;
    } else {
        $arr['correctNum'] = $right['correctNum'];
    }

    if ($wrong['wrongNum'] == "") {
        $arr['wrongNum'] = 0;
    } else {
        $arr['wrongNum'] = $wrong['wrongNum'];
    }

    if ($allNum['allNum'] == "") {
        $arr['allNum'] = 0;
    } else {
        $arr['allNum'] = $allNum['allNum'];
    }
}

$arr['percent'] = $percent;

//print_r($arr);
mysqli_close($con);
echo json_encode($arr);