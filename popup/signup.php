<div id="popup-signup" class="popup" ng-controller="SignUpController">
    <div class="popup-content">
        <div>
            <!--<h1>특별한 당신만을 위한,</h1>
            <h1><strong>파파카지노에</strong> 오신것을 환영합니다.</h1>
            <h5>지금 가입하시고 전세계 최고의 <strong>라이브 카지노, 스포츠베팅, 슬롯게임들을 파파카지노</strong>에서 만나보세요!</h5>-->

            <form name="signUp" novalidate ng-submit="processForm()">
                <div class="form-group" ng-class="{'has-error' : signUp.nickname.$invalid && !signUp.nickname.$pristine, 'no-error' : signUp.nickname.$valid}">
                    <label>아이디 <em>*</em></label>
                    <p><input type="text" placeholder="" class="form-control input-sm"
                              name="nickname"
                              ng-model="signForm.nickname"
                              ng-pattern="/^[A-z0-9]*$/"
                              maxlength="16"
                              ng-minlength="4"
                              ng-maxlength="16"
                              user-name-duplicated
                              required /></p>
                    <p class="error-message" ng-messages="signUp.nickname.$error" ng-if="signUp.nickname.$dirty">
                        <span ng-message="required">User ID is required.</span>
                        <span ng-message="minlength">User ID must be 4-16 (a-z, 0-9) characters.</span>
                        <span ng-message="maxlength">User ID is up to 16 characters only.</span>
                    </p>
                    <p><span>아이디는 4~16자리 입니다.</span></p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group" ng-class="{'has-error' : signUp.password.$invalid && !signUp.password.$pristine, 'no-error' : signUp.password.$valid}">
                    <label>비밀번호 <em>*</em></label>
                    <p><input type="password" placeholder="" class="form-control input-sm"
                              name="password"
                              ng-model="signForm.password"
                              maxlength="16"
                              ng-minlength="6"
                              ng-maxlength="16"
                              required /></p>
                    <p class="error-message" ng-messages="signUp.password.$error" ng-if="signUp.password.$dirty">
                        <span ng-message="required">Password is required.</span>
                        <spanong ng-message="minlength">Password must be at least 6 characters.</spanong>
                        <span ng-message="maxlength">Password is up to 16 characters only.</span>
                    </p>
                    <p>
                        <span>패스워드는 6-16 자리 입니다.</span>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group" ng-class="{'has-error' : signUp.validPwd.$invalid && !signUp.validPwd.$pristine, 'no-error' : signUp.validPwd.$valid}">
                    <label>비밀번호 재입력 <em>*</em></label>
                    <p><input type="password" placeholder="" class="form-control input-sm"
                              name="validPwd"
                              ng-model="signForm.validPwd"
                              maxlength="16"
                              ng-minlength="6"
                              ng-maxlength="16"
                              valid-password-c
                              required /></p>
                    <p class="error-message" ng-messages="signUp.validPwd.$error" ng-if="signUp.validPwd.$dirty">
                        <span ng-message="required">Password is required.</span>
                        <span ng-message="minlength">Password must be at least 6 characters.</span>
                        <span ng-message="maxlength">Password is up to 16 characters only.</span>
                        <span ng-message="noMatch">Passwords do not match!</span>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group" ng-class="{'has-error' : signUp.name.$invalid && !signUp.name.$pristine, 'no-error' : signUp.name.$valid}">
                    <label>이름 <em>*</em></label>
                    <p><input type="text" placeholder="" class="form-control input-sm"
                              name="name"
                              ng-model="signForm.name"
                              ng-pattern="/^[A-z0-9]*$/"
                              maxlength="16"
                              ng-minlength="4"
                              ng-maxlength="16"
                              required /></p>
                    <p class="error-message" ng-messages="signUp.name.$error" ng-if="signUp.name.$dirty">
                        <span ng-message="required">Name is required.</span>
                        <span ng-message="minlength">Name must be 4-16 (a-z, 0-9) characters.</span>
                        <span ng-message="maxlength">Name is up to 16 characters only.</span>
                    </p>
                    <p><span>이름은 한글 2-5 자리 입니다.</span></p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group" ng-class="{'has-error' : signUp.phone.$dirty || signUp.phone.$invalid && !signUp.phone.$pristine, 'no-error' : signUp.phone.$valid}">
                    <label>전화번호 <em>*</em></label>
                    <p><input type="text" placeholder="000-0000-0000" class="form-control input-sm"
                              ng-model="signForm.phone"
                              required /></p>
                    <p><button type="button" class="btn btn-sms">핸드폰 인증</button></p>
                    <div class="clearfix"></div>
                </div>
<!--                <div class="form-group" ng-class="{'has-error' : signUp.cNumber.$invalid && !signUp.cNumber.$pristine, 'no-error' : signUp.cNumber.$valid}">
                    <label>인증번호 <em>*</em></label>
                    <p><input type="text" placeholder="" class="form-control input-sm"
                              ng-model="signForm.cNumber"
                              required /></p>
                    <p class="error-message" ng-messages="signUp.cNumber.$error" ng-if="signUp.cNumber.$dirty">
                        <span ng-message="required">Confirmation number is required.</span>
                    </p>
                    <div class="clearfix"></div>
                </div>-->
                <div class="form-group" ng-class="{'has-error' : signUp.referrerNickName.$error.duplicated && signUp.referrerNickName.$dirty, 'not-used' : signUp.referrerNickName.$pristine, 'no-error' : signUp.referrerNickName.$valid}">
                    <label>추천인</label>
                    <p><input type="text" placeholder="" class="form-control input-sm"
                              name="referrerNickName"
                              ng-model="signForm.referrerNickName" /></p>
                    <p class="error-message" ng-messages="signUp.referrerNickName.$error.duplicated" ng-if="signUp.referrerNickName.$dirty">
                        <span ng-message="required">Referrer ID does not exists.</span>
                    </p>
                    <p>
                        <span>ID가 없으시면 비워두셔도 됩니다.</span>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <button type="submit" class="btn btn-block" ng-disabled="signUp.$invalid || isProcessing">가입 신청</button>
            </form>
        </div>
    </div>
</div>
