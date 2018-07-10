<?session_start()?>
<div class="closeMenu" ng-click="closeBonus()"></div>

<div class="slide-menu-header">
    <h1 class="text-center" style="padding-left: 44px;">보너스 내역</span></h1>
</div>

<div class="bonus-header" ng-controller="BonusMCompController">
    <h4>유저 콤프 적립현황</h4>

    <div class="bonus-body" ng-repeat="bonusHistory in bonusHistoryMainList | limitTo:5">
            <div class="bonus-left">
                <div class="bonus-title"><span>게임:</span></div>
                <div class="bonus-title"><span>베팅횟수:</span></div>
                <div class="bonus-title"><span>콤프:</span></div>
                <div class="bonus-title"><span>베팅날짜:</span></div>
            </div>
                <div class="bonus-name"><strong ng-bind="bonusHistory.GameName"></strong></div>
                <div class="bonus-name" ng-bind="bonusHistory.BetCount"></div>
                <div class="bonus-name-amount" ng-bind="bonusHistory.Comp"></div>
                <div class="bonus-name" ng-bind="bonusHistory.BetDate"></div>
                <div class="clear"></div>
    </div>
</div>

<div class="bonus-header" ng-controller="BonusFCompController">
    <h4>친구 콤프 적립현황</h4>

    <div class="bonus-body" ng-repeat="bonusHistory in bonusHistoryMainList | limitTo:5">
        <div class="bonus-left">
            <div class="bonus-title"><span>게임:</span></div>
            <div class="bonus-title"><span>베팅횟수:</span></div>
            <div class="bonus-title"><span>콤프:</span></div>
            <div class="bonus-title"><span>베팅날짜:</span></div>
        </div>
        <div class="bonus-name"><strong ng-bind="bonusHistory.GameName"></strong></div>
        <div class="bonus-name" ng-bind="bonusHistory.BetCount"></div>
        <div class="bonus-name-amount" ng-bind="bonusHistory.Comp"></div>
        <div class="bonus-name" ng-bind="bonusHistory.BetDate"></div>
        <div class="clear"></div>
    </div>
</div>




