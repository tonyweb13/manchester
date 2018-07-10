<div class="closeMenu" ng-click="closeSignUp()"></div>

<div class="signup-container" ng-controller="SignUpController">
    <h1><img src="common/images/logo-signup.png" /></h1>
    <h3>지금 가입하시고 전세계 최고의 라이브 카지노, 스포츠베팅, 슬롯게임들을 파파카지노에서 만나보세요!</h3>

    <form name="signUp" novalidate ng-submit="processForm()">
        <div class="form-group" ng-class="{'has-error' : signUp.MemberID.$invalid && !signUp.MemberID.$pristine, 'no-error' : signUp.MemberID.$valid}">
            <p><input type="text" placeholder="아이디" class="form-control input-sm"
                      name="MemberID"
                      ng-model="signForm.MemberID"
                      ng-pattern="/^[A-z0-9]*$/"
                      maxlength="16"
                      ng-minlength="4"
                      ng-maxlength="16"
                      user-name-duplicated
                      required /></p>
            <p class="error-message" ng-messages="signUp.MemberID.$error" ng-if="signUp.MemberID.$dirty">
                <span ng-message="required">아이디는 필수값입니다.</span>
                <span ng-message="duplicated">이미 사용된 아이디 입니다.</span>
                <span ng-message="minlength">4자리 이상 입력해주세요.</span>
                <span ng-message="maxlength">16자리 이하로 입력해주세요</span>
            </p>
            <p><span>아이디는 4~16자리 입니다.</span></p>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" ng-class="{'has-error' : signUp.MemberPwd.$invalid && !signUp.MemberPwd.$pristine, 'no-error' : signUp.MemberPwd.$valid}">
            <p><input type="password" placeholder="비밀번호" class="form-control input-sm"
                      name="MemberPwd"
                      ng-model="signForm.MemberPwd"
                      maxlength="16"
                      ng-minlength="6"
                      ng-maxlength="16"
                      required /></p>
            <p class="error-message" ng-messages="signUp.MemberPwd.$error" ng-if="signUp.MemberPwd.$dirty">
                <span ng-message="required">패스워드는 필수값입니다.</span>
                <spanong ng-message="minlength">6자리 이상 입력해주세요</spanong>
                <span ng-message="maxlength">16자리 이하로 입력해주세요</span>
            </p>
            <p>
                <span>패스워드는 6-16 자리 입니다.</span>
            </p>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" ng-class="{'has-error' : signUp.MemberValidPwd.$invalid && !signUp.MemberValidPwd.$pristine, 'no-error' : signUp.MemberValidPwd.$valid}">
            <p><input type="password" placeholder="비밀번호 재입력" class="form-control input-sm"
                      name="MemberValidPwd"
                      ng-model="signForm.MemberValidPwd"
                      maxlength="16"
                      ng-minlength="6"
                      ng-maxlength="16"
                      valid-password-c
                      required /></p>
            <p class="error-message" ng-messages="signUp.MemberValidPwd.$error" ng-if="signUp.MemberValidPwd.$dirty">
                <span ng-message="required">패스워드는 필수값입니다.</span>
                <span ng-message="minlength">6자리 이상 입력해주세요</span>
                <span ng-message="maxlength">16자리 이하로 입력해주세요</span>
                <span ng-message="noMatch">패스워드가 맞지 않습니다.</span>
            </p>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" ng-class="{'has-error' : signUp.MemberName.$invalid && !signUp.MemberName.$pristine, 'no-error' : signUp.MemberName.$valid}">
            <p><input type="text" placeholder="이름" class="form-control input-sm"
                      name="MemberName"
                      ng-model="signForm.MemberName"
                      maxlength="16"
                      required /></p>
            <p class="error-message" ng-messages="signUp.MemberName.$error" ng-if="signUp.MemberName.$dirty">
                <span ng-message="required">이름은 필수값입니다.</span>
                <span ng-message="maxlength">5자리 이하로 입력해주세요</span>
            </p>
            <p><span>이름은 한글 2-5 자리 입니다.</span></p>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" ng-class="{'has-error' : signUp.MemberPhone.$dirty || signUp.MemberPhone.$invalid && !signUp.MemberPhone.$pristine, 'no-error' : signUp.MemberPhone.$valid}">
            <p><input type="text" placeholder="전화번호" class="form-control input-sm input-phone"
                      name="MemberPhone"
                      ng-model="signForm.MemberPhone"
                      required /></p>
            <p><button type="button" class="btn btn-sms" ng-click="sendSMS()">핸드폰 인증</button></p>
            <div class="clearfix"></div>
        </div>
        <div ng-show="isSend" class="form-group" ng-class="{'has-error' : signUp.VerifyCode.$invalid && !signUp.VerifyCode.$pristine, 'no-error' : signUp.VerifyCode.$valid}">
            <label>인증번호 <em>*</em></label>
            <p><input type="text" placeholder="" class="form-control input-sm"
                      name="VerifyCode"
                      ng-model="signForm.VerifyCode"
                      required /></p>
            <p class="error-message" ng-messages="signUp.VerifyCode.$error" ng-if="signUp.VerifyCode.$dirty">
                <span ng-message="required">인증번호가 필요합니다.</span>
            </p>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" ng-class="{'has-error' : signUp.MemberReferer.$error.duplicated && signUp.MemberReferer.$dirty, 'not-used' : signUp.MemberReferer.$pristine, 'no-error' : signUp.MemberReferer.$valid}">
            <p><input type="text" placeholder="추천인" class="form-control input-sm"
                      name="MemberReferer"
                      ng-model="signForm.MemberReferer" referrer-check/></p>
            <p class="error-message" ng-messages="signUp.MemberReferer.$error" ng-if="signUp.MemberReferer.$dirty">
                <span ng-message="duplicated">아이디를 찾을수 없습니다.</span>
            </p>
            <p>
                <span>ID가 없으시면 비워두셔도 됩니다.</span>
            </p>
            <div class="clearfix"></div>
        </div>
        <button type="submit" class="btn btn-signup" ng-disabled="signUp.$invalid || isProcessing">가입 신청</button>
    </form>

</div>