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
    <style>
        ul>li{cursor: pointer;display: inline-block;color: blue;}
    </style>
</head>
<body ng-controller="CommonController" ng-init="init()">
<div>
    <h1 style="color:red">발란스가 없으면 게임이 실행되지 않습니다.</h1>
    <ul>
        <li ng-click="game_type('Baccarat')">Baccarat</li>
        <li ng-click="game_type('Roulette')">Roulette</li>
        <li ng-click="game_type('Blackjack')">Blackjack</li>
    </ul>
    <div ng-repeat="game in games | filter:{'type':game_select}">
        게임타입:<span ng-bind="game.type"></span>
        게임네임:<span ng-bind="game.name"></span>
        <div>
            아바타: <span ng-bind="game.dealer.avatarUrl"></span>
            이  름: <span ng-bind="game.dealer.name"></span>
        </div>
        <div ng-repeat="openHour in game.openHours">
            오픈: <span ng-bind="openHour.open"></span>
            종료: <span ng-bind="openHour.close"></span>
        </div>
        <div ng-show="game.type=='Baccarat'">
            최신결과:
            <span ng-repeat="statics in game.baccaratStatistics">
                <br/>
                <span ng-bind="$index+1"></span>회차
                메인: <span ng-bind="baccrat_game_result[statics.main]"></span>
                사이드벳: <span ng-bind="baccrat_side_bet_result[statics.winSideBets]"></span>
            </span>
        </div>
        <div ng-show="game.type=='Roulette'">
            최신결과:
            <span ng-bind="game.rouletteStatistics.latestResults"></span>
        </div>
        <div ng-show="game.type=='Blackjack'">
            좌석 갯수:
            <span ng-bind="game.blackjackDetails.numberOfSeats"></span>
            점유 좌석:
            <span ng-bind="game.blackjackDetails.occupiedSeats"></span>
        </div>
        <a ng-href="{{game.launchUrl}}&LimitsGroupId={{game.limitGroups.id}}" target="_blank">게임실행</a>
        <div ng-repeat="limit in game.limitGroups.limits">
            <!--<a ng-href="{{game.launchUrl}}&LimitsGroupId={{game.limitGroups.id}}{{limit.type}}" target="_blank">{{limit.values[0].min}}-{{limit.values[0].max}}게임실행(실행안됨)</a>-->
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/angular.min.js"></script>
<script>
    var app = angular.module('luckyApp',[]);

    app.controller("CommonController", function ($rootScope, $scope, $http) {
        $scope.baccrat_game_result={"1":"B","2":"P","3":"T"};
        $scope.baccrat_side_bet_result={"1":"PP","2":"BP",3:"Small","4":"Big","5":"EP"};

        $scope.init = function () {
            $http.get("load_lucky_streak.php", {
                })
                .success(function (data) {
                    $scope.games=data.games;
                    console.log($scope.games)
                }).error(function (data, status) {
                console.error('Repos error', status, data);
            })["finally"](function () {
                $scope.game_select="Baccarat";
            });
        };

        $scope.game_type = function(type){
            $scope.game_select = type;
        };
    });
</script>
</body>
</html>