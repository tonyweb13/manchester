<?php session_start(); ?>
<div class="closeMenu" ng-click="closeAccount()"></div>

<div class="slide-menu-header">
    <h1 class="text-center" style="padding-left: 44px;">Change Password</span></h1>
</div>

<div ng-controller="ChangePasswordController">
    <form novalidate  ng-submit="processForm()">
        <div class="form-group">
            <label>현재 패스워드 <em>*</em></label>
            <input type="password" class="form-control input-sm" ng-model="changePwd.password"  />
        </div>
        <div class="form-group">
            <label>새로운 패스워드 <em>*</em></label>
            <input type="password" class="form-control input-sm" ng-model="changePwd.newPassword" />
        </div>
        <div class="form-group">
            <label>새로운 패스워드 재입력 <em>*</em></label>
            <input type="password" class="form-control input-sm" ng-model="changePwd.newConfirmPassword" />
        </div>

        <button type="submit" class="btn btn-form" ng-disabled="isProcessing">비밀번호 변경</button>
    </form>
</div>
