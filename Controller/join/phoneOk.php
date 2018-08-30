<?php

session_start();

//var_dump($_POST);

/*세션 시작*/
switch ($_POST['mode']) {

    case 'auth_num_send' :
        $phone = join('-', $_POST['phone']);
        $_SESSION['auth_num'] = '123456';
        $return = ['msg' => '인증번호를 발송하였습니다.[123456]', 'result' => 'success'];

        break;

    case 'auth_num_check' :
        $_SESSION['auth_num'] = '123456';
        $checkNum = $_POST['checkNum'];
        /*$phone = join('-',$_POST['phone']);*/
        $_SESSION['phone'] = join('-', $_POST['phone']);


        if($checkNum==$_SESSION['auth_num']) {
            $return = ['msg' => '인증을 성공하였습니다.', 'phone' => $_SESSION['phone'],'result' => 'success'];
        }else{
            $return = ['msg' => '인증 실패하였습니다.','result'=>'fail'];
        }
        break;


}
echo json_encode($return);
?>

