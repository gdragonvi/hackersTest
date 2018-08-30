<?php
session_start();

include ("dbConnection.php");

switch ($_POST['mode']){
    case 'auth_phone' :
        $phone = join('-', $_POST['phone']);
        $_SESSION['auth_num'] = '123456';
        $_SESSION['phone']=$phone;
        $return = ['msg' => '인증번호를 발송하였습니다. [123456]','result' => 'success'];
        break;

    case 'auth_phone_check' :
        $_SESSION['auth_num'] = '123456';
        $checkNum = $_POST['checkNum'];

        if($checkNum == $_SESSION['auth_num']){
            $number = $phone;
            $sql = "select id from member where mobilePhoneNum= '".$_SESSION['phone']."'";
            $rs = mysqli_query($connect,$sql);
            $rsArr = mysqli_fetch_array($rs);
            $id = $rsArr['id'];
            $_SESSION['userId']=$id;
            $return = ['msg' => '인증성공','id'=> $_SESSION['userId'], 'result' => 'success'];
        }else{
            $return = ['msg' => '인증실패','result' => 'fail'];
        }
        break;

    case 'auth_phone_pwd' :
        $id = $_POST['id'];
        $_SESSION['auth_num'] = '123456';
        $_SESSION['userId'] = $id;
        $return = ['msg' => '인증번호를 발송하였습니다.[123456]','id'=> $_SESSION['userId'], 'result' => 'success'];
        break;

    case 'auth_phone_pwd_check':
        $_SESSION['auth_num'] = '123456';
        $checkNum = $_POST['checkNum'];

        if($checkNum == $_SESSION['auth_num']){
            $sql = "select pwd from member where id= '".$_SESSION['userId']."'";
            $rs = mysqli_query($connect,$sql);
            $rsArr = mysqli_fetch_array($rs);
            $pwd = $rsArr['pwd'];
            $_SESSION['pwd']=$pwd;
            $return = ['msg' => '인증성공','pwd'=> $_SESSION['pwd'], 'result' => 'success'];
        }else{
            $return = ['msg' => '인증실패','result' => 'fail'];
        }
        break;


}

echo json_encode($return);
?>