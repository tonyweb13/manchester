<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";
if(isset($_SESSION["viewDesktop"])){
    unset($_SESSION["viewDesktop"]);
}
?>
<!DOCTYPE html>
<html ng-app="mobileApp">
<head>
    <meta charset="utf-8" />
    <title>PAPA CASINO</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimal-ui" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <link rel="icon" sizes="114x114" href="common/images/splash/splash-icon.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="common/images/splash/splash-icon.png">
    <link rel="apple-touch-startup-image" href="common/images/splash/splash-screen.png" media="screen and (max-device-width: 320px)" />
    <link rel="apple-touch-startup-image" href="common/images/splash/splash-screen@2x.png" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" />
    <link rel="apple-touch-startup-image" sizes="640x1096" href="common/images/splash/splash-screen@3x.png" />
    <link rel="apple-touch-startup-image" sizes="1024x748" href="common/images/splash/splash-screen-ipad-landscape.png" media="screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : landscape)" />
    <link rel="apple-touch-startup-image" sizes="768x1004" href="common/images/splash/splash-screen-ipad-portrait.png" media="screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : portrait)" />
    <link rel="apple-touch-startup-image" sizes="1536x2008" href="common/images/splash/splash-screen-ipad-portrait-retina.png" media="(device-width: 768px)  and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)"/>
    <link rel="apple-touch-startup-image" sizes="1496x2048" href="common/images/splash/splash-screen-ipad-landscape-retina.png" media="(device-width: 768px) and (orientation: landscape)    and (-webkit-device-pixel-ratio: 2)"/>

    <link rel="stylesheet" href="common/css/bootstrap.css">
    <link rel="stylesheet" href="common/css/ngDialog.css">
    <link rel="stylesheet" href="common/css/ngDialog-theme-default.css">
    <link rel="stylesheet" href="common/css/style.css">
    <link rel="stylesheet" href="common/css/responsive.css">
    <link rel="stylesheet" href="common/css/responsive-thumbnails.css">
    <link rel="stylesheet" href="common/css/intlTelInput.css">
    <link rel="stylesheet" href="../common/css/sweetalert.css">

    <link rel="stylesheet" href="common/css/add2Home.css">
    <script type="text/javascript" src="common/js/addtohomescreen.js"></script>

</head>
<?if(isset($_SESSION['MemberToken'])){?>
    <body ontouchstart="" ng-controller="CommonController" ng-init="init(true);">
<?}else{?>
    <body ontouchstart="" ng-controller ="CommonController" ng-init="init(false);">
<?}?>
<div class="cover" ng-click="closePanel()"></div>

<div id="header-container" class="navbar-fixed-top">
    <div class="logo" onclick="location.href='/mobile/#/'" role="button"></div>
    <?php if(!isset($_SESSION['MemberToken'])){?>
        <button type="button" class="guest btn-skewed btn-skew-top-left" ng-click="openLogin()">로그인</button>
        <button type="button" class="guest btn-skewed btn-skew-top-right" ng-click="openSignUp()">회원가입</button>
    <?}else{?>
        <button type="button" class="user btn-skewed btn-skew-top-left" ng-click="getBalance()">마이월렛</button>
        <button type="button" class="user btn-skewed btn-skew-top-right" ng-controller="LogoutController" ng-click="logout()" ng-disabled="isProcessing">로그아웃</button>
    <?}?>
</div>
<div class="navbar-fixed-bottom">
        <button type="button" class="btn-skewed btn-skew-bottom-left" ng-click="openDeposit()">입금신청</button>
        <button type="button" class="btn-skewed btn-skew-bottom-right" ng-click="openWithdraw()">출금신청</button>
</div>

<div id="masthead-container">

</div>
<div class="container livecasino">
    <h1>라이브 카지노</h1>
    <?if($mobile_detect->isAndroidOS()){?>
    <div id="gamebutton-2" class="game-buttons livecasino-buttons">
        <div class="gamebutton-wrapper" ng-click="playGame(1012,'live','',true)">
            <div class="gamebutton gamebutton1">
                <div class="gamebutton-play">
                    <h3>아시아 게이밍 다운로드</h3>
                    <p>BACCARAT | SUPER98 BACCARAT | 7UP BACCARAT</p>
                </div>
                <div class="gamebutton-overlay"></div>
            </div>
        </div>
        <div class="gamebutton-wrapper" ng-click="playGame(1012,'live','',false)">
            <div class="gamebutton gamebutton4">
                <div class="gamebutton-play">
                    <h3>아시아 게이밍 무설치</h3>
                    <p>BACCARAT | SUPER98 BACCARAT | 7UP BACCARAT</p>
                </div>
                <div class="gamebutton-overlay"></div>
            </div>
        </div>
    </div>
    <div id="gamebutton-2" class="game-buttons livecasino-buttons">
            <div class="gamebutton-wrapper" ng-click="playGame(1000,'live')">
                <div class="gamebutton gamebutton2">
                    <div class="gamebutton-play">
                        <h3>뉴 오퍼스 게임</h3>
                        <p>BACCARAT | SUPER98 BACCARAT | DRAGON TIGER</p>
                    </div>
                </div>
                <div class="gamebutton-overlay"></div>
            </div>
            <div class="gamebutton-wrapper" ng-click="playGame(1005,'live')">
                <div class="gamebutton gamebutton3">
                    <div class="gamebutton-play">
                        <h3>마이크로게이밍 라이브 카지노</h3>
                        <p>TRADITIONAL BACCARAT | PARLAY BACCARAT | MULTIGAME BACCARAT</p>
                    </div>
                    <div class="gamebutton-overlay"></div>
                </div>
            </div>
        <div class="clearfix"></div>
    </div>


    <?}else if($mobile_detect->isiOS()){
        if(!isset($_SESSION['MemberToken'])){?>
            <div id="gamebutton-2" class="game-buttons livecasino-buttons" >
                <a class="gamebutton-wrapper"  ng-click="openLogin()">
                    <div class="gamebutton gamebutton1" >
                        <div class="gamebutton-play">
                            <h3>아시아 게이밍 다운로드</h3>
                            <p>BACCARAT | SUPER98 BACCARAT | 7UP BACCARAT</p>
                        </div>
                        <div class="gamebutton-overlay"></div>
                    </div>
                </a>
                <a class="gamebutton-wrapper"  ng-click="openLogin()">
                    <div class="gamebutton gamebutton4" >
                        <div class="gamebutton-play">
                            <h3>아시아 게이밍 무설치</h3>
                            <p>BACCARAT | SUPER98 BACCARAT | 7UP BACCARAT</p>
                        </div>
                        <div class="gamebutton-overlay"></div>
                    </div>
                </a>
                <div class="clearfix"></div>
            </div>
        <?}else{?>
            <div id="gamebutton-2" class="game-buttons livecasino-buttons" >
                <a class="gamebutton-wrapper"  ng-href="http://agmbet.com" target="_blank">
                    <div class="gamebutton gamebutton1" >
                        <div class="gamebutton-play">
                            <h3>아시아 게이밍 다운로드</h3>
                            <p>BACCARAT | SUPER98 BACCARAT | 7UP BACCARAT</p>
                        </div>
                        <div class="gamebutton-overlay"></div>
                    </div>
                </a>
                <a class="gamebutton-wrapper"  href="../api/player/PlayGame?gspNo=1012&productType=live" target="_self">
                    <div class="gamebutton gamebutton4" >
                        <div class="gamebutton-play">
                            <h3>아시아 게이밍 무설치</h3>
                            <p>BACCARAT | SUPER98 BACCARAT | 7UP BACCARAT</p>
                        </div>
                        <div class="gamebutton-overlay"></div>
                    </div>
                </a>
                <div class="clearfix"></div>
            </div>
        <?}?>
    <?}?>
</div>

<div class="container">
    <h1>스포츠 베팅</h1>
    <div id="sportsbutton-2" class="game-buttons">
        <div class="gamebutton-wrapper" ng-click="playGame('1018','sports')">
            <div class="gamebutton sportsbutton1" >
                <div class="gamebutton-play">
                    <h3>CMD 스포츠</h3>
                    <p>유명한 아시안뷰 스포츠 베팅이 이제 이곳에서 가능합니다.</p>
                </div>
                <div class="gamebutton-overlay"></div>
            </div>
        </div>
        <div class="gamebutton-wrapper" ng-click="playGame('1016','sports')">
            <div class="gamebutton sportsbutton2" >
                <div class="gamebutton-play">
                    <h3>ASC 스포츠</h3>
                    <p>말레이시아/인도/홍콩 배당률로 만나는 18,500 이상의 라이브 경기</p>
                </div>
                <div class="gamebutton-overlay"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

</div>
<div class="container" ng-controller="SlotController" ng-init="init()">
    <h1>
        슬롯게임

        <div class="jackpot-small">
            <p>
                <strong>PROGRESSIVE</strong>
                <strong>JACKPOT</strong>
            </p>
            <em></em>
            <div class="pjackpot2"></div>
        </div>
    </h1>

    <div class="clearfix"></div>
    <div id="nav-slot">
        <ul id="nav-slot-list">
            <li class="nav-slot-tab active" ng-click="loadSlot('1005')">마이크로게이밍</li>
            <li class="nav-slot-tab" ng-click="loadSlot(1000)">뉴오퍼스</li>
            <li class="nav-slot-tab" ng-click="comingSoon()">벳소프트</li>
        </ul>
    </div>
    <div>
        <div class="slot-wrapper">
            <?if($mobile_detect->isAndroidOS()){?>
            <div class="slot-banner">
                    <div class="slot-text"><span>다운로드</span></div>
                    <div id="gamebutton-1" class="game-buttons slots-buttons">
                        <div class="gamebutton-wrapper" ng-click="playGame(1005,'slot','',true)">
                            <div class="gamebutton slot-gamebutton1">
                                <div class="gamebutton-play">
                                    <h3>마이크로게이밍 슬롯 다운로드</h3>
                                    <p>전용 앱을 다운로드 받으시면 더 쾌적한 슬롯게임 플레이가 가능합니다.</p>
                                </div>
                                <div class="gamebutton-overlay"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                <div class="slot-text"><span>바로 실행</span></div>
            </div>
            <?}?>
            <ul class="responsive-thumbnails" data-max-width="120" data-padding="4" data-max-height="130">
                <li ng-repeat="slot in gspSlotItems[gspNo] | filter:slotFilter" ng-click="playGame(slot.game,'slot',slot.GameCode,false)">
                    <div class="slot-item" ng-if="gspNo == 1005" ng-style="{'background': 'url(' + slot.image + ') 0 0 no-repeat','background-size': '200%'}">
                        <span class="slot-title slot-{{gspNo}}" ng-bind="slot.GameName"></span>
                    </div>
                    <div class="slot-item" ng-if="gspNo != 1005" ng-style="{'background': 'url(' + slot.image + ') center center no-repeat', 'background-size': '100%'}">
                        <span class="slot-title slot-{{gspNo}}" ng-bind="slot.GameName"></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<footer></footer>

<?php if(!isset($_SESSION['MemberToken'])){?>
<div id="slide-login"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/login.php'"></div>

<div id="slide-signup"
     class="slide-menu slide-menu-close-right"
     ng-include="'sidemenu/signup.php'"></div>

<?}else{?>
<div id="slide-wallet"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/wallet.php'"></div>

<div id="slide-deposit"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/deposit.php'"></div>

<div id="slide-withdraw"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/withdraw.php'"></div>

<div id="slide-transfer"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/transfer.php'"></div>

<div id="slide-bonus"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/bonus.php'"></div>

<div id="slide-friends"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/friends.php'"></div>

<div id="slide-coupon"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/coupon.php'"></div>

<div id="slide-cashHistory"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/history.php'"></div>

<div id="slide-account"
     class="slide-menu slide-menu-close-left"
     ng-include="'sidemenu/account.php'"></div>
<?}?>


<!--Scripts-->
<script type="text/javascript" src="common/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="common/js/angular.min.js"></script>
<![if !IE 8]>
<script type="text/javascript" src="../common/js/jquery-sweet-alert.min.js"></script>
<![endif]>
<script type="text/javascript" src="../common/js/angular-module-currencyCode.min.js"></script>
<script type="text/javascript" src="../common/js/jquery-browser.min.js"></script>
<script type="text/javascript" src="../common/js/jquery-intlTelInput.js"></script>
<script type="text/javascript" src="../common/js/jquery-moment.min.js"></script>
<script type="text/javascript" src="../common/js/jquery-moment-timezone.min.js"></script>
<script type="text/javascript" src="../common/js/jstz-1.0.4.min.js"></script>
<script type="text/javascript" src="../common/js/ngDialog.js"></script>

<script type="text/javascript" src="common/js/angular-messages.js"></script>
<script type="text/javascript" src="common/js/angular-custom.js"></script>
<script type="text/javascript" src="../common/js/angular-cookies.min.js"></script>
<script type="text/javascript" src="../common/js/angular-custom-module.js"></script>
<script type="text/javascript" src="../common/js/angular-custom-signup.js"></script>
<script type="text/javascript" src="common/js/angular-custom-slots.js"></script>
<script type="text/javascript" src="common/js/angular-custom-wallet.js"></script>

<script type="text/javascript" src="common/js/jquery-bootstrap.min.js"></script>
<script type="text/javascript" src="common/js/es5-shim.js"></script>
<script type="text/javascript" src="common/js/jquery-easing.min.js"></script>

<script type="text/javascript" src="common/js/jquery-responsive-thumbnails.js"></script>
<script type="text/javascript" src="common/js/jquery-jOdometer.min.js"></script>
<script type="text/javascript" src="common/js/jquery-custom.js"></script>
</body>
</html>