<div class="content-header">
    <h1>라이브 카지노</h1>
    <strong>전세계 최고의 라이브 카지노 게임들을 파파카지노에서 만나보세요!</strong>
</div>
<div class="game-buttons livecasino-buttons" ng-click="playGame('1012','live');">
    <div class="gamebutton" >
        <div class="gamebutton1 game-button-wrapper" >
            <div class="game-button-play" >
                <h3>아시아 게이밍</h3>
                <p>Baccarat | Super98 Baccarat <br /> 7UP Baccarat | Dragon Tiger</p>
                <h4>
                    <button type="button" class="btn btn-play" ng-click="playGame('1012','live');">시작하기</button>
                    <button type="button" class="btn btn-icon"><i class="icon-ios"></i></button>
                    <button type="button" class="btn btn-icon"><i class="icon-android"></i></button>
                </h4>
            </div>
        </div>
    </div>

    <div class="gamebutton" ng-click="playGame('1000','live');">
        <div class="gamebutton2 game-button-wrapper">
            <div class="game-button-play">
                <h3>뉴 오퍼스 게임</h3>
                <p>Baccarat | Super98 Baccarat <br /> 7UP Baccarat | Dragon Tiger</p>
                <h4>
                    <button type="button" class="btn btn-play" ng-click="playGame('1000','live');">시작하기</button>
                    <button type="button" class="btn btn-icon"><i class="icon-ios"></i></button>
                    <button type="button" class="btn btn-icon"><i class="icon-android"></i></button>
                </h4>
            </div>
        </div>
    </div>
    <div class="gamebutton">
        <div class="gamebutton3 game-button-wrapper">
            <div class="game-button-play">
                <h3>마이크로게이밍</h3>
                <p>Traditional Baccarat | Parlay Baccarat | Multigame Baccarat</p>
                <h4>
                    <button type="button" class="btn btn-play" ng-click="playGame('1005','live');">시작하기</button>
                    <button type="button" class="btn btn-list btn-icon" ng-click="playGame('1005','playCheck');"><i class="icon-list"></i></button>
                    <button type="button" class="btn btn-icon"><i class="icon-android"></i></button>
                </h4>
            </div>
        </div>
    </div>
    <div class="gamebutton" ng-click="playGame('1014','live');">
        <div class="gamebutton4 game-button-wrapper">
            <div class="game-button-play">
                <h3>이주기 게임</h3>
                <p>Blackjack | Roulette | Baccarat  | Knockout Baccarat</p>
                <h4>
                    <button type="button" class="btn btn-play" ng-click="playGame('1014','live');">시작하기</button>
                </h4>
            </div>
        </div>
    </div>
    <div class="gamebutton" ng-click="playGame('1009','live');">
        <div class="gamebutton5 game-button-wrapper">
            <div class="game-button-play">
                <h3>신천지 로얄</h3>
                <p>Baccarat | Super98 Baccarat <br /> 7UP Baccarat | Dragon Tiger</p>
                <h4>
                    <button type="button" class="btn btn-play" ng-click="playGame('1009','live','','','');">시작하기</button>
                </h4>
            </div>
        </div>
    </div>

</div>
<div class="clear"></div>
<div class="free-game">
    <div>
        <h3>20만원 무료체험</h3>
        <p>지금 무료로 게임을 즐겨보세요!</p>
    </div>
    <button type="button" class="btn">시작하기</button>
</div>
<div class="coupon">
    <div>
        <form>
            <input type="text" placeholder="쿠폰 번호 입력" />
            <select>
                <option>게임 선택</option>
            </select>
            <button type="submit" class="btn">쿠폰 입력</button>
        </form>
        <p>한 IP당 1번 쿠폰을 사용하실 수 있습니다.</p>
    </div>
</div>
<div class="clear"></div>
<div class="jackpot jackpot-casino" onclick="location.href='#slots'" ng-click="navSlots()">
    <p>짜릿한 애니메이션과 화려한 3D효과! 프로그레시브 잭팟의 영광에 도전하세요!</p>
    <div class="pjackpot"></div>
</div>
<form id="frm_game" name="frm_game" method="post" action="/api/system/GetAgentProductGspGameList.php">
    <input id="_game" name="_game" type="hidden">
    <input id="_type" name="_type" type="hidden">
    <input id="_code" name="_code" type="hidden">
    <input id="_view" name="_view" type="hidden">
    <input id="_name" name="_name" type="hidden">
</form>

<?if(!isset($_SESSION['MemberToken'])){?>
    <div class="transactions">
        <div class="tbl-data" >
            <h1>파파카지노에서 알려드립니다</h1>
            <p ng-repeat="announce in announceList | limitTo: 7">
                <span class="width30 text-center" ng-bind="formatDate(announce.WriteDate) | date:'yyyy-MM-dd'"></span>
                <span class="width68 txt-white text-left" ng-bind="announce.Subject"></span>
            </p>
        </div>
        <div class="tbl-data">
            <h1>실시간 입금 현황</h1>
            <p ng-repeat="realTimeTransaction in realTimeTransactionList" ng-show="realTimeTransaction.Type==1">
                <span class="width35"  ng-bind="formatDate(realTimeTransaction.Date) | date:'yyyy-MM-dd H:mm'"></span>
                <span class="width25  txt-gold text-right" ng-bind="realTimeTransaction.Amount"></span>
                <span class="width25" ng-bind="realTimeTransaction.Member_id"></span>
            </p>
        </div>
        <div class="tbl-data">
            <h1>실시간 출금 현황</h1>
            <p ng-repeat="realTimeTransaction in realTimeTransactionList" ng-show="realTimeTransaction.Type==1">
                <span class="width35" ng-bind="formatDate(realTimeTransaction.Date) | date:'yyyy-MM-dd H:mm'"></span>
                <span class="width25  txt-gold text-right" ng-bind="realTimeTransaction.Amount"></span>
                <span class="width25" ng-bind="realTimeTransaction.Member_id"></span>
            </p>
        </div>
    </div>
<?}else{?>

<?}?>
