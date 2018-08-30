<?php
    include ("header.php");
?>
<script>
    $(function() {
        $('input[name=pwdModify]').click(function () {
            var pv = $('input[name=pwd]').val();
            var rv = $('input[name=pwd2]').val();
            var exp = /^(?=.*[a-z])(?=.*[0-9]).{8,15}$/;

            if (pv != rv) {
                alert("비밀번호와 확인란이 일치하지 않습니다.");
                $('input[name=pwd]').val('');
                $('input[name=pwd2]').val('');
                $('input[name=pwd]').focus();
                return false;
            } else {
                if (!(pv.match(exp))) {
                    alert("8~15자의 영문자/숫자 혼합으로 비밀번호를 작성해주세요!");
                    $('input[name=pwd]').val('');
                    $('input[name=pwd2]').val('');
                    $('input[name=pwd]').focus();
                    return false;
                }else{
                    var newPwd = $('input[name=pwd]').val();
                    $.ajax({
                        method: "POST",
                        url: "../Database/changePwd.php",
                        dataType: 'json',
                        data: {
                            newPwd : newPwd
                        }
                    }).success(function(data){
                        if(data.result == 'success') {
                            alert(data.msg);
                            location.href="login.php";
                        }else{
                            alert(data.msg);
                        }
                    });
                }
            }
        });
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
				<li><a href="#">아이디 찾기</a></li>
				<li class="on"><a href="#">비밀번호 찾기</a></li>
			</ul>

			<div class="tit-box-h4">
				<h3 class="tit-h4">비밀번호 재설정</h3>
			</div>

			<div class="section-content mt30">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">비밀번호 재설정</caption>
					<colgroup>
						<col style="width:17%"/>
						<col style="*"/>
					</colgroup>
                    <form>
					<tbody>
						<tr>
							<th scope="col">신규 비밀번호 입력</th>
							<td><input type="password" class="input-text" name="pwd" placeholder="영문자로 시작하는 4~15자의 영문소문자,숫자" style="width:302px" /></td>
						</tr>
						<tr>
							<th scope="col">신규 비밀번호 재확인</th>
							<td><input type="password" class="input-text" name="pwd2" style="width:302px" /></td>
						</tr>
					</tbody>

				</table>
				<div class="box-btn">
					<input type="button" class="btn-l" name="pwdModify" value="확인">
				</div>
                </form>
			</div>
		</div>
	</div>
</div>

<?php
    include("footer.php");
    ?>