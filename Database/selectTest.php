<?php
include("dbConnection.php");

$id = $_POST['sendId'];
/*echo $id;*/

// 있는 id : gdragonvi2 => fail

$sql = "select count(*) as count from member where id = '".$id."'";

/*$sql = "select count(*) from member where id = 'gdragonvi2'";*/


$rs = mysqli_query($connect, $sql);
$rsArr = mysqli_fetch_array($rs);



if($rsArr['count'] == 0){
    $return = ['msg' => '가입 가능합니다.','result'=> 'success'];
}else{
    $return = [ 'msg' => '아이디가 중복되었습니다.', 'result' => 'fail'];
}
//
echo json_encode($return);

//var_dump($rs);
//print_r($rsArr);
//echo "Test!";
