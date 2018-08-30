<?php
include("dbConnection.php");
session_start();

$memberName = $_POST['memberName'];
$id = $_POST['id'];
/*$pwd = $_POST['pwd'];*/
$pwdHash = hash("sha256",$_POST['pwd']);
$email = join('@', $_POST['email']);
$mobilePhoneNum = $_SESSION['phone'];
$homePhoneNum = join('-', $_POST['homeNum']);
$address = join(',', $_POST['address']);
$smsCheck = $_POST['smsCheck'] ? 'yes' : 'no';
$emailCheck = $_POST['emailCheck'] ? 'yes' : 'no';

/*var_dump($memberName,$id,$pwd,$email,$mobilePhoneNum,$homePhoneNum,$address,$smsCheck,$emailCheck);*/

/*$sql= "insert into member (memberName,id,pwd,email,mobilePhoneNum,HomePhoneNum,address,smsCheck,emailCheck)
values ('".$memberName."','".$id."','".$pwd_hash."','".$email."','".$mobilePhoneNum."','".$homePhoneNum."','".$address."',".$smsCheck.",".$emailCheck.")";*/
//
$sql = "INSERT  member SET
      memberName = '".$memberName."',
      id = '".$id."',
      pwd = '".$pwdHash."',
      email = '".$email."',
      mobilePhoneNum = '".$mobilePhoneNum."',   
      HomePhoneNum = '".$homePhoneNum."',
      address = '".$address."',
      smsCheck = '".$smsCheck."',
      emailCheck = '".$emailCheck."'
";
var_dump($sql);
$rs = mysqli_query($connect,$sql);

if($rs == false){
   /* echo '문제 발생';
    var_dump($sql);
    error_log(mysqli_error($connect));*/
}else{
    Header("Location:../view/join4.php");
}

?>