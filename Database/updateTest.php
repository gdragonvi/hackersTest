<?php
include("dbConnection.php");
session_start();

$memberName = $_SESSION['session_name'];
$id = $_SESSION['session_id'];
/*$pwd = $_POST['pwd'];*/
$pwdHash = hash("sha256",$_POST['pwd']);
$email = join('@', $_POST['email']);
$mobilePhoneNum = $_SESSION['session_phone'];
$homePhoneNum = join('-', $_POST['homeNum']);
$address = join(',', $_POST['address']);
$smsCheck = $_POST['smsCheck'] ? 'yes' : 'no';
$emailCheck = $_POST['emailCheck'] ? 'yes' : 'no';

$sql = "UPDATE member SET
           pwd = '".$pwdHash."',
           email = '".$email."', 
           HomePhoneNum = '".$homePhoneNum."', 
           address = '".$address."', 
           smsCheck = '".$smsCheck."', 
           emailCheck = '".$emailCheck."'
        WHERE 
        memberName = '".$memberName."' and id = '".$id."' and mobilePhoneNum = '".$mobilePhoneNum."'
;";

$rs = mysqli_query($connect,$sql);
echo var_dump($sql);
if($rs == false){

}else{
    Header("Location:../view/updateFinish.php");
}

?>