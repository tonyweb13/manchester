<?include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php"; ?>
<!doctype html>
<html class="no-js" lang="" ng-app="casinoApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Papa Casino</title>
        <meta name="description" content="">
        <!--<meta name="viewport" content="width=device-width">-->

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="common/css/reset.css">
        <link rel="stylesheet" href="common/css/owl.carousel.css">
        <link rel="stylesheet" href="common/css/owl.transitions.css">
        <link rel="stylesheet" href="common/css/owl.theme.css">
        <link rel="stylesheet" href="common/css/sweetalert.css">
        <link rel="stylesheet" href="common/css/ngDialog.css">
        <link rel="stylesheet" href="common/css/ngDialog-theme-default.css">
        <link rel="stylesheet" href="common/css/main.css">
        <link rel="stylesheet" href="common/css/style.css">
        <link rel="stylesheet" href="common/css/fonts/en.css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/nanumgothic.css">
    </head>
    <?
    if(isset($_SESSION['MemberToken'])){
        echo "<body ng-controller =\"CommonController\"  ng-class=\"RouteData.get('bodyClass')\"  ng-init=\"init(true);\">";

    }else{
        echo "<body  ng-controller =\"CommonController\"  ng-class=\"RouteData.get('bodyClass')\"  ng-init=\"init(false);\">";
    }
    ?>
        <div id="mobile-container"></div>
        <div class="content-overlay"></div>
        <div id="wrap">
            <div id="header-container">
                <div class="container">
                    <div class="logo"><a href="/#/" ng-click="navLogo()"><img src="common/img/logo.png" /></a></div>
                    <div id="nav-container" ng-controller="NavController">
                        <ul class="mainMenu">
                            <li class="navMobile" ng-click="navMobile()">모바일</li>
                            <li><a href="#casino" class="navCasino" ng-class="{active: isActive('/casino')}" ng-click="navCasino()">라이브카지노</a></li>
                            <?if(!isset($_SESSION['MemberToken'])){?>
                            <li><a class="navSports" ng-click="displayLogin()">스포츠베팅</a></li>
                            <?}else{?>
                            <li><a href="#sports" class="navSports" ng-class="{active: isActive('/sports')}" ng-click="navSports()">스포츠베팅</a></li>
                            <?}?>
                            <li><a href="#slots" class="navSlots" ng-class="{active: isActive('/slots')}" ng-click="navSlots()">슬롯게임</a></li>
                            <br class="clear" />
                        </ul>
                        <ul class="subMenu">
                            <?if(!isset($_SESSION['MemberToken'])){?>
                                <li ng-click="displayLogin()"><span>입금신청</span></li>
                                <li ng-click="displayLogin()"><span>출금신청</span></li>
                                <li ng-click="displayLogin()"><span>게임머니이동</span></li>
                                <li ng-click="displayLogin()"><span>프로모션 / 이벤트</span></li>
                                <li ng-click="displayLogin()"><span>게임이용방법</span></li>
                                <li ng-click="displayCustomer(1)"><span>고객센터</span></li>
                            <?}else{?>
                                <li ng-click="displayWallet(2)"><span>입금신청</span></li>
                                <li ng-click="displayWallet(3)"><span>출금신청</span></li>
                                <li ng-click="displayWallet(1)"><span>게임머니이동</span></li>
                                <li ng-click="displayCustomer(2)"><span>프로모션 / 이벤트</span></li>
                                <li ng-click="displayRules(1)"><span>게임이용방법</span></li>
                                <li ng-click="displayCustomer(4)"><span>고객센터</span></li>
                            <?}?>
                            <br class="clear" />
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div id="masthead-container">
                <div class="container">
                    <div id="main-promo-slider" class="promo-banner">
                        <div ng-click="displayCustomer(2)"><img src="common/img/promo1.png" /></div>
                        <div ng-click="displayCustomer(2)"><img src="common/img/promo2.png" /></div>
                        <div ng-click="displayCustomer(2)"><img src="common/img/promo3.png" /></div>
                        <div ng-click="displayCustomer(2)"><img src="common/img/promo4.png" /></div>
                        <div ng-click="displayCustomer(2)"><img src="common/img/promo5.png" /></div>
                    </div>

                    <div id="masthead-image"></div> <!--Main Page-->
                    <div id="masthead-image1"></div> <!--Casino Page-->
                    <div id="masthead-image2"></div> <!--Slots Page-->

                </div>
            </div>
            <div id="main-container" class="content-container">
                <div class="content">
                    <div class="left-panel" ng-view></div>
                    <div class="right-panel side-panel">
                        <div ng-controller="LoginController">
                        <?if(!isset($_SESSION['MemberToken'])){?>
                        <div id="guest">
                            <h5>멤버 로그인</h5>
                            <div id="login-container" class="side-content">
                                <form ng-submit="processForm()">
                                    <input type="text" class="inputUsername" name="nickname" ng-model="loginForm.nickname" placeholder="아이디" />
                                    <input type="password" class="inputPassword" name="password" ng-model="loginForm.password" placeholder="비밀번호" />
                                    <button type="submit" class="btn btn-login btn-default" ng-disabled="isProcessing">로그인</button>
                                    <button type="button" class="btn btn-signup" ng-click="displaySignUp()">회원가입</button>
                                </form>
                                <div class="clear"></div>
                                <!--<a href="" onclick="alert('고객센터로 문의 바랍니다.')">비밀번호를 잊으셨나요?</a>-->
                            </div>
                            <h5>프로모션</h5>
                        </div>
                        <?}else{?>
                        <div id="user">
                            <h4>Welcome, <strong><?=$_SESSION['MemberID']?></strong>!
                                <button ng-controller="LogoutController" type="button" class="btn-logout" ng-click="logout()" ng-disabled="isProcessing">로그아웃</button>
                            </h4>
                            <h5>마이 월렛 <button type="button" class="btn-refresh" ng-click="getBalance()"><i class="icon-refresh"></i></button></h5>
                            <div id="wallet-container" class="side-content" ng-init="init()">
                                <ul>
                                    <!--ng-repeat="agentGspList"-->
                                    <li ng-repeat-start="agentGsp in agentGspList"  ng-repeat-end><span ng-bind="agentGsp.gspName"></span>
                                        <strong  ng-show="agentGsp.amount == 'Loading'" ng-bind="agentGsp.amount"></strong>
                                        <strong  ng-show="agentGsp.amount != 'Loading'" ng-bind="agentGsp.amount | customCurrency:cc_currency_symbol[userCurrency]"></strong>
                                    </li>
                                    <li>Total
                                    <strong ng-show="totalBalance =='Loading'" ng-bind="totalBalance"></strong>
                                    <strong ng-show="totalBalance !='Loading'" ng-bind="totalBalance | customCurrency:cc_currency_symbol[userCurrency]"></strong>
                                    </li>
                                </ul>
                            </div>

                            <h5>머니 이동</h5>
                            <div id="transfer-container" class="side-content" ng-controller="TransferController">
                                <form novalidate ng-submit="processForm()">
                                    <select ng-model="transfer.fromWallet" ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in agentGspList  | filter:{transferEnable:true}">
                                        <option value="">이동전게임</option>
                                    </select>

                                    <select ng-model="transfer.toWallet" ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in filteredGspWalletList | filter:{transferEnable:true}">
                                        {{filteredGspWalletList}}
                                        <option value="">이동전게임</option>
                                    </select>

                                    <input type="text" ng-model="transfer.amount" placeholder="\" format="number" value="{{transfer.amount | number}}" valid-method="blur" />
                                    <button type="submit" class="btn" ng-disabled="isProcessing">게임 머니 이동</button>
                                </form>
                                <!--<p><strong>$ 1,234.00</strong> will transfer to <span>Sample Wallet</span></p>-->
                            </div>

                            <div id="wallet-nav" class="side-content">
                                <ul>
                                    <li ng-click="displayWallet(2)">입금신청</li>
                                    <li ng-click="displayWallet(3)">출금신청</li>
                                    <li ng-click="displayWallet(4)">보너스 내역</li>
                                    <li ng-click="displayWallet(5)">친구 목록</li>
                                    <li ng-click="displayWallet(6)" ng-controller="CouponController" ng-init="loadCoupon">쿠폰 내역 <strong ng-bind="couponCount"></strong></li>
                                    <li ng-click="displayWallet(7)">입출금 내역</li>
                                    <br class="clear" />
                                </ul>
                            </div>
                        </div>
                        <?}?>
                        </div>

                        <div id="promo-slider">
                            <div class="promo-side1">
                                <img src="common/img/a1.png" ng-click="displayCustomer(2)" />
                                <!--<h1>매일 매일 첫 입금 5% 보너스 지급</h1>
                                <button type="button" class="btn">자세히 보기</button>-->
                            </div>
                            <div class="promo-side1"><img src="common/img/a2.png" ng-click="displayCustomer(2)" /></div>
                            <div class="promo-side1"><img src="common/img/a3.png" ng-click="displayCustomer(2)" /></div>
                            <div class="promo-side1"><img src="common/img/a4.png" ng-click="displayCustomer(2)" /></div>
                            <div class="promo-side1"><img src="common/img/a5.png" ng-click="displayCustomer(2)" /></div>
                        </div>
                    </div>

                    <div class="clear"></div>
                </div>
                <div class="whole-panel">
                    <div class="product-advantages">
                        <div>
                            <i class="icon-contact1"></i>
                            <h4>파트너를 모십니다</h4>
                            <h2>파트너 제휴 문의</h2>
                        </div>
                        <div>
                            <i class="icon-contact2"></i>
                            <h4>궁금한 점이 있으세요?</h4>
                            <h2>자주 묻는 질문</h2>
                        </div>
                        <div>
                            <i class="icon-contact3"></i>
                            <h4>365 게임문의</h4>
                            <h2 ng-bind="techContactNumber"></h2>
                        </div>
                        <div>
                            <i class="icon-contact4"></i>
                            <h4>365 결제문의</h4>
                            <h2 ng-bind="bankContactNumber"></h2>
                        </div>
                        <div class="text-center">
                            <h4>1:1 실시간 라이브 채팅</h4>
                            <h2>실시간 문의하기</h2>
                        </div>
                        <br class="clear" />
                    </div>
                </div>
            </div>
            <div id="footer-container">
                <div class="container">
                    <div class="footer-logos"><img src="common/img/logo-gamepartners.png" /></div>
                    <div class="copyright">&copy; 2015-2016. <strong>PapaCasino.</strong> All Rights Reserved.</div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <script type="text/javascript" src="common/js/jquery.min.js"></script>
        <script type="text/javascript" src="common/js/angular.min.js"></script>
        <![if !IE 8]>
        <script type="text/javascript" src="common/js/jquery-sweet-alert.min.js"></script>
        <![endif]>
        <script type="text/javascript" src="common/js/jquery-intlTelInput.js"></script>
        <script type="text/javascript" src="common/js/jquery-browser.min.js"></script>
        <script type="text/javascript" src="common/js/jquery-moment.min.js"></script>
        <script type="text/javascript" src="common/js/jquery-moment-timezone.min.js"></script>
        <script type="text/javascript" src="common/js/jstz-1.0.4.min.js"></script>

        <script type="text/javascript" src="common/js/es5-shim.js"></script>
        <script type="text/javascript" src="common/js/angular-route.js"></script>
        <script type="text/javascript" src="common/js/angular-routeData.js"></script>
        <script type="text/javascript" src="common/js/ngDialog.js"></script>
        <script type="text/javascript" src="common/js/angular-messages.js"></script>
        <script type="text/javascript" src="common/js/angular-cookies.min.js"></script>
        <script type="text/javascript" src="common/js/angular-module-currencyCode.min.js"></script>
        <script type="text/javascript" src="/common/js/angular-pagination-ui-bootstrap.js"></script>

        <script type="text/javascript" src="common/js/angular-custom-module.js"></script>
        <script type="text/javascript" src="common/js/angular-custom-common.js"></script>
        <script type="text/javascript" src="common/js/angular-custom-customer.js"></script>
        <script type="text/javascript" src="common/js/angular-custom-signup.js"></script>
        <script type="text/javascript" src="common/js/angular-custom-wallet.js"></script>
        <script type="text/javascript" src="common/js/angular-custom-slots.js"></script>
        <script type="text/javascript" src="common/js/angular-custom-sports.js"></script>

        <script type="text/javascript" src="common/js/jquery-easy-ticker.js"></script>
        <script type="text/javascript" src="common/js/jquery-easing.min.js"></script>
        <script type="text/javascript" src="common/js/jquery-owl-carousel.min.js"></script>
        <script type="text/javascript" src="common/js/jquery-jOdometer.min.js"></script>
        <script type="text/javascript" src="common/js/jquery-contained-sticky-scroll.js"></script>
        <script type="text/javascript" src="common/js/main.js"></script>
    </body>
</html>
