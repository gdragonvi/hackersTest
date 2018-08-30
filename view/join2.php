<?php
include("header.php");	// 헤더

session_start();
/*var_dump($_SESSION['phone']);*/
?>
<script type="text/javascript">
    var join2 = {
        /*phoneArray : Array(),*/
        phoneArray : Array(),

        initPage: function () {
            $('[name="btn-sign"]').on('click', this.submitSend);
            $('[name="btn-check"]').on('click', this.submitCheck);
        },
        submitCheck: function () {
            var phoneArray = Array();
            var checkNum = $('[name="checkNum"]').val();

            $('[name="phone[]"]').each(function (index, phone) {
                phoneArray.push($(phone).val());
            });

            $.ajax({
                method: "POST",
                url: "../Controller/join/phoneOk.php",
                dataType: 'json',
                data: {
                    mode: 'auth_num_check',
                    phone: phoneArray,
                    checkNum : checkNum
                }
            })
                .success(function (data) {
                    if (data.result == 'success') {
                        alert(data.msg);
                        location.href ="join3.php";
                    } else if(data.result == 'fail') {
                        alert(data.msg);
                        $('form [name="checkNum"]').val('');
                        $('form [name="checkNum"]').focus();
                    }
                })
        },


        /* 인증번호 확인을 눌렀을 때 전화번호 전송 */
        submitSend: function () {
            var phoneArray = Array();

            $('[name="phone[]"]').each(function (index, phone) {
                phoneArray.push($(phone).val());
            });

            $.ajax({
                method: "POST",
                url: "../Controller/join/phoneOk.php",
                dataType: 'json',
                data: {
                    mode: 'auth_num_send',

                    phone: phoneArray
                }
            })
                .success(function (data) {
                    console.log(data);
                    if (data.result == 'success') {
                        alert(data.msg);
                        $('form [name="checkNum"]').focus();
                    } else {
                        alert("실패");
                    }
                });
        }
    }


            /* 휴대폰 번호 보냈을 때 상황 */
            $(document).ready(function () {
                join2.initPage();
            });


</script>

<body>

<div id="container" class="container-full">
    <div id="content" class="content">
        <div class="inner">
            <div class="tit-box-h3">
                <h3 class="tit-h3">회원가입</h3>
                <div class="sub-depth">
                    <span><i class="icon-home"><span>홈</span></i></span>
                    <strong>회원가입</strong>
                </div>
            </div>
<div class="join-step-bar">
    <ul>
        <li><i class="icon-join-agree"></i> 약관동의</li>
        <li class="on"><i class="icon-join-chk"></i> 본인확인</li>
        <li class="last"><i class="icon-join-inp"></i> 정보입력</li>
    </ul>
</div>

<div class="tit-box-h4">
    <h3 class="tit-h4">본인인증</h3>
</div>

<div class="section-content after">
    <div class="identify-box" style="width:100%;height:190px;">
        <div class="identify-inner">
            <strong>휴대폰 인증</strong>
            <p>주민번호 없이 메시지 수신가능한 휴대폰으로 1개 아이디만 회원가입이 가능합니다. </p>

            <br />
            <form id="form2" name="form2" action="../view/join3.php" method="post">
                <input type="hidden" name="mode" value="auth_num_send">
                <input type="text" class="input-text" name="phone[]" style="width:50px"/> -
                <input type="text" class="input-text" name="phone[]" style="width:50px"/> -
                <input type="text" class="input-text" name="phone[]" style="width:50px"/>
                <input type="button" class="btn-s-line" id="phoneButton" name="btn-sign" value="인증번호 받기">
                <div id = "message2"></div>
            </form>
            <br /><br />
            <form id="form1" name="form1" action="../Controller/join/phoneOk.php" method="post">
                <input type="hidden" name="mode" value="auth_num_check">
                <input type="text" class="input-text" name="checkNum" style="width:200px"/>
                <input type="button" class="btn-s-line" id="checkButton" name="btn-check" value="인증번호 확인">
                <div id = "message"></div>
            </form>
        </div>
        <i class="graphic-phon"><span>휴대폰 인증</span></i>
    </div>
</div>

</div>
</div>
</div>

<?php
include ("footer.php");
?>
</body>
</html>
