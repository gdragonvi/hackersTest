<?php
include ("dbConnection.php");
session_start();

$newPwdHash = hash("sha256",$_POST['newPwd']);

$sql = "UPDATE member SET pwd = '".$newPwdHash."' where id =  '".$_SESSION['userId']."' ";
$rs = mysqli_query($connect,$sql);

$return = ['msg' => '비밀번호 변경 성공', 'result' => 'success'];

echo json_encode($return);
?>
