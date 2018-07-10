<div ng-controller="SlotController" ng-init="init()">
    <div class="content-header">
        <h1>슬롯 게임</h1>
        <strong>짜릿한 애니메이션과 화려한 3D효과! 프로그레시브 잭팟의 영광에 도전하세요!</strong>

        <div class="jackpot-small">
            <div class="pjackpot2"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <ul class="game-buttons slot-game-buttons">
        <li class="gamebutton active"  ng-click="loadSlot('1005')">
            <div class="slot-gamebutton1 game-button-wrapper">
                <div class="game-button-play">
                    <h3>마이크로게이밍</h3>
                    <button type="button" class="btn btn-play">시작하기</button>
                </div>
            </div>
        </li>
        <li class="gamebutton" ng-click="loadSlot(1000)">
            <div class="slot-gamebutton2 game-button-wrapper">
                <div class="game-button-play">
                    <h3>뉴 오퍼스</h3>
                    <button type="button" class="btn btn-play">시작하기</button>
                </div>
            </div>
        </li>
        <li class="gamebutton no-margin" ng-click="loadSlot(1004)">
            <div class="slot-gamebutton3 game-button-wrapper">
                <div class="game-button-play">
                    <h3>벳 소프트</h3>
                    <button type="button" class="btn btn-play">시작하기</button>
                </div>
            </div>
        </li>
        <div class="clear"></div>
    </ul>
    <div class="sub-gamebutton slot-sub-gamebutton"  ng-show="gspNo == 1005">
        <ul>
            <li class="slot-1005-first active" ng-click="loadSlot(1005,'Advanced_Slot')">Advance Slots</li>
            <li ng-click="loadSlot(1005,'Bonus_Slot')">Bonus Slot</li>
            <li ng-click="loadSlot(1005,'Feature_Slot')">Feature Slot</li>
            <li ng-click="loadSlot(1005,'Video_Slot')">Video Slot</li>
            <li ng-click="loadSlot(1005,'Slot')">Slot</li>
            <li ng-click="loadSlot(1005,'Casual_Game')">Casual</li>
            <li ng-click="loadSlot(1005,'Scratch_Card')">Scratch Card</li>
            <li ng-click="loadSlot(1005,'Video_Poker')">Video Poker</li>
            <li ng-click="loadSlot(1005,'Table_Games')">Table</li>
        </ul>
    </div>
    <div class="sub-gamebutton slot-sub-gamebutton" ng-show="gspNo == 1000">
        <ul>
            <li class="slot-1000-first active" ng-click="loadSlot(1000,'Slots_3d')">Slots 3D</li>
            <li ng-click="loadSlot(1000,'Slots')">Slots</li>
            <li ng-click="loadSlot(1000,'Arcades')">Arcades</li>
            <li ng-click="loadSlot(1000,'Card_Games')">Card Games</li>
            <li ng-click="loadSlot(1000,'Table_Games')">Table Games</li>
            <li ng-click="loadSlot(1000,'Video_Poker')">Video Poker</li>
        </ul>
    </div>
    <div class="sub-gamebutton slot-sub-gamebutton"  ng-show="gspNo == 1004">
        <ul>
            <li class="slot-1004-first active" ng-click="loadSlot(1004,'Slots')">Slots</li>
            <li ng-click="loadSlot(1004,'Soft_Games')">Soft Games</li>
            <li ng-click="loadSlot(1004,'Keno')">Keno</li>
            <li ng-click="loadSlot(1004,'Table_Games')">Table Games</li>
            <li ng-click="loadSlot(1004,'Video_Poker')">Video Pokert</li>
            <li ng-click="loadSlot(1004,'Multihand_Poker')">Multihand Poker</li>
            <li ng-click="loadSlot(1004,'Pyramid_Poker')">Pyramid Poker</li>
        </ul>
    </div>

    <div class="clear"></div>
    <div class="slot-wrapper">
        <div class="slot-items">
            <div class="slot-box" ng-repeat="slot in gspSlotItems[gspNo] | filter:slotFilter" ng-click="playGame(slot.game,'slot',slot.GameCode)">
                <div class="slot-item slot-{{gspNo}}" ng-style="{'background': 'url(' + slot.image + ') 0 0 no-repeat'}">
                    <p class="text-ellipsis" ng-bind="slot.GameName"></p>
                </div>
            </div>
        </div>
    </div>
</div>
