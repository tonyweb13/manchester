<!DOCTYPE html>
<!--[if IE 8]><!-->
<html class="no-js lt-ie9"  ng-app="luckyApp">
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
    <link rel="stylesheet" href="css/style_02292016.css">
</head>
<body ng-controller="CommonController" ng-init="init()">
<div id="preloader" data-loading>
    <div class="container">
        <div class="preloader-gif"></div>
    </div>
</div>

<div class="container">
    <div class="header">
        <div class="logo"></div>
        <div class="nav">
            <ul>
                <li ng-click="game_type('Baccarat')" class="active">라이브 바카라 </li>
                <li ng-click="game_type('Roulette')">라이브 룰렛</li>
                <li ng-click="game_type('Blackjack')">라이브 블랙잭</li>
            </ul>
        </div>
        <div class="account">
            <p>
                <span>Balance:</span>
                <strong class="highlight" ng-bind="balance"></strong>
            </p>
            <div class="clear"></div>
        </div>
    </div>
    <h1 class="note">발란스가 없으면 게임이 실행되지 않습니다.</h1>
    <div style="display: none" ng-style="displayStatus" ng-show="games != undefined"  ng-repeat="game in games | filter:{'type':game_select}">
        <!--BACCARAT-->
        <div ng-show="game.type=='Baccarat'">
            <div class="item-baccarat">
                <div class="dealer-info">
                    <ul class="float-left">
                        <!--<li><span>게임 타입</span> <strong ng-bind="game.type"></strong></li>-->
                        <li><span>게임 네임</span> <strong ng-bind="game.name"></strong></li>
                        <li><span>딜러</span> <strong ng-bind="game.dealer.name"></strong></li>
                        <li><span>오픈:</span> <strong ng-bind="game.openHours.open"></strong></li>
                        <li><span>종료:</span> <strong ng-bind="game.openHours.close"></strong></li>
                    </ul>
                    <ul class="float-right">
                        <li><a href="#" class="btn-on" ng-if="game.isOpen">운영중</a> <a href="#" class="btn-off" ng-if="!game.isOpen">>종료</a></li>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="float-left">
                    <div class="img-baccarat"></div>
                    <div class="dealer-thumb" style="background:url('https://demo.luckystreaklive.com/images/d/{{game.dealer.name}}-{{game.type}}.jpg') -6px -25px"></div>
                </div>

                <div class="dealer-table">
                    <div ng-repeat="statics in game.baccaratStatistics" ng-switch on="$index % 5" style="float: left;">
                        <ul ng-switch-when="0" style="display: table-caption; margin: 0; padding: 0">
                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index].main]}}-{{sideBet(game.baccaratStatistics[$index].winSideBets)}}"></li>
                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index+1].main]}}-{{sideBet(game.baccaratStatistics[$index+1].winSideBets)}}"></li>
                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index+2].main]}}-{{sideBet(game.baccaratStatistics[$index+2].winSideBets)}}"></li>
                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index+3].main]}}-{{sideBet(game.baccaratStatistics[$index+3].winSideBets)}}"></li>
                            <li class="icon-baccarat icon-{{baccrat_game_result[game.baccaratStatistics[$index+4].main]}}-{{sideBet(game.baccaratStatistics[$index+4].winSideBets)}}"></li>
                        </ul>
                    </div>
                </div>

                <div class="dealer-play-content">
                    <div class="dealer-play" ng-repeat="limitGroup in game.limitGroups">
                        <a ng-href="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}&LobbyURL=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" target="_self">
                            {{limitGroup.limits[0].values.min | number: 0}} - {{limitGroup.limits[0].values.max | number: 0}}
                            <strong>게임실행</strong>
                        </a>
                    </div>
                </div>

                <div class="dealer-closed" style="display: none" ng-if="!game.isOpen">
                    테이블 닫힘
                </div>
                <div class="clear"></div>
                <!--                    <div class="game-content">-->
                <!--                        <span>{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}</span>-->
                <!--                        <!--<iframe name="baccarat" width="800px" height="600px" ng-src="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}"></iframe>-->
                <!--                    </div>-->
            </div>
        </div>

        <!--ROULETTE-->
        <div ng-show="game.type=='Roulette'">
            <div class="item-roulette">
                <div class="dealer-info">
                    <ul class="float-left">
                        <li><span>게임 네임</span> <strong ng-bind="game.name"></strong></li>
                        <li><span>딜러</span> <strong ng-bind="game.dealer.name"></strong></li>
                        <li><span>오픈:</span> <strong ng-bind="game.openHours.open"></strong></li>
                        <li><span>종료:</span> <strong ng-bind="game.openHours.close"></strong></li>
                    </ul>
                    <ul class="float-right">
                        <li><a href="#" class="btn-on" ng-if="game.isOpen">운영중</a> <a href="#" class="btn-off" ng-if="!game.isOpen">>종료</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="float-left">
                    <div class="img-roulette"></div>
                    <div class="dealer-thumb" style="background:url('https://demo.luckystreaklive.com/images/d/{{game.dealer.name}}-{{game.type}}.jpg') -19px -20px"></div>
                </div>

                <div class="roulette-table">
                    <div ng-repeat="rouletteStatistics in game.rouletteStatistics.latestResults" ng-switch on="$index % 4" style="float: left;">
                        <ul ng-switch-when="0" style="display: table-caption; margin: 0; padding: 0">
                            <li class="icon-roulette roulette-{{game.rouletteStatistics.latestResults[$index]}}">{{game.rouletteStatistics.latestResults[$index]}}</li>
                            <li class="icon-roulette roulette-{{game.rouletteStatistics.latestResults[$index+1]}}">{{game.rouletteStatistics.latestResults[$index+1]}}</li>
                            <li class="icon-roulette roulette-{{game.rouletteStatistics.latestResults[$index+2]}}">{{game.rouletteStatistics.latestResults[$index+2]}}</li>
                            <li class="icon-roulette roulette-{{game.rouletteStatistics.latestResults[$index+3]}}">{{game.rouletteStatistics.latestResults[$index+3]}}</li>
                        </ul>
                    </div>
                </div>

                <div class="dealer-play-content">
                    <div class="dealer-play" ng-repeat="limitGroup in game.limitGroups">
                        <a ng-href="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}&LobbyURL=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" target="_self">
                            {{limitGroup.limits[0].values.min | number: 0}} - {{limitGroup.limits[0].values.max | number: 0}}
                            <strong>게임실행</strong>
                        </a>
                    </div>
                </div>

                <div class="dealer-closed" style="display: none" ng-if="!game.isOpen">
                    테이블 닫힘
                </div>
                <div class="clear"></div>

                <!--                    <div class="game-content">-->
                <!--                        <span>{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}</span>-->
                <!--                        <!--<iframe name="baccarat" width="800px" height="600px" ng-src="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}"></iframe>-->
                <!--                    </div>-->
            </div>

            <!--<span ng-bind="game.rouletteStatistics.latestResults"></span>-->
        </div>

        <!--BLACKJACK-->
        <div ng-show="game.type=='Blackjack'">

            <div class="item-blackjack">
                <div class="dealer-info">
                    <ul class="float-left">
                        <li><a href="#" class="btn-on" ng-if="game.isOpen">운영중</a> <a href="#" class="btn-off" ng-if="!game.isOpen">>종료</a></li>
                    </ul>
                    <div class="noOfSeats float-right">
                        <p>좌석 <strong><span ng-bind="game.blackjackDetails.occupiedSeats"></span>/<span ng-bind="game.blackjackDetails.numberOfSeats"></span></strong></p>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="float-left">
                    <div class="img-blackjack"></div>
                    <div class="dealer-thumb" style="background:url('https://demo.luckystreaklive.com/images/d/{{game.dealer.name}}-{{game.type}}.jpg') -10px -21px"></div>
                </div>

                <div class="blackjack-details float-left">
                    <ul>
                        <li><span>게임 네임</span> <strong ng-bind="game.name"></strong></li>
                        <li><span>딜러</span> <strong ng-bind="game.dealer.name"></strong></li>
                        <li><span>오픈:</span> <strong ng-bind="game.openHours.open"></strong></li>
                        <li><span>종료:</span> <strong ng-bind="game.openHours.close"></strong></li>
                    </ul>
                </div>

                <div class="dealer-play-content" ng-if="game.isOpen">
                    <div class="dealer-play" ng-repeat="limitGroup in game.limitGroups">
                        <a ng-href="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}&LobbyURL=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" target="_self">
                            {{limitGroup.limits[0].values.min | number: 0}} - {{limitGroup.limits[0].values.max | number: 0}}
                            <strong>게임실행</strong>
                        </a>
                    </div>
                </div>

                <div class="dealer-closed" style="display: none" ng-if="!game.isOpen">
                    테이블 닫힘
                </div>
                <div class="clear"></div>
                <!---->
                <!--                    <div class="game-content">-->
                <!--                        <span>{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}</span>-->
                <!--                        <!--<iframe name="baccarat" width="800px" height="600px" ng-src="{{game.launchUrl}}&LimitsGroupId={{limitGroup.id}}"></iframe>-->
                <!--                    </div>-->
            </div>
        </div>

        <!--<div ng-repeat="limit in game.limitGroups.limits">
            <a ng-href="{{game.launchUrl}}&LimitsGroupId={{game.limitGroups.id}}{{limit.type}}" target="_blank">{{limit.values[0].min}}-{{limit.values[0].max}}게임실행(실행안됨)</a>
        </div>-->
    </div>

</div>


<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/undersoce-min.js"></script>
<script type="text/javascript" src="js/angular.min.js"></script>
<script>
    var app = angular.module('luckyApp',[])
        .directive('loading',   ['$http' ,function ($http) {
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

    app.controller("CommonController", function ($rootScope, $scope, $http) {
        $scope.balance=0;
        $scope.baccrat_game_result={"1":"B","2":"P","3":"T"};
        $scope.baccrat_side_bet_result={"1":"PP","2":"BP"};
        $scope.displayStatus={'display':'none'};
        //$scope.baccrat_side_bet_result={"1":"PP","2":"BP",3:"Small","4":"Big","5":"EP"};

        $scope.init = function () {
            $http.get("load_lucky_streak.php", {
                })
                .success(function (data) {
                    $scope.games=data.games;
                    $scope.displayStatus={'display':'block'};
                }).error(function (data, status) {
                console.error('Repos error', status, data);
            })["finally"](function () {
                $scope.game_select="Baccarat";
            });

            $http.get("/api/finance/CheckMemberBalanceSingle?Wallet=1026", {
                })
                .success(function (data) {
                    $scope.balance = data.balance;
                }).error(function (data, status) {
                console.error('Repos error', status, data);
            })["finally"](function () {
            });

        };

        $scope.game_type = function(type){
            $scope.game_select = type;
        };

        $scope.sideBet = function(sideBets){
            var sideBet="";
            angular.forEach(sideBets,function(value){
                if(value==1 || value==2){
                    sideBet += $scope.baccrat_side_bet_result[value];
                }
            });
            console.log(sideBet);
            return sideBet;
        };

        $scope.displayGame = function(){
            $('.game-content').show();

        };

        $scope.turnOff = function (){
            $('.dealer-play-content').hide();
            $('.dealer-closed').show();
        };

        $scope.turnOn = function (){
            $('.dealer-play-content').show();
            $('.dealer-closed').hide();
        };
    });

    $(document).ready(function(){
        $('.dealer-closed').hide();

        $('.nav li').click(function(){
            $(this).siblings('.active').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
</body>
</html>