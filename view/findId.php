<?php
include ("header.php");
?>
<script>
    function check() {
        var curruntTargetValue = $(this).val();
        $('[name="auth_type"]').not('[value="' + curruntTargetValue + '"]').attr('checked', false);

        if($('[name="auth_type"]:checked').val() == "phone"){
            $('[name="numberForm"]').show();
            $('[name="phoneForm"]').show();
            $('[name="emailForm"]').hide();
        }else if($('[name="auth_type"]:checked').val() == "email"){
            $('[name="numberForm"]').show();
            $('[name="emailForm"]').show();
            $('[name="phoneForm"]').hide();
        }
    }
    var find = {
        phoneArray : Array(),

        initPage: function () {
            $('[name="phoneClick"]').on('click',this.findbyPhone);
            $('[name="phoneClick2"]').on('click',this.findbyPhone2);
            $('[name="auth_type"]').on('change', check);
        },
        findbyPhone: function () {
            var phoneArray = Array();

            $('[name="phone[]"]').each(function (index,phone) {
                phoneArray.push($(phone).val());
            });
            $.ajax({
                method:"POST",
                url:"../Database/findByPhone.php",
                dataType:'json',
                data:{
                    mode: 'auth_phone',
                    phone: phoneArray
                }
            }).success(function (data) {
                if(data.result == 'success'){
                    alert(data.msg);
                    location.href="findId.php";
                }else{
                    alert(data.msg);
                }
            });

        },
        findbyPhone2: function(){
        var phoneArray = Array();
        var checkNum = $('[name="checkNum"]').val();

        $('[name="phone[]"]').each(function (index, phone) {
            phoneArray.push($(phone).val());
            });
        $.ajax({
            method: "POST",
            url: "../Database/findByPhone.php",
            dataType: 'json',
            data: {
                mode: 'auth_phone_check',
                phone: phoneArray,
                checkNum : checkNum
            }
        }).success(function (data) {
            if (data.result == 'success') {
                alert(data.msg);
                location.href="findIdFinish.php";
            } else { //(data.result == 'fail') {
                $('form [name="checkNum"]').val('');
                $('form [name="checkNum"]').focus();
                alert("실패");
            }
        });
    }
}

    $(document).ready(function () {
        find.initPage();
    });

</script>
<div id="container" class="container-full">
	<div id="content" class="content">
		<div class="inner">
			<div class="tit-box-h3">
				<h3 class="tit-h3">아이디/비밀번호 찾기</h3>
				<div class="sub-depth">
					<span><i class="icon-home"><span>홈</span></i></span>
					<strong>아이디/비밀번호 찾기</strong>
				</div>
			</div>

			<ul class="tab-list">
				<li class="on"><a href="#">아이디 찾기</a></li>
				<li><a href="findPwd.php">비밀번호 찾기</a></li>
			</ul>

			<div class="tit-box-h4">
				<h3 class="tit-h4">아이디 찾기 방법 선택</h3>
			</div>

			<dl class="find-box">
				<dt>휴대폰 인증</dt>
				<dd>
					고객님이 회원 가입 시 등록한 휴대폰 번호와 입력하신 휴대폰 번호가 동일해야 합니다.
					<label class="input-sp big">
						<input type="radio" id="phone" name="auth_type" value="phone" checked>
						<span class="input-txt"></span>
					</label>
				</dd>
			</dl>

			<dl class="find-box">
				<dt>이메일 인증</dt>
				<dd>
					고객님이 회원 가입 시 등록한 이메일 주소와 입력하신 이메일 주소가 동일해야 합니다.
					<label class="input-sp big">
						<input type="radio" id="email" name="auth_type"  value="email"/>
						<span class="input-txt"></span>
					</label>
				</dd>
			</dl>

			<div class="section-content mt30">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">아이디 찾기 개인정보 입력</caption>
					<colgroup>
						<col style="width:15%"/>
						<col style="*"/>
					</colgroup>

                    <tbody>
                        <tr name="phoneForm">
                            <th scope="col">휴대폰 번호</th>
                            <td>
                                <form action="../Database/findByPhone.php" method="post">
                                    <input type="hidden" name="mode" value="auth_phone"">
                                <input type="text" class="input-text" style="width:138px" name="phone[]"/> -
                                <input type="text" class="input-text" style="width:138px" name="phone[]"/> -
                                <input type="text" class="input-text" style="width:138px" name="phone[]"/>
                                <input type="button" class="btn-s-tin ml10" name="phoneClick" value="인증번호받기">
                                </form>
                            </td>
                        </tr>


						<tr style="display:none" name="emailForm">
							<th scope="col">이메일주소</th>
							<td>
								<input type="text" class="input-text" style="width:138px"/> @ <input type="text" class="input-text" style="width:138px"/>
								<select class="input-sel" style="width:160px">
									<option value="">선택입력</option>
									<option value="">선택입력</option>
									<option value="">선택입력</option>
									<option value="">선택입력</option>
									<option value="">선택입력</option>
								</select>
								<a href="#" class="btn-s-tin ml10">인증번호 받기</a>
							</td>
						</tr>

						<tr name="numberForm">
							<th scope="col">인증번호</th>
                            <form action="../Database/findByPhone.php" method="post">
                                <input type="hidden" name="mode" value="auth_phone_check">
							<td><input type="text" class="input-text" name="checkNum" style="width:478px" />
                                <input type="button" class="btn-s-tin ml10" name="phoneClick2" value="인증번호 확인"></td>
                            </form>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

<?php
include ("footer.php");
?>
