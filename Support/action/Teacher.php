<?php

include_once("connect.php");

$tab = "<tr>
<td>1001</td>
<td>Lorem</td>
<td>2017-12-19 15:49</td>
<td>100</td>
<td>10</td>
<td>
    <button class='btn btn-xs btn-primary'>Lihat</button>
</td>
</tr>";

$arr = getStuInfo($con);

print_r($arr);
$tab = "";
foreach($arr as $k=>$v){
    $tab .= "<tr>";
    $tab .= "<td>".$k."</td>";
    $tab .= "<td>".$v['StuName']."</td>";
    $tab .= "<td>".$v['lastTime']."</td>";
    $tab .= "<td>".$v['TotalScore']."</td>";
    $tab .= "<td>".(string)($v['Wrong']+$v['Right'])."</td>";
    $tab .= "<td><button class='btn btn-xs btn-primary'>Lihat</button></td>";
    $tab .= "</tr>";
}

echo $tab;


function getStuInfo($con)
{
    // id name
    $SQL1 = "SELECT * FROM student;";

    // lastTime 
    $SQL2 = "SELECT Id as StuId,MAX(LoginTime) as lastTime FROM loginhistory WHERE isTeacher=0 GROUP BY id;";

    //right
    $Right = "SELECT StuId,COUNT(*) as Correct FROM testhistory WHERE StuScore<>0 GROUP BY StuId;";

    //wrong
    $Wrong = "SELECT StuId,COUNT(*) as Wrong FROM testhistory WHERE StuScore=0 GROUP BY StuId;";

    //total ques
    //$TotalQues = "SELECT COUNT(*) as TotalQues FROM question;";

    //total score
    $TotalScore = "SELECT StuId,SUM(StuScore) as TotalScore FROM testhistory GROUP BY StuId;";

    $r1 = mysqli_query($con, $SQL1);
    $r1s = array();
    if ($r1) {
        while ($a = mysqli_fetch_array($r1)) {
            $r1s[$a['StuId']]['StuName'] = $a['StuName'];
        }
    }
    $r2 = mysqli_query($con, $SQL2);
    if ($r2) {
        while ($a = mysqli_fetch_array($r2)) {
            $r1s[$a['StuId']]['lastTime'] = $a['lastTime'];
        }
    }
    $rt = mysqli_query($con, $Right);
    if ($rt) {
        while ($a = mysqli_fetch_array($rt)) {
            $r1s[$a['StuId']]['Right'] = $a['Correct'];
        }
    }
    $wr = mysqli_query($con, $Wrong);
    if ($wr) {
        while ($a = mysqli_fetch_array($wr)) {
            $r1s[$a['StuId']]['Wrong'] = $a['Wrong'];
        }
    }
    //$tq = mysql_query($TotalQues);

    $ts = mysqli_query($con, $TotalScore);
    if ($ts) {
        while ($a = mysqli_fetch_array($ts)) {
            $r1s[$a['StuId']]['TotalScore'] = $a['TotalScore'];
        }
    }

    return $r1s;
}