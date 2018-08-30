<?php
include ("dbConnection.php");

session_start();

$id = $_POST['user_id'];
$pwd = $_POST['user_pwd'];
$pwd_hash = hash("sha256",$_POST['user_pwd']);
$_SESSION['session_id'] = $id;

$sql = "select memberName,pwd,email,mobilePhoneNum,HomePhoneNum,address from member where id = '".$id."'";

$rs = mysqli_query($connect,$sql);
$rsArr = mysqli_fetch_array($rs);

$_SESSION['session_name']= $rsArr['memberName'];
$_SESSION['session_phone']= $rsArr['mobilePhoneNum'];
$_SESSION['session_email']= $rsArr['email'];
$_SESSION['session_homePhoneNum']=$rsArr['HomePhoneNum'];
$_SESSION['session_address']=$rsArr['address'];

if($rsArr['pwd'] == null){
    $return = ['msg' => '아이디가 존재하지 않습니다.','result' => 'idFail'];
}else if($rsArr['pwd'] == $pwd_hash){
    $return = ['msg' => '로그인 성공하셨습니다.','result' => 'success','session_id' => $_SESSION['session_id']
    ,'session_phone' => $_SESSION['session_phone'],'session_name' => $_SESSION['session_name']
    ,'session_email' => $_SESSION['session_email'],'session_homePhoneNum' => $_SESSION['session_homePhoneNum']
    ,'session_address' => $_SESSION['session_address']];
}else if($rsArr['pwd']!= $pwd_hash){
    $return = ['msg' => '비밀번호가 틀렸습니다.','result' => 'pwdFail'];
}

echo json_encode($return);
?>

