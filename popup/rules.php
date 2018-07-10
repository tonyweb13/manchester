<div id="popup-customer" class="popup" ng-controller="RulesController" ng-init="setTab(selectRulesTab)">
    <div class="popup-heading">
        <h1>파파카지노 <strong>고객센터</strong></h1>
    </div>
    <div class="popup-tabs">
        <ul class="popTabs">
            <li id="customerTab1"     ng-class="{ active:isSet(1) }"  ng-click="setTab(1)"><strong>바카라</strong>     <span>Baccarat</span></li>
            <li id="customerTab2"     ng-class="{ active:isSet(2) }"  ng-click="setTab(2)"><strong>블랙잭</strong>     <span>Blackjack</span></li>
            <li id="customerTab3"     ng-class="{ active:isSet(3) }"  ng-click="setTab(3)"><strong>룰렛</strong>       <span>Roulette</span></li>
            <li id="customerTab4"     ng-class="{ active:isSet(4) }"  ng-click="setTab(4)"><strong>슬롯머신</strong>    <span>Slot Machine</span></li>
        </ul>
        <div class="clear"></div>
        <div ng-show="isSet(1)" class="popup-content">
            <img src="http://kat.front888.com/manchester/common/img/rules-baccarat.png" />
        </div>
        <div ng-show="isSet(2)" class="popup-content">
            <img src="http://kat.front888.com/manchester/common/img/rules-blackjack.png" />
        </div>
        <div ng-show="isSet(3)" class="popup-content">
            <img src="http://kat.front888.com/manchester/common/img/rules-roulette.png" />
        </div>
        <div ng-show="isSet(4)" class="popup-content">
            <img src="http://kat.front888.com/manchester/common/img/rules-slotmachine.png" />
        </div>
    </div>
</div>
