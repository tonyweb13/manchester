<!DOCTYPE html>
<!--[if IE 8]><!-->
<html class="no-js lt-ie9" ng-app="luckyApp">
<!--<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" ng-app="luckyApp">
<!--<![endif]-->
<head>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="js/html5shiv.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script type="text/javascript" src="js/es5-shim.js"></script>
    <script type="text/javascript" src="js/json3.min.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <script>
        document.createElement('ng-include');
        document.createElement('ng-pluralize');
        document.createElement('ng-view');
        document.createElement('ng-click');
        document.createElement('ng-repeat');
        document.createElement('ng-show');
        document.createElement('my-directive');

        // Optionally these for CSS
        document.createElement('ng:include');
        document.createElement('ng:pluralize');
        document.createElement('ng:view');
        document.createElement('ng:click');
        document.createElement('ng:repeat');
        document.createElement('ng:show');
        document.createElement('poster');
    </script>
    <![endif]-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="css/style.css">
</head>
<body ng-controller="CommonController" ng-init="init()">
<div id="preloader" data-loading>
    <div class="container">
        <div class="preloader-gif"></div>
    </div>
</div>

<main role="main" class="main" id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="login-logo off-canvas">
                    <img src="images/logo.png" alt="Lucky Streak">
                </div>
            </div>
        </div>
    </div>
    <div class="tabs-wrapper">
        <div class="tabs-navbar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li><p class="tab active" href="" data-rel="" data-id="0">ALL</p></li>
                            <li><p class="tab" data-rel="baccarat" data-id="1" ng-click="gameBaccarat()">BACCARAT</p>
                            </li>
                            <li><p class="tab" data-rel="blackjack" data-id="2" ng-click="gameBlackjack()">BLACKJACK</p>
                            </li>
                            <li><p class="tab" data-rel="roulette" data-id="3" ng-click="gameRoulette()">ROULETTE</p>
                            </li>
                            <li>
                                <div class="custom-select">
                                    <strong>발란스:</strong> <span ng-bind="balance"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabs-content">
            <div class="container" style="display: none" ng-style="displayStatus">
                <div class="row">
                    <div id="game-tables">
                        <div ng-repeat="game in games">
                            <div class="tile baccarat all" data-id="baccarat" ng-show="game.type=='Baccarat'">
                                <div class="col-md-4">
                                    <div class="item">
                                        <p class="tale-name" ng-if="game.isOpen" ng-bind="game.dealer.name"></p>

                                        <div class="caption-tale">
                                            <div class="caption-header">
                                                <div class="header-content">
                                                    <p class="min">오픈:<span ng-bind="game.openHours.open"></span></p>
                                                    <p class="max">종료:<span ng-bind="game.openHours.close"></span></p>
                                                </div>
                                            </div>

                                            <div class="caption-content" style="display: none" ng-if="!game.isOpen">
                                                <div class="content">
                                                    <div class="counter">
                                                        <p>테이블 닫힘</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="caption-content" ng-if="game.isOpen">
                                                <p class="caption-content-title">BIG ROAD</p>
                                                <div class="dealer-table">
                                                    <div ng-repeat="statics in game.baccaratStatistics" ng-switch
                                                         on="$index % 5" style="float: left;">
                                                        <ul ng-switch-when="0"
                                                            style="display: table-caption; margin: 0; padding: 0">
                                                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index].main]}}-{{sideBet(game.baccaratStatistics[$index].winSideBets)}}"></li>
                                                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index+1].main]}}-{{sideBet(game.baccaratStatistics[$index+1].winSideBets)}}"></li>
                                                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index+2].main]}}-{{sideBet(game.baccaratStatistics[$index+2].winSideBets)}}"></li>
                                                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index+3].main]}}-{{sideBet(game.baccaratStatistics[$index+3].winSideBets)}}"></li>
                                                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index+4].main]}}-{{sideBet(game.baccaratStatistics[$index+4].winSideBets)}}"></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption-footer" ng-if="game.isOpen">
                                                <button class="btn btn-sm btn-default btn-play"
                                                        ng-click="playItem($event)">PLAY NOW!
                                                </button>
                                            </div>
                                            <div class="limit-groups" ng-if="game.isOpen">
                                                <p style="text-align: center; margin: 60px 0;" ng-if="balance == 0">
                                                    발란스가 없으며 실행되지 않습니다.<br/>
                                                    입금 후 실행해주세요.
                                                </p>
                                                <div ng-if="balance != 0">
                                                    <p>Limit Groups:</p>
                                                    <ul>
                                                        <li ng-repeat="limitGroup in game.limitGroups">
                                                            <a ng-href="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}&LobbyURL=<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>"
                                                               target="_self">
                                                                <span>MIN: {{limitGroup.limits[0].values.min | number: 0}}</span>
                                                                |
                                                                <span>MAX: {{limitGroup.limits[0].values.max | number: 0}}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dealer-avatar" ng-if="game.isOpen"><img
                                                src="https://demo.luckystreaklive.com/images/d/{{game.dealer.name}}-{{game.type}}.jpg"/>
                                        </div>
                                        <div class="dealer-avatar" ng-if="!game.isOpen"><img
                                                src="https://demo.luckystreaklive.com/images/e-{{game.type}}.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tile blackjack all" data-id="blackjack" ng-show="game.type=='Blackjack'">
                                <div class="col-md-4">
                                    <div class="item">
                                        <p class="tale-name" ng-if="game.isOpen" ng-bind="game.dealer.name"></p>

                                        <div class="caption-tale">
                                            <div class="caption-header">
                                                <div class="header-content">
                                                    <p class="min">오픈:<span ng-bind="game.openHours.open"></span></p>
                                                    <p class="max">종료:<span ng-bind="game.openHours.close"></span></p>
                                                </div>
                                            </div>

                                            <div class="caption-content" style="display: none" ng-if="!game.isOpen">
                                                <div class="content">
                                                    <div class="counter">
                                                        <p>테이블 닫힘</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="caption-content" ng-if="game.isOpen">
                                                <p class="caption-content-title">
                                                    <span>{{(game.blackjackDetails.numberOfSeats-game.blackjackDetails.occupiedSeats)}}</span>
                                                    SEATS AVAILABLE
                                                </p>

                                                <ul class="sets-aveable">

                                                    <li ng-repeat="n in [] | range:game.blackjackDetails.numberOfSeats"
                                                        ng-class="{'active': !(game.blackjackDetails.occupiedSeatIds | is_seated:$index-1 ) }">
                                                        <span>{{ $index + 1 }}</span>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="caption-footer" ng-if="game.isOpen">
                                                <button class="btn btn-sm btn-default btn-play"
                                                        ng-click="playItem($event)">PLAY NOW!
                                                </button>
                                            </div>
                                            <div class="limit-groups" ng-if="game.isOpen">
                                                <p style="text-align: center; margin: 60px 0;" ng-if="balance == 0">
                                                    발란스가 없으며 실행되지 않습니다.<br/>
                                                    입금 후 실행해주세요.
                                                </p>
                                                <div ng-if="balance != 0">
                                                    <p>Limit Groups:</p>
                                                    <ul>
                                                        <li ng-repeat="limitGroup in game.limitGroups">
                                                            <a ng-href="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}&LobbyURL=<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>"
                                                               target="_self">
                                                                <span>MIN: {{limitGroup.limits[0].values.min | number: 0}}</span>
                                                                |
                                                                <span>MAX: {{limitGroup.limits[0].values.max | number: 0}}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dealer-avatar" ng-if="game.isOpen"><img
                                                src="https://demo.luckystreaklive.com/images/d/{{game.dealer.name}}-{{game.type}}.jpg"/>
                                        </div>
                                        <div class="dealer-avatar" ng-if="!game.isOpen"><img
                                                src="https://demo.luckystreaklive.com/images/e-{{game.type}}.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tile roulette all" data-id="roulette" ng-show="game.type=='Roulette'">
                                <div class="col-md-4">
                                    <div class="item">
                                        <p class="tale-name" ng-if="game.isOpen" ng-bind="game.dealer.name"></p>

                                        <div class="caption-tale">
                                            <div class="caption-header">
                                                <div class="header-content">
                                                    <p class="min">오픈:<span ng-bind="game.openHours.open"></span></p>
                                                    <p class="max">종료:<span ng-bind="game.openHours.close"></span></p>
                                                </div>
                                            </div>

                                            <div class="caption-content" style="display: none" ng-if="!game.isOpen">
                                                <div class="content">
                                                    <div class="counter">
                                                        <p>테이블 닫힘</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="caption-content" ng-if="game.isOpen">
                                                <p class="caption-content-title">LAST NUMBERS</p>
                                                <div class="roulette-table">
                                                    <ul class="last-numbers"
                                                        ng-repeat="rouStats in game.rouletteStatistics.latestResults track by $index"
                                                        style="float: left;">
                                                        <li class="icon-roulette roulette-{{game.rouletteStatistics.latestResults[$index]}}">
                                                            {{game.rouletteStatistics.latestResults[$index]}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="caption-footer" ng-if="game.isOpen">
                                                <button class="btn btn-sm btn-default btn-play"
                                                        ng-click="playItem($event)">PLAY NOW!
                                                </button>
                                            </div>
                                            <div class="limit-groups" ng-if="game.isOpen">
                                                <p style="text-align: center; margin: 60px 0;" ng-if="balance == 0">
                                                    발란스가 없으며 실행되지 않습니다.<br/>
                                                    입금 후 실행해주세요.
                                                </p>
                                                <div ng-if="balance != 0">
                                                    <p>Limit Groups:</p>
                                                    <ul>
                                                        <li ng-repeat="limitGroup in game.limitGroups">
                                                            <a ng-href="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}&LobbyURL=<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>"
                                                               target="_self">
                                                                <span>MIN: {{limitGroup.limits[0].values.min | number: 0}}</span>
                                                                |
                                                                <span>MAX: {{limitGroup.limits[0].values.max | number: 0}}</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dealer-avatar" ng-if="game.isOpen"><img
                                                src="https://demo.luckystreaklive.com/images/d/{{game.dealer.name}}-{{game.type}}.jpg"/>
                                        </div>
                                        <div class="dealer-avatar" ng-if="!game.isOpen"><img
                                                src="https://demo.luckystreaklive.com/images/e-{{game.type}}.jpg"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<!-- BACKGROUND -->
<section class="bg-section">
    <div id="bg"></div>
    <div class="container-bg">
        <span class='light light-1'></span>
        <span class='light light-2'></span>
        <span class='light light-3'></span>
        <span class='light light-4'></span>
        <span class='light light-5'></span>
        <span class='light light-6'></span>
        <span class='light light-7'></span>
        <span class='light light-8'></span>
        <span class='light light-9'></span>
        <span class='light light-10'></span>
        <span class='light light-11'></span>
        <span class='light light-12'></span>
        <span class='light light-13'></span>
        <span class='light light-14'></span>
        <span class='light light-15'></span>
        <span class='light light-16'></span>
        <span class='light light-17'></span>
        <span class='light light-18'></span>
        <span class='light light-19'></span>
        <span class='light light-20'></span>
        <span class='light light-21'></span>
        <span class='light light-22'></span>
        <span class='light light-23'></span>
        <span class='light light-24'></span>
        <span class='light light-25'></span>
        <span class='light light-26'></span>
        <span class='light light-27'></span>
        <span class='light light-28'></span>
        <span class='light light-29'></span>
        <span class='light light-30'></span>
        <span class='light light-31'></span>
        <span class='light light-32'></span>
        <span class='light light-33'></span>
        <span class='light light-34'></span>
        <span class='light light-35'></span>
        <span class='light light-36'></span>
        <span class='light light-37'></span>
        <span class='light light-38'></span>
        <span class='light light-39'></span>
        <span class='light light-40'></span>
        <span class='light light-41'></span>
        <span class='light light-42'></span>
        <span class='light light-43'></span>
        <span class='light light-44'></span>
        <span class='light light-45'></span>
        <span class='light light-46'></span>
        <span class='light light-47'></span>
        <span class='light light-48'></span>
        <span class='light light-49'></span>
        <span class='light light-50'></span>
        <span class='light light-51'></span>
        <span class='light light-52'></span>
        <span class='light light-53'></span>
        <span class='light light-54'></span>
        <span class='light light-55'></span>
        <span class='light light-56'></span>
        <span class='light light-57'></span>
        <span class='light light-58'></span>
        <span class='light light-59'></span>
        <span class='light light-60'></span>
    </div>
</section>
<!-- BACKGROUND - END -->

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <!--<img src="images/logo_footer.png" alt="Lucky Streak">-->
        <p>All content © copyright 2015 by LuckyStreak. All rights reserved.</p>
    </div>
</footer>
<!-- FOOTER - END -->


<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/undersoce-min.js"></script>
<script type="text/javascript" src="js/angular.min.js"></script>
<script type="text/javascript" src="js/jquery.tmpl.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.countdown.js"></script>
<script type="text/javascript" src="js/modernizr.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script>
    var app = angular.module('luckyApp', [])
        .directive('loading', ['$http', function ($http) {
            return {
                restrict: 'A',
                link: function (scope, elm, attrs) {
                    scope.isLoading = function () {
                        return $http.pendingRequests.length > 0;
                    };

                    scope.$watch(scope.isLoading, function (v) {
                        if (v) {
                            elm.show();
                        } else {
                            elm.hide();
                        }
                    });
                }
            };
        }]);

    app.filter('range', function () {
        return function (input, total) {
            total = parseInt(total);

            for (var i = 0; i < total; i++) {
                input.push(i);
            }

            return input;
        };
    });

    app.filter('is_seated', function () {
        return function (sets, $index) {
            if (angular.isDefined($index)) {
                if (angular.isArray(sets)) {
                    return sets.indexOf(($index + 1).toString()) !== -1;
                }
                if (angular.isString(sets)) {
                    return sets === ($index + 1).toString();
                }
            }
            return false;
        };
    });

    app.controller("CommonController", function ($rootScope, $scope, $http) {
        $scope.balance = 0;
        $scope.baccrat_game_result = {"1": "B", "2": "P", "3": "T"};
        $scope.baccrat_side_bet_result = {"1": "PP", "2": "BP"};
        $scope.displayStatus = {'display': 'none'};
        //$scope.baccrat_side_bet_result={"1":"PP","2":"BP",3:"Small","4":"Big","5":"EP"};

        $scope.init = function () {
            $http.get("load_lucky_streak.php", {})
                .success(function (data) {
                    $scope.games = data.games;
                    $scope.displayStatus = {'display': 'block'};
                }).error(function (data, status) {
                console.error('Repos error', status, data);
            })["finally"](function () {
                $scope.game_select = "Baccarat";
                //$scope.game_select="Blackjack";
                //$scope.game_select="Roulette";
            });

            $http.get("/api/finance/CheckMemberBalanceSingle?Wallet=1026", {})
                .success(function (data) {
                    $scope.balance = data.balance;
                }).error(function (data, status) {
                console.error('Repos error', status, data);
            })["finally"](function () {
            });

        };

        $scope.game_type = function (type) {
            $scope.game_select = type;
        };

        $scope.gameBaccarat = function () {
            $scope.game_select = "Baccarat";
        };

        $scope.gameBlackjack = function () {
            $scope.game_select = "Blackjack";
        };

        $scope.gameRoulette = function () {
            $scope.game_select = "Roulette";
        };

        $scope.sideBet = function (sideBets) {
            var sideBet = "";
            angular.forEach(sideBets, function (value) {
                if (value == 1 || value == 2) {
                    sideBet += $scope.baccrat_side_bet_result[value];
                }
            });
//            console.log(sideBet);
            return sideBet;
        };

        $scope.displayGame = function () {
            $('.game-content').show();

        };

        $scope.turnOff = function () {
            $('.dealer-play-content').hide();
            $('.dealer-closed').show();
        };

        $scope.turnOn = function () {
            $('.dealer-play-content').show();
            $('.dealer-closed').hide();
        };

        $scope.playItem = function ($limit) {
            $($limit.target).parents('.item').find('.limit-groups').toggle();
        };

    });

    $(document).ready(function () {

        $('.dealer-closed').hide();

        /*$('.nav li').click(function(){
         $(this).siblings('.active').removeClass('active');
         $(this).addClass('active');
         });*/

        $('.tabs-navbar ul li p').click(function () {
            $('.tabs-navbar li p.active').removeClass('active');
            $(this).addClass('active');
        });

        $("p.tab").click(function () {
            selectedGameTypeClass = $(this).attr("data-rel");
            selectedClass = (selectedGameTypeClass == '') ? 'all' : selectedGameTypeClass;

            $("#game-tables").fadeTo(100, 0);
            $("#game-tables > div > div").not("." + selectedClass).fadeOut(0);
            setTimeout(function () {
                $("." + selectedClass).fadeIn();
                $("#game-tables").fadeTo(500, 1);
            }, 200);
        });

        $(".header-content").find('br').remove();
    });
</script>
</body>
</html>