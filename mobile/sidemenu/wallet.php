<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/detect_mobile.php";
$mobile_detect = new Mobile_Detect;
session_start();
?>
<div class="closeMenu" ng-click="closePanel()"></div>

<div class="slide-menu-header">
    <h1 style="padding-left: 44px;">모바일 게임 <span>바로 시작하실 수 있습니다</span></h1>
</div>

<div ng-init="getBalance()" >
    <div class="slide-wallet-items" ng-repeat="agentGsp in agentGspList">
        <?if($mobile_detect->isAndroidOS()){?>
            <div class="wallet-item-box"  ng-if="agentGsp.androidEnable" >
                <strong ng-bind="agentGsp.gspName"></strong>
                <h2  ng-show="agentGsp.amount == 'Loading'" ng-bind="agentGsp.amount"></h2>
                <h2  ng-show="agentGsp.amount != 'Loading'" ng-bind="agentGsp.amount | customCurrency:cc_currency_symbol[userCurrency]"></h2>
                <div class="clearfix"></div>
            </div>
        <?}else if($mobile_detect->isiOS()){?>
            <div class="wallet-item-box"  ng-if="agentGsp.iosEnable" >
                <strong ng-bind="agentGsp.gspName"></strong>
                <h2  ng-show="agentGsp.amount == 'Loading'" ng-bind="agentGsp.amount"></h2>
                <h2  ng-show="agentGsp.amount != 'Loading'" ng-bind="agentGsp.amount | customCurrency:cc_currency_symbol[userCurrency]"></h2>
                <div class="clearfix"></div>
            </div>
        <?}?>
    </div>

    <div class="slide-menu-header">
        <h1>PC 게임 <span>데스크탑에서 접속해주세요</span></h1>
    </div>
    <div class="slide-wallet-items">
        <div class="wallet-item-box" ng-repeat="agentGsp in agentGspList" ng-if="agentGsp.androidEnable == false || agentGsp.iosEnable == false">
            <strong ng-bind="agentGsp.gspName"></strong>
            <h2  ng-show="agentGsp.amount == 'Loading'" ng-bind="agentGsp.amount"></h2>
            <h2  ng-show="agentGsp.amount != 'Loading'" ng-bind="agentGsp.amount | customCurrency:cc_currency_symbol[userCurrency]"></h2>
            <div class="clearfix"></div>
        </div>
        <div class="wallet-item-box wallet-total">
            <strong>Total</strong>
            <h2 ng-show="totalBalance =='Loading'" ng-bind="totalBalance"></h2>
            <h2 ng-show="totalBalance !='Loading'" ng-bind="totalBalance | customCurrency:cc_currency_symbol[userCurrency]"></h2>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="slide-wallet-cat">
    <button type="button" class="btn-full-width" ng-click="openTransfer()">머니이동</button>
    <button type="button" ng-click="openDeposit()">입금신청</button>
    <button type="button" ng-click="openWithdraw()">출금신청</button>
    <button type="button" ng-click="openBonus()">보너스 히스토리</button>
    <button type="button" ng-click="getFriendList()">친구 목록</button>
    <button type="button" ng-click="openCoupon()">쿠폰 <strong class="ccount" ng-bind="couponCount"></strong></button>
    <button type="button" ng-click="loadHistory()">입출금 내역</button>
    <button type="button" ng-click="openAccount()">비밀번호 변경</button>
    <button type="button" ng-controller="LogoutController" ng-click="logout()" ng-disabled="isProcessing">로그아웃</button>
    <div class="clearfix"></div>
</div>
