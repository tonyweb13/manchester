<?session_start()?>
<div class="closeMenu" ng-click="closeLogin()"></div>

<div class="login-container" ng-controller="LoginController">
    <h1 onclick="location.href='/mobile/#/'"><img src="common/images/logo-signup.png" /></h1>
    <form ng-submit="processForm()">
        <div class="form-group">
            <input type="text" name="nickname" ng-model="loginForm.nickname" class="form-control" placeholder="아이디" />
        </div>
        <div class="form-group">
            <input type="password" name="password" ng-model="loginForm.password" class="form-control" placeholder="비밀번호" />
        </div>
        <button type="submit" class="btn" ng-disabled="isProcessing">로그인</button>
        <p>아직 회원이 아니시라면? <a href="" ng-click="openSignUp()">회원가입</a></p>

        <a href="/mobile/pages/view.php?view=desktop" class="view-desktop">데스크탑 버전 보기</a>
    </form>
</div>