<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";
$mobile_detect = new Mobile_Detect;?>
<div class="gamebutton-container livecasino-buttons" ng-controller="CasinoController" ng-init="init()">
    <div class="gamebutton-wrapper">
        <div id="livecasino-buttons-3" class="gamebuttons">

            <div ng-include="'pages/promoSnippet.php'"></div>
            <?if($mobile_detect->isiOS()){?>
                <div class="gamebutton gamebutton1"  ng-click="playGame(112,10)">
                    <div class="gamebutton-content">
                        <h2 ng-bind="'UC8' | translate"></h2>
                        <p ng-bind="'Unforgettable experience with the best live casino games online' | translate"></p>
                        <button type="button" ng-bind="'Play Game' | translate"></button>
                    </div>
                </div>
                <div class="gamebutton gamebutton2" ng-click="CasinoCommingSoon()">
                    <div class="gamebutton-content">
                        <h2 ng-bind="'Asia Gaming' | translate"></h2>
                        <p ng-bind="'Unforgettable experience with the best live casino games online' | translate"></p>
                        <button type="button" ng-bind="'Install IOS App' | translate"></button>
                    </div>
                </div>
            <?}else{?>
                <div class="gamebutton gamebutton1" ng-click="playGame(112,10)">
                    <div class="gamebutton-content">
                        <h2 ng-bind="'UC8' | translate"></h2>
                        <p ng-bind="'Unforgettable experience with the best live casino games online' | translate"></p>
                        <button type="button" ng-bind="'Play Game' | translate"></button>
                    </div>
                </div>
                <div class="gamebutton gamebutton2" ng-click="CasinoCommingSoon()">
                    <div class="gamebutton-content">
                        <h2 ng-bind="'Gold Deluxe' | translate"></h2>
                        <p ng-bind="'Get the best online casino platform for Baccarat' | translate"></p>
                        <button type="button" ng-bind="'Play Now' | translate"></button>
                    </div>
                </div>
                <?if(isset($_SESSION['accessToken'])){?>
                    <div class="gamebutton gamebutton3" ng-href="http://mobile-resigner.valueactive.eu/launch88livedealer/apk?btag1=77164463&btag2=<?=$_SESSION['agentBTag']?>">
                        <div class="gamebutton-content">
                            <h2 ng-bind="'Microgaming' | translate"></h2>
                            <p ng-bind="'Get the best online casino platform for Baccarat' | translate"></p>
                            <button type="button" ng-bind="'Play Now' | translate"></button>
                        </div>
                    </div>
                <?}else{?>
                    <div class="gamebutton gamebutton3" ng-click="needLogin()">
                        <div class="gamebutton-content">
                            <h2 ng-bind="'Microgaming' | translate"></h2>
                            <p ng-bind="'Get the best online casino platform for Baccarat' | translate"></p>
                            <button type="button" ng-bind="'Play Now' | translate"></button>
                        </div>
                    </div>
                <?}?>
            <?}?>
            <?//if($mobile_detect->isAndroidOS()){?>
<!--                <div class="gamebutton gamebutton{{$index+1}}" ng-repeat="casinoGame in getAgentProductCasinoGameList">
                    <div class="gamebutton-content">
                        <h2 ng-bind="casinoGame.gspName | translate"></h2>
                        <p>Get the best online casino platform for Baccarat!</p>
                        <button type="button" ng-click="playGame(casinoGame.gspNo,10)">Play Now</button>
                    </div>
                </div>-->
            <?//}else if($mobile_detect->isiOS()){?>
<!--                <div class="gamebutton gamebutton{{$index+1}}" ng-repeat="casinoGame in getAgentProductCasinoGameList">
                    <div class="gamebutton-content">
                        <h2 ng-bind="casinoGame.gspName | translate"></h2>
                        <p>Get the best online casino platform for Baccarat!</p>
                        <button type="button" ng-click="playGame(casinoGame.gspNo,10)">Play Now</button>
                    </div>
                </div>-->
            <?//}?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>