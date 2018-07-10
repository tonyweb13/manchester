var app = angular.module('casinoApp', [
    'ngRoute',
    'RouteData',
    'ngMessages',
    'ngDialog',
    'ngSweetAlert',
    'ngCookies',
    'ngCurrencySymbol',
    'ui.bootstrap.pagination'
]);

app.config(['$routeProvider', 'RouteDataProvider', function($routeProvider, RouteDataProvider) {
    RouteDataProvider.applyConfig({bodyClass: 'bg-main'});
    RouteDataProvider.hookToRootScope(true);

    $routeProvider
        .when('/',              {RouteData: {bodyClass: 'bg-main'},     templateUrl : 'pages/main.php',        controller  : 'MainController'})
        .when('/sports',        {RouteData: {bodyClass: 'bg-sports'},   templateUrl : 'pages/sports.php',      controller  : 'SportsController'})
        .when('/casino',        {RouteData: {bodyClass: 'bg-casino'},   templateUrl : 'pages/casino.php',      controller  : 'CasinoController'})
        .when('/slots',         {RouteData: {bodyClass: 'bg-slots'},    templateUrl : 'pages/slots.php',       controller  : 'SlotsController'})
        .otherwise({
            redirectTo: '/',
            RouteData: {bodyClass: 'bg-main'},
            templateUrl : '../pages/main.php',
            controller  : 'MainController'
        });
}]);

app.service('loggedInStatus', function($rootScope) {
    return {
        setLoggedInStatus: function() {
            $rootScope.loggedIn = true;
            $rootScope.loggedOut = false;
        },
        setLoggedOutStatus: function() {
            $rootScope.loggedIn = false;
            $rootScope.loggedOut = true;
        }
    };
});


app.service('AmountService', function() {
    return {
        sumAmount: function(amount, amountSum) {
            //console.log(amountSum);
            if (amount == "NaN" || amount == "") {
                return parseFloat(amountSum);
            }
            amount = parseFloat(amount) + parseFloat(amountSum);
            return amount;
        },
        resetAmount: function() {
            return 0;
        }
    };
});

/*app.service("Balance", function($rootScope, $http, $window, SweetAlert, loggedInStatus) {
    return {
        getBalance: function(type) {
            if (type == "all") {
                $http.get("/api/finance/GetBalance")
                    .success(function(data) {
                        if (data.status == 200) {
                            $rootScope.mainBalance = data.result.mainBalance;
                            $rootScope.totalBalance = data.result.totalBalance;
                            $rootScope.gspBalanceList = data.result.orderedGspBalance;
                            $rootScope.gspBalanceListLength = data.result.orderedGspBalance.length;
                        } else {
                            if(data.status == 400){
                                if (data.alert) {
                                    $http.get("/api/player/Logout")
                                        .success(function() {
                                            loggedInStatus.setLoggedOutStatus();
                                        })["finally"](function() {
                                        $window.location.reload();
                                    });
                                }
                            }
                        }
                    }).error(function(data, status) {
                    console.error('Repos error', status, data);
                })["finally"](function() {

                });
            } else if (type == "single") {
                $http.get("/api/finance/GetMainBalance")
                    .success(function(data) {
                        if (data.status == 200) {
                            $rootScope.mainBalance = data.result.mainBalance;
                        } else {
                            if(data.status == 400){
                                if (data.alert) {
                                    $http.get("/api/player/Logout")
                                        .success(function() {
                                            loggedInStatus.setLoggedOutStatus();
                                        })["finally"](function() {
                                        $window.location.reload();
                                    });
                                }
                            }
                        }
                    }).error(function(data, status) {
                    console.error('Repos error', status, data);
                })["finally"](function() {

                });
            }
        }
    }
});*/

app.filter('customCurrency', ["$filter", function ($filter) {
    return function(amount, currencySymbol){
        //console.log(amount);
        var number = $filter('number');
        if(String(amount).charAt(0) === "-"){
            return number(amount).replace("-", "-"+currencySymbol);
        }
        if(amount==undefined){
            return "Loading";
        }else{
            return currencySymbol+number(amount);
        }

    };

}]);

app.filter('userDateTimeTimeZone', function($filter) {
    return function(input, format, offset) {
        if (input == null) {
            return "";
        }
        var timeFromUTC = moment.utc(input);
        var tzName = jstz.determine().name();
        var _date = moment(timeFromUTC, tzName).format("YYYY-MM-DD HH:mm:ss Z");
        return _date.toString();
    }
});

app.filter('userDateTime', function($filter) {
    return function(input, format, offset) {
        if (input == null) {
            return "";
        }
        var timeFromUTC = moment.utc(input);
        var tzName = jstz.determine().name();
        var _date = moment.tz(timeFromUTC, tzName).format("YYYY-MM-DD HH:mm");
        return _date.toString();
    }
});

app.filter('userDate', function($filter) {
    return function(input, format, offset) {
        if (input == null) {
            return "";
        }
        var timeFromUTC = moment.utc(input);
        var tzName = jstz.determine().name();
        var _date = moment.tz(timeFromUTC, tzName).format("YYYY-MM-DD");
        return _date.toString();
    }
});

app.directive("addAmountList", function() {
    return {
        link: function(scope, element, attrs) {
            scope.data = scope[attrs["addAmountList"]];
        },
        restrict: "A",
        template: "<button type='button' class='btn btn-drkgray btn-option' ng-repeat='item in data' ng-click='addAmount(item.price)'>{{item.price | number}} {{item.currency}}</button>"
    }
});

//Matched Password Filter
app.directive('validPasswordC', function() {
    return {
        require: 'ngModel',
        link: function(scope, elm, attrs, ctrl) {
            var original;
            ctrl.$formatters.unshift(function(modelValue) {
                original = modelValue;
                return modelValue;
            });
            ctrl.$parsers.push(function(viewValue) {
                var noMatch = viewValue != scope.signUp.password.$viewValue;
                ctrl.$setValidity('noMatch', !noMatch);
                return viewValue;
            });
        }
    }
});

app.directive('format', ['$filter', function($filter) {
    return {
        require: '?ngModel',
        link: function(scope, elem, attrs, ctrl) {
            if (!ctrl) return;

            ctrl.$formatters.unshift(function(a) {
                if(attrs.format=="numberDecimal" || attrs.format=="number") {
                    return $filter("number")(ctrl.$modelValue)
                }

            });

            ctrl.$parsers.unshift(function(viewValue) {
                if (viewValue == "NaN") return 0;
                if(attrs.format=="numberDecimal"){
                    var plainNumber = viewValue.replace(/[^\d|\-+|\d\.\d|\d\.+]/g,'');
                    if(viewValue.slice(-1)!="."){
                        elem.val($filter("number")(plainNumber));
                    }
                }else if(attrs.format=="number"){
                    var plainNumber = viewValue.replace(/[^\d|\-+|\.+]/g,'');
                    elem.val($filter("number")(plainNumber));
                }
                return plainNumber;
            });
        }
    };
}]);

app.controller("NavController", function($scope,$rootScope,$location) {
    $scope.isActive = function (viewLocation) {
        return viewLocation === $location.path();
    };
});

app.controller('CommonController', function($scope,$rootScope,$window,$http,loggedInStatus,$interval,ngDialog,$cookies,$sce,ccCurrencySymbol) {
    $rootScope.getAgentProductCasinoGameList = {};
    $rootScope.userCurrency="KRW";
    $rootScope.agentGspList =[
        {'gspNo':1000,'gspName':'뉴오퍼스','transferEnable':true,'casinoEnable':true,'slotEnable':true,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        {'gspNo':1004,'gspName':'벳소프트','transferEnable':true,'casinoEnable':false,'slotEnable':true,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        {'gspNo':1005,'gspName':'마이크로게이밍','transferEnable':true,'casinoEnable':true,'slotEnable':true,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        {'gspNo':1009,'gspName':'XTD','transferEnable':true,'casinoEnable':true,'slotEnable':true,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        {'gspNo':1014,'gspName':'이주기','transferEnable':true,'casinoEnable':true,'slotEnable':true,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        {'gspNo':1018,'gspName':'CMD 스포츠','transferEnable':false,'android':true,'ios':true,'amount':'Loading'},
        {'gspNo':1016,'gspName':'ASC 스포츠','transferEnable':false,'android':true,'ios':true,'amount':'Loading'}];

    $rootScope.cc_currency_symbol = ccCurrencySymbol;

    $rootScope.announceList={};
    $rootScope.realTimeTransactionList={};
    $rootScope.anouncementPopup={};
    $rootScope.readTitle="";
    $rootScope.readDate="";
    $rootScope.readContents="";
    $rootScope.totalBalance="Loading";
    $scope.getNotice=false;
    $scope.isProcessing = false;
    $rootScope.techContactNumber="";
    $rootScope.bankContactNumber="";

    $rootScope.getBalance = function(){
        if(!$scope.isProcessing){
            $scope.isProcessing=true;
            $http.get("/api/finance/CheckMemberBalance")
                .success(function(data) {
                    //console.log(data);
                    angular.forEach($rootScope.agentGspList,function(val){
                        if(data.list[val.gspNo] != undefined){
                            val.amount= data.list[val.gspNo].Balance;
                        }else{
                            val.amount= 0;
                        }
                        //console.log(val.amount);
                    });
                    $rootScope.totalBalance=data.list['All'].Balance;
                }).error(function(data, result) {
                console.error('Repos error', result, data);
            })["finally"](function() {
                $scope.isProcessing=false;
            });
        }
    };

    $rootScope.loadBonus = function (){
        var url = "/api/player/GetBonus.php";
        $http({
            method: 'GET',
            url: url,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function(data) {

            var ccomp = data.bonus.CurrentComp;
            var ucomp = data.bonus.UsedComp;
            var tcomp = data.bonus.TotalComp;

            $(".current-comp").text(ccomp);
            $(".used-comp").text(ucomp);
            $(".total-comp").text(tcomp);
        });
    };

    $rootScope.readBoardContent=function(type,announceNo){
        var url="/api/operation/GetBoardDescription";
        $http({
            method: "POST",
            url: url,
            data: $.param({
                "type": type,
                "code": announceNo
            }), // pass in data as strings
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function(data) {
            $rootScope.readBoardCode=data.content.BoardCode;
            $rootScope.readCount=data.content.ViewCount;
            $rootScope.readTitle=data.content.Subject;
            $rootScope.readDate=data.content.WriteDate;
            $rootScope.readContents=$sce.trustAsHtml(data.content.Contents);
            //console.log($rootScope.readTitle);
        }).error(function(data, status) {
            console.error('Repos error', status, data);
        })["finally"](function() {
            $rootScope.isRead=true;
        });
    };

        $http.get("/api/operation/GetBoardDetail?type=1&page=1")
            .success(function(data) {
                angular.forEach(data.list,function(val){
                    if(val.PopUp=='y' && !$scope.getNotice){
                        $rootScope.anouncementPopup = val;
                        //console.log($rootScope.anouncementPopup);
                        $scope.getNotice=true;
                        if(!$cookies.get('notToday')){
                            ngDialog.open({
                                template: 'popup/notice.php',
                                controller: 'NoticeController',
                                className: 'ngdialog-theme-default ngdialog-notice',
                                showClose: true,
                                closeByEscape: false,
                                scope: $scope
                            });
                        }
                    }
                });
                $rootScope.announceList=data.list;

            }).error(function(data, result) {
            console.error('Repos error', result, data);
        })["finally"](function() {

        });


    $scope.playGame=function(gspNo,productType,gameId,isFun) {
        if ($rootScope.loggedIn) {
            //console.log($scope.gspLanguage);
            var url = "";
            var size = "";
            if (productType == "sports") {
                url = "/api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType;
                $rootScope.sportIURL = $sce.trustAsResourceUrl(url);

            } else {
                if (productType == "live" || productType == "playCheck") {
                    if (gspNo == 1012) {
                        url = "/api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType;
                        size = "width=1024, height=592";
                    } else {
                        url = "/api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType;
                        size = "width=1024, height=768";
                    }

                } else if (productType == "slot") {
                    if (gspNo == 1005 || gspNo == 1004) {
                        url = "/api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType + "&gameId=" + gameId;
                        size = "width=1024, height=592";
                    } else {
                        url = "/api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType + "&gameId=" + gameId;
                        size = "width=1024, height=768";
                    }
                } else if (productType == "etc") {
                    url = "/api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType;
                    size = "width=1024, height=682";
                }
                var target = "";
                if (productType == 'slot' && gspNo != 1005) {
                    target = gspNo + Math.random();
                } else if (productType == 'playCheck' && gspNo == 1005) {
                    target = gspNo + "playCheck";
                } else {
                    target = gspNo;
                }
                var popupWindow = window.open(url, target, size).focus();
            }
        } else {
            ngDialog.open({
                template: '/popup/login.php',
                controller: 'LoginController',
                className: 'ngdialog-theme-default ngdialog-login',
                overlay: true,
                scope: $scope
            });
        }

    };

    $scope.checkSession=function() {
        $http.get("/api/player/GetMemberInfo")
            .success(function (data) {
                if (data.result != 1) {
                    if (data.result == 207) {
                        var url = "/api/player/Logout";
                        $http.get(url, function (data) {
                            if (data.result == 1) {
                                if (bowser.msie && bowser.version <= 8) {
                                    alert(data.message);
                                } else {
                                    SweetAlert.swal(data.message, "", "success");
                                }
                                loggedInStatus.setLoggedOutStatus();

                            } else {
                                $window.location.reload();
                            }
                        }, "json");
                    } else {
                        alert(data.message);
                        $window.location.reload();
                    }
                }
            }).error(function (data, result) {
            console.error('Repos error', result, data);
        })["finally"](function () {

        });
    };

    $http.get("/api/finance/DisplayTransaction?count=7")
        .success(function(data) {
            $rootScope.realTimeTransactionList=data;
        }).error(function(data, result) {
        console.error('Repos error', result, data);
    })["finally"](function() {

    });

    $scope.init = function(isLogin) {
        if (isLogin) {
            loggedInStatus.setLoggedInStatus();
            $interval(function() {
                $scope.checkSession();
                $scope.getBalance();
                $scope.loadBonus();
            }, 3000);//1min
        }

        $scope.tech="";
        $scope.bank="";

        $http.get("/api/system/CheckServer?type=return")
            .success(function (data) {
                $scope.bankContactNumber=data.bank;
                $scope.techContactNumber=data.tech;

                //console.log(data);
                //for (var i = 0; i < data.tech.length; i++) {
                //    $scope.tech.push({number: data.tech.charAt(i)});
                //}
                //for (i = 0; i < data.bank.length; i++) {
                //    $scope.bank.push({number: data.bank.charAt(i)});
                //}
            }).error(function (data, status) {
            console.error('Repos error', status, data);
        });

    };

    $scope.formatDate = function(date){
        var date = date.split("-").join("/");
        var dateOut = new Date(date);
        return dateOut;
    };

    $scope.displayWallet = function (tabIndex) {
        $scope.selectWalletTab = tabIndex;
        ngDialog.open({
            template: 'popup/wallet.php',
            controller: 'WalletController',
            className: 'ngdialog-theme-default',
            showClose: true,
            closeByEscape: false,
            scope: $scope
        });
        closeMobilePane();
    };

    $scope.displayRules = function (tabIndex) {
        $scope.selectRulesTab = tabIndex;
        ngDialog.open({
            template: 'popup/rules.php',
            controller: 'RulesController',
            className: 'ngdialog-theme-default ngdialog-rules',
            showClose: true,
            closeByEscape: false,
            scope: $scope
        });
        closeMobilePane();
    };

    $scope.displayLogin = function () {
        ngDialog.open({
            template: 'popup/login.php',
            controller: 'LoginController',
            className: 'ngdialog-theme-default ngdialog-login',
            showClose: true,
            closeByEscape: false,
            scope: $scope
        });
    };

    $scope.displaySignUp = function () {
        ngDialog.close();
        ngDialog.open({
            template: 'popup/signup.php',
            controller: 'SignUpController',
            className: 'ngdialog-theme-default ngdialog-signup',
            showClose: true,
            closeByEscape: false,
            scope: $scope
        });
    };

    $scope.navLogo = function() {
        closeMobilePane();
        mainMasthead();
    };

    $scope.navMobile = function() {
        $('#mobile-container').slideToggle();
        $('.content-overlay').toggleClass('show');
        $('.navMobile').toggleClass('active');
    };

    $scope.navCasino = function () {
        casinoMasthead();
        closeMobilePane();

        $http.get("/api/system/GetAgentProductGspGameList", {
            cache: true
        }).success(function(data) {
            if (data.status == 200) {
                //console.log(data.result);
                $rootScope.getAgentProductCasinoGameList=data.result.AgentProductCasinoGameList[0];
            }
        }).error(function(data, status) {
            console.error('Repos error', status, data);
        });
    };

    $scope.displayCustomer = function (tabIndex) {
        $scope.selectCustomerTab = tabIndex;
        ngDialog.open({
            template: 'popup/customer.php',
            controller: 'CustomerController',
            className: 'ngdialog-theme-default',
            showClose: true,
            closeByEscape: false,
            scope: $scope
        });
        closeMobilePane();
    };

    $scope.navSports = function () {
        sportsPageLayout();
        sportsMasthead();
    };

    $scope.navSlots = function () {
        slotsMasthead();
        closeMobilePane();
    };

    $('#main-promo-slider').owlCarousel({
        autoPlay: true,
        pagination: false,
        navigation: false,
        paginationSpeed: 400,
        singleItem: true,
        transitionStyle : "fade",
        lazyEffect : "fade"
    });

    $scope.$on('$viewContentLoaded', function() {
        $('#promo-slider').owlCarousel({
            autoPlay: true,
            pagination: true,
            navigation: false,
            slideSpeed: 600,
            paginationSpeed: 400,
            singleItem: true
        });
    });
});

app.controller('MainController', function($scope) {
    $('.pjackpot-main').jOdometer({
        increment: 0.01,
        counterStart:'13615842.24',
        counterEnd: false,
        numbersImage: 'common/img/jodometer-numbers-gold.png',
        spaceNumbers: 2,
        formatNumber: true,
        widthNumber: 43,
        heightNumber: 95
    });
    $("#masthead-image1").hide();
});

app.controller('CasinoController', function($scope) {
    $('.pjackpot').jOdometer({
        increment: 0.01,
        counterStart:'13615842.24',
        counterEnd: false,
        numbersImage: 'common/img/jodometer-numbers-gold.png',
        spaceNumbers: 2,
        formatNumber: true,
        widthNumber: 43,
        heightNumber: 95
    });
    casinoMasthead();
});

app.controller('SlotsController', function($scope) {
    $('.pjackpot2').jOdometer({
        increment: 0.01,
        counterStart:'13615842.24',
        counterEnd: false,
        numbersImage: 'common/img/jodometer-numbers-gold-small.png',
        spaceNumbers: 2,
        formatNumber: true,
        widthNumber: 19,
        heightNumber: 41
    });
});

app.controller('SportsController', function($scope) {
});

app.controller('RulesController', function($scope, $rootScope) {
    $scope.isSet = function(checkTab) {
        return $rootScope.customerTab == checkTab;
    };
    $scope.setTab = function(setTab) {
        $rootScope.customerTab = setTab;
    };
});


app.controller("LoginController", function($scope, $http, $window, SweetAlert, loggedInStatus) {
        $scope.loginForm = {};
        $scope.isProcessing = false;
        $scope.processForm = function() {
            $scope.isProcessing = true;

            var url = "/api/player/Login";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.loginForm), // pass in data as strings
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                } // set the headers so angular passing info as form data (not request payload)
            }).success(function(data) {
                if (data.result == 1) {
                     $window.location.href="/";
                     $window.location.reload();
                }else{
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        SweetAlert.swal(data.message, "Please Try Again", "error");
                    }
                }
            }).error(function(data, status) {
                console.error('Repos error', status, data);
            })["finally"](function() {
                $scope.isProcessing = false;
            });
        };
    });

app.controller("LogoutController", function($scope,$scope, $http, $window, SweetAlert, loggedInStatus) {
    $scope.isProcessing = false;
    $scope.logout = function() {
        $scope.isProcessing = true;
        $http.get("/api/player/Logout")
            .success(function(data) {
                if (data.result == 1) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        SweetAlert.swal(data.message, "", "success");
                    }
                    loggedInStatus.setLoggedOutStatus();

                } else {
                    if (data.alert) {
                        if (bowser.msie && bowser.version <= 8) {
                            alert(data.message);
                        } else {
                            SweetAlert.swal(data.message, "Please Try Again", "error");
                        }
                    }
                }
            }).error(function(data, result) {
                console.error('Repos error', result, data);
            })["finally"](function() {
            $scope.isProcessing = false;
            $window.location.reload();
        });
    }
});

app.controller('SignUpController', function($scope) {
});

app.controller('NoticeController', function($rootScope,$scope,$cookies,$http,$window,SweetAlert) {
    $rootScope.writeQuestion={};

    $scope.notToday = function(){
        var expireDate = new Date();
        expireDate.setDate(expireDate.getDate() + 1);
        $cookies.put('notToday','true', {'expires': expireDate});
        $scope.closeThisDialog();
    };

    $rootScope.processForm = function() {
        $rootScope.isProcessing = true;
        var url = "/api/operation/GetWriteBoard";
        $http({
            method: 'POST',
            url: url,
            data: $.param($rootScope.writeQuestion), // pass in data as strings
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function(data) {
            if (data.result == 1) {
                if (bowser.msie && bowser.version <= 8) {
                    alert(data.message);
                } else {
                        SweetAlert.swal(data.message, "", "success");
                }
            } else {
                if (data.alert) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                            SweetAlert.swal(data.message, "Please Try Again", "error");
                    }
                }
            }
        }).error(function(data, result) {
            console.error('Repos error', result, data);
        })["finally"](function() {
            $rootScope.isProcessing = false;
        });
    }
});
