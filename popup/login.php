<?session_start()?>
<div id="popup-login" class="popup" ng-controller="LoginController">
    <div class="popup-heading">
        <h1>이용 권한이 없습니다</h1>
    </div>
    <div class="login-logo"></div>
    <div class="popup-content">
        <div class="login-form text-center">
            <!--<h1>이용 권한이 없습니다. <br />로그인후 이용해주세요.</h1>-->

            <form ng-submit="processForm()">
                <input type="text" class="inputUsername" name="nickname" ng-model="loginForm.nickname" placeholder="아이디" />
                <input type="password" class="inputPassword" name="password" ng-model="loginForm.password" placeholder="비밀번호" />
                <button type="submit" class="btn btn-login btn-default" ng-disabled="isProcessing">로그인</button>
                <button type="button" class="btn btn-signup" ng-click="displaySignUp()">회원가입</button>
            </form>
            <div class="clear"></div>
            <a href="#" onclick="alert('고객센터로 문의 바랍니다.')">비밀번호를 잊으셨나요?</a>
        </div>
    </div>
</div>
