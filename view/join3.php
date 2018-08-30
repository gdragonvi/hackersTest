<?php
include("header.php");	// 헤더
/*include("dbConnection.php");*/
session_start();
/*var_dump($_SESSION['phone']);*/
?>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<!--<script type="text/javascript" src="http://q.hackershrd.com/worksheet/js/jquery-1.12.4.min.js"></script>-->
<script>
    //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
    function DaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if(fullRoadAddr !== ''){
                    fullRoadAddr += extraRoadAddr;
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('postcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('roadAddress').value = fullRoadAddr;
                document.getElementById('jibunAddress').value = data.jibunAddress;

                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    //예상되는 도로명 주소에 조합형 주소를 추가한다.
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

                } else {
                    document.getElementById('guide').innerHTML = '';
                }
            }
        }).open();
    }
    function emailchange() {
        var email = $('#email3').val();
        $('#email2').val(email).attr("disabled",true);
    }

    function checkId() {
        var sendId = $('input[name=id]').val();
        var exp = /^(?=[a-z])(?=.*[a-z])(?=.*[0-9]).{4,15}$/;

        if(sendId.match(exp)){
            /* $('#idSpan').text('작성 조건을 만족하셨습니다.');*/
            $.ajax({
                method: "POST",
                url: "../Database/selectTest.php",
                dataType: 'json',
                data: {
                    sendId : sendId
                }
            }).success(function (data) {
                console.log(data);
                if (data.result == 'success') {
                    alert(data.msg);
                } else {
                    alert(data.msg);
                    $('input[name=id]').val('');
                    $('input[name=id]').focus();
                }

            });
        }else{
            $('#idSpan').text('영문자로 시작하는 4~15자리의 영문소문자,숫자를 입력해주세요!');
            $('input[name=id]').val('');
            $('input[name=id]').focus();
        }
    }

    $(function(){
        $('form[name=memberInfo]').submit(function(){
            var pv = $('input[name=pwd]').val();
            var rv = $('input[name=pwd2]').val();
            var exp = /^(?=.*[a-z])(?=.*[0-9]).{8,15}$/;

            if(pv!=rv){
                alert("비밀번호와 확인란이 일치하지 않습니다.");
                $('input[name=pwd]').focus();
                return false;
            }else{
                if(!(pv.match(exp))){
                    alert("8~15자의 영문자/숫자 혼합으로 비밀번호를 작성해주세요!");
                    $('input[name=pwd]').val('');
                    $('input[name=pwd]').focus();
                    return false;
                }
            }

            if(!$('input[name=memberName]').val()){
                alert('이름을 입력해 주세요~');
                $('input[name=memberName]').focus();
                return false;
            }
            if(!$('input[name=id]').val()){
                alert('아이디를 입력해 주세요~');
                $('input[name=id]').focus();
                return false;
            }
            if(!$('input[name=pwd]').val()){
                alert('비밀번호를 입력해 주세요~');
                $('input[name=pwd]').focus();
                return false;
            }
            if(!$('input[name=pwd2]').val()){
                alert('비밀번호 확인을 입력해 주세요~');
                $('input[name=pwd2]').focus();
                return false;
            }
            if(!$("#email1").val()){
                alert('이메일을 입력해 주세요~');
                $('#email1').focus();
                return false;
            }
            if(!$('#email2').val()){
                alert('이메일을 입력해 주세요~');
                $('#email2').focus();
                return false;
            }
            if(!$('#postcode').val()){
                alert('주소를 입력해 주세요~');
                $('#postcode').focus();
                return false;
            }
            if(!$('#roadAddress').val()){
                alert('주소를 입력해 주세요~');
                $('#roadAddress').focus();
                return false;
            }
            if(!$('#jibunAddress').val()){
                alert('주소를 입력해 주세요~');
                $('#jibunAddress').focus();
                return false;
            }

            /*          내용 입력 안되었을 경우 알림 띄우기 간단하게 짜는 법(입력내용이 많을 경우)
                        var isValide = true;
                         $(this).find('input').each(function () {
                             if($(this).attr('req') == 'required' && !$(this).val()){

                                 if($(this).attr('msg')) alert($(this).attr('msg'));
                                 else  alert($(this).attr('hname')+'을 입력해 주세요.~~~~');

                                 $(this).focus();
                                 isValide = false;
                                 return false;
                             }
                         });

                         if(!isValide) return false;*/
        });
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
                    <li><i class="icon-join-chk"></i> 본인확인</li>
                    <li class="last on"><i class="icon-join-inp"></i> 정보입력</li>
                </ul>
            </div>

            <form method="POST" name="memberInfo" autocomplete="on" action="../Database/joinTest.php">
                <div class="section-content">
                    <table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
                        <caption class="hidden">강의정보</caption>
                        <colgroup>
                            <col style="width:15%"/>
                            <col style="*"/>
                        </colgroup>

                        <tbody>
                        <tr>
                            <th scope="col"><span class="icons">*</span>이름</th>
                            <td><input type="text" class="input-text" style="width:302px" name="memberName" req="required" hname="이름"/></td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons">*</span>아이디</th>
                            <td><input type="text" class="input-text" style="width:302px" placeholder="영문자로 시작하는 4~15자의 영문소문자, 숫자" name="id" req="required" hname="아이디"/>
                                <input type="button" onclick="checkId()" class="btn-s-tin ml10" value="중복확인">
                                <span id="idSpan"></span></td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons">*</span>비밀번호</th>
                            <td><input type="password" name="pwd" class="input-text" style="width:302px" placeholder="8-15자의 영문자/숫자 혼합" req="required" hname="비밀번호"/></td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons">*</span>비밀번호 확인</th>
                            <td><input type="password" name="pwd2" class="input-text" style="width:302px"/></td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons" >*</span>이메일주소</th>
                            <td>
                                <input type="text" class="input-text" id="email1" name="email[]" req="required" hname="이메일주소 앞자리" style="width:138px"/>
                                @
                                <input type="text" class="input-text" id="email2" req="required" hname="이메일주소 뒷자리" style="width:138px" />
                                <select class="input-sel" style="width:160px" id="email3"  name="email[]" onchange="emailchange()">
                                    <option value="naver.com">naver.com</option>
                                    <option value="daum.net">daum.net</option>
                                    <option value="google.com">google.com</option>
                                    <option value="hotmail.net">hotmail.net</option>
                                    <option value="gmail.com">gmail.com</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons">*</span>휴대폰 번호</th>
                            <td>
                                <?php
                                $phoneNumber = explode("-",$_SESSION['phone']);
                                ?>
                                <input type="text" class="input-text" name="phoneNum[]" style="width:50px" value="<?php echo $phoneNumber[0]?>" disabled/> -
                                <input type="text" class="input-text" name="phoneNum[]" style="width:50px" value="<?php echo $phoneNumber[1]?>" disabled/> -
                                <input type="text" class="input-text" name="phoneNum[]" style="width:50px" value="<?php echo $phoneNumber[2]?>" disabled/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons"></span>일반전화 번호</th>
                            <td><input type="text" class="input-text" name="homeNum[]" style="width:88px"/> - <input type="text" class="input-text" name="homeNum[]" style="width:88px"/> - <input type="text" class="input-text" name="homeNum[]" style="width:88px"/></td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons">*</span>주소</th>
                            <td>
                                <p >
                                    <label>우편번호 <input type="text" class="input-text ml5" name="address[]" id="postcode" style="width:242px" disabled /></label><a href="#" class="btn-s-tin ml10" onclick="DaumPostcode()">주소찾기</a>
                                </p>
                                <p class="mt10">
                                    <label>기본주소 <input type="text" class="input-text ml5" name="address[]" id="roadAddress" style="width:719px"/></label>
                                </p>
                                <p class="mt10">
                                    <label>상세주소 <input type="text" class="input-text ml5" name="address[]" id="jibunAddress" style="width:719px"/></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons">*</span>SMS수신</th>
                            <td>
                                <div class="box-input">
                                    <label class="input-sp">
                                        <input type="radio" name="smsCheck" id="yes" checked="checked" value="true"/>
                                        <span class="input-txt" >수신함</span>
                                    </label>
                                    <label class="input-sp">
                                        <input type="radio" name="smsCheck" id="no" value="false"/>
                                        <span class="input-txt" name="smsCheck">미수신</span>
                                    </label>
                                </div>
                                <p>SMS수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons">*</span>메일수신</th>
                            <td>
                                <div class="box-input">
                                    <label class="input-sp">
                                        <input type="radio" name="emailCheck" id="yes2" checked="checked" value="true"/>
                                        <span class="input-txt" >수신함</span>
                                    </label>
                                    <label class="input-sp">
                                        <input type="radio" name="emailCheck" id="no2" value="false"/>
                                        <span class="input-txt" >미수신</span>
                                    </label>
                                </div>
                                <p>메일수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
                            </td>
                        </tr>
                        </tbody>
            </form>
            </table>

            <div class="box-btn">
                <input type="submit" value="회원가입" class="btn-l">
            </div>
        </div>
    </div>
</div>
</div>
</form>
<?php
include ("footer.php");
?>
</body>
</html>
