<div class="game-buttons main-gamebuttons">
    <div class="gamebutton" onclick="location.href='#casino'" ng-click="navCasino()">
        <div class="main-gamebutton1 game-button-wrapper">
            <div class="game-button-play">
                <div class="content-header">
                    <h1>라이브카지노</h1>
                    <strong>전세계 최고의 카지노 게임들을 만나보세요.</strong>
                    <button type="button" class="btn btn-play">시작하기</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="title-casino"></div>
            <div class="hover-casino"></div>
        </div>
    </div>
    <div class="gamebutton" onclick="location.href='#sports'" ng-click="navSports()">
        <i class="icon-new"></i>
        <div class="main-gamebutton2 game-button-wrapper">
            <div class="game-button-play">
                <div class="content-header">
                    <h1>스포츠베팅</h1>
                    <strong>국 내외 다양한 스포츠 베팅을 제공합니다.</strong>
                    <button type="button" class="btn btn-play">시작하기</button>
                </div>
            </div>
            <div class="title-sports"></div>
            <div class="hover-sports"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="jackpot" onclick="location.href='#slots'" ng-click="navSlots()">
    <!--    <p>짜릿한 애니메이션과 화려한 3D효과! 프로그레시브 잭팟의 영광에 도전하세요!</p>-->
    <p>화려한 애니메이션과 3D효과! 잭팟의 영광에 도전하세요!</p>
    <div class="pjackpot pjackpot-main"></div>
    <div class="title-slots"></div>
    <div class="hover-slots"></div>
</div>
<div class="transactions">
    <div class="tbl-data" >
        <h1>파파카지노에서 알려드립니다</h1>
        <p ng-repeat="announce in announceList | limitTo: 7">
            <span class="width30 text-center" ng-bind="formatDate(announce.WriteDate) | date:'yyyy-MM-dd'"></span>
            <span class="width68 txt-white text-left" ng-bind="announce.Subject | limitTo:20 " ng-click="displayCustomer(1); readBoardContent(announce.Type,announce.BoardCode)" style="cursor: pointer;"></span>
        </p>
    </div>
    <div class="tbl-data">
        <h1>실시간 입금 현황</h1>
        <p ng-repeat="realTimeTransaction in realTimeTransactionList | filter:{Type:1}">
            <span class="width35"  ng-bind="formatDate(realTimeTransaction.Date) | date:'yyyy-MM-dd H:mm'"></span>
            <span class="width25  txt-gold text-right" ng-bind="realTimeTransaction.Amount"></span>
            <span class="width25" ng-bind="realTimeTransaction.Member_id"></span>
        </p>
    </div>
    <div class="tbl-data">
        <h1>실시간 출금 현황</h1>
        <p ng-repeat="realTimeTransaction in realTimeTransactionList | filter:{Type:2}">
            <span class="width35" ng-bind="formatDate(realTimeTransaction.Date) | date:'yyyy-MM-dd H:mm'"></span>
            <span class="width25  txt-gold text-right" ng-bind="realTimeTransaction.Amount"></span>
            <span class="width25" ng-bind="realTimeTransaction.Member_id"></span>
        </p>
    </div>
</div>
