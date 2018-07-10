'use strict';

var app = angular.module('mobileApp', [
    'ngMessages',
    'ngDialog',
    'ngSweetAlert',
    'ngCurrencySymbol',
    'ngCookies'
]);

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

app.service('browser', ['$window', function($window) {
    return function() {
        var userAgent = $window.navigator.userAgent;
        var browsers = {chrome: /chrome/i, safari: /safari/i, firefox: /firefox/i, ie: /internet explorer/i};
        for(var key in browsers) {
            if (browsers[key].test(userAgent)) {
                return key;
            }
        }
        return 'unknown';
    }
}]);

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
                var noMatch = viewValue != scope.signUp.MemberPwd.$viewValue;
                ctrl.$setValidity('noMatch', !noMatch);
                return viewValue;
            });
        }
    }
});

app.directive('userNameDuplicated', function($http) {
    return {
        require: 'ngModel',
        link: function(scope, elm, attrs, ctrl) {
            var original;
            ctrl.$formatters.unshift(function(modelValue) {
                original = modelValue;
                return modelValue;
            });

            ctrl.$parsers.push(function(viewValue) {
                if (viewValue != undefined) {
                    if (viewValue.length >= 4) {
                        var url = "../api/player/CheckDuplicateName";
                        $http({
                            method: 'POST',
                            url: url,
                            data: $.param({
                                MemberID: viewValue
                            }),
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        }).success(function(data) {
                            if (data.result==0) {
                                ctrl.$setValidity('duplicated', false);
                            } else {
                                ctrl.$setValidity('duplicated', true);
                            }
                            ctrl.$setValidity('minlength', true);
                        });
                        return viewValue;
                    } else {
                        ctrl.$setValidity('minlength', false);
                        return viewValue;
                    }
                } else {
                    ctrl.$setValidity('minlength', false);
                    return viewValue;
                }
            })
        }
    };
});

app.directive('referrerCheck', function($http) {
    return {
        require: 'ngModel',
        link: function(scope, elm, attrs, ctrl) {
            var original;
            ctrl.$formatters.unshift(function(modelValue) {
                original = modelValue;
                return modelValue;
            });

            ctrl.$parsers.push(function(viewValue) {
                if (viewValue != "") {
                    if (viewValue.length >= 4) {
                        var url = "../api/player/CheckDuplicateName";
                        $http({
                            method: 'POST',
                            url: url,
                            data: $.param({
                                MemberID: viewValue
                            }),
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        }).success(function(data) {
                            if (data.result==0) {
                                ctrl.$setValidity('duplicated', true);
                            } else {
                                ctrl.$setValidity('duplicated', false);
                            }
                        });
                        return viewValue;
                    } else {
                        ctrl.$setValidity('duplicated', false);
                        return viewValue;
                    }
                } else {
                    ctrl.$setValidity('duplicated', true);
                    ctrl.$setPristine();
                    return viewValue;
                }
            })
        }
    };
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

app.controller('CommonController', function($scope,$rootScope,$http,ccCurrencySymbol,loggedInStatus,ngDialog,$cookies,$sce,browser,$window) {
    $rootScope.userCurrency="KRW";
    $rootScope.cc_currency_symbol = ccCurrencySymbol;
    $rootScope.agentGspList =[
        {'gspNo':1000,'gspName':'뉴오퍼스','transferEnable':true,'casinoEnable':true,'slotEnable':true,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        //{'gspNo':1004,'gspName':'벳소프트','transferEnable':true,'casinoEnable':false,'slotEnable':true,'androidEnable':true,'iosEnable':false,'amount':'Loading'},
        {'gspNo':1005,'gspName':'마이크로게이밍','transferEnable':true,'casinoEnable':true,'slotEnable':true,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        {'gspNo':1009,'gspName':'XTD','transferEnable':true,'casinoEnable':true,'slotEnable':false,'sportEnable':false,'androidEnable':false,'iosEnable':false,'amount':'Loading'},
        {'gspNo':1012,'gspName':'아시아 게이밍','transferEnable':true,'casinoEnable':true,'slotEnable':false,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        {'gspNo':1014,'gspName':'이주기','transferEnable':true,'casinoEnable':true,'slotEnable':false,'sportEnable':false,'androidEnable':true,'iosEnable':false,'amount':'Loading'},
        {'gspNo':1018,'gspName':'CMD 스포츠','transferEnable':false,'androidEnable':true,'iosEnable':true,'amount':'Loading'},
        {'gspNo':1016,'gspName':'ASC 스포츠','transferEnable':false,'androidEnable':true,'iosEnable':true,'amount':'Loading'}];

    $rootScope.readBoardContent=function(type,announceNo,comment){
        if(comment == undefined){
            comment = false;
        }
        var url="../api/operation/GetBoardDescription";
        $http({
            method: "POST",
            url: url,
            data: $.param({
                "type": type,
                "code": announceNo,
                "comment": comment
            }), // pass in data as strings
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function(data) {
            $rootScope.readTitle=data.content.Subject;
            $rootScope.readContents=$sce.trustAsHtml(data.content.Contents);
            if(comment){
                $rootScope.readCommentDate=data.content.WriteDate;
                $rootScope.readComment=$sce.trustAsHtml(data.content.comment.Comment);
            }
        }).error(function(data, status) {
            console.error('Repos error', status, data);
        })["finally"](function() {
            $rootScope.isRead=true;
        });
    };

    $http.get("../api/operation/GetBoardDetail?type=1&page=1")
        .success(function(data) {
            angular.forEach(data.list,function(val){
                if(val.PopUp=='y' && !$scope.getNotice){
                    $rootScope.anouncementPopup = val;
                    //console.log($rootScope.anouncementPopup);
                    $scope.getNotice=true;
                    if(!$cookies.get('notToday')){
                        ngDialog.open({
                            template: 'popup/notice.php',
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

    $rootScope.getBalance = function(){

        bodyScrollOff();
        $("#slide-wallet").addClass('slide-menu-open-left');
        $('.cover').fadeIn();

        if(!$scope.isProcessing){
            $scope.isProcessing=true;
            $http.get("../api/finance/CheckMemberBalance")
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

    $scope.playGame=function(gspNo,productType,gameId,isDownload) { // mobile

        if ($rootScope.loggedIn) {
        var url = "";
        var size = "";
        var target = "";

            if (productType == "sports") {
                    url = "../api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType;
                    size = "";
                    target = "_blank";

            } else if (productType == "live") {
                    if (gspNo == 1012) {
                        if(isDownload == true){
                            url = "http://agmbet.com";
                            size = "";
                            target = "_blank";
                        }else{
                            url = "../api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType;
                            size = "";
                            target = "_blank";
                        }
                    }else if(gspNo == 1005){
                        url = "http://mobile-resigner.valueactive.eu/launch88livedealer/apk?btag1=79633831&btag3=002";
                        size = "";
                        target = "_blank";
                    }else {
                        url = "http://db6bcfd27e4e66ff7ce6-81234aff981b54538de64e3b7f29cb87.r43.cf6.rackcdn.com/app-lapapa002-release-1.5.0.apk";
                    }

            } else if (productType == "slot") {
                if(gspNo == 1005){
                    if(isDownload == true){
                        url = "http://mobile-resigner.valueactive.eu/mobilecasino/download?btag1=79633831&btag2=&btag3=002";
                        size = "";
                        target = "_blank";
                    }else{
                        url = "../api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType + "&gameId=" + gameId;
                        size = "width=1024, height=592";
                        target = "_blank";
                    }
                }else{
                    url = "../api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType + "&gameId=" + gameId;
                    size = "width=1024, height=592";
                    target = "_blank";
                }
            } else if (productType == "etc") {
                    url = "../api/player/PlayGame?gspNo=" + gspNo + "&productType=" + productType;
                    size = "width=1024, height=682";
            }

            if (productType == 'slot' && gspNo != 1005) {
                target = gspNo + Math.random();
            } else if (productType == 'playCheck' && gspNo == 1005) {
                target = gspNo + "playCheck";
            } else {
                target = gspNo;
            }
            
            if(productType == "sports" && gspNo == 1016 && (browser() == "safari" && !navigator.userAgent.match('CriOS'))) {

                ngDialog.open({
                    template: '/mobile/popup/sportsSafariDisable.php',
                    className: 'ngdialog-theme-default ngdialog-notice',
                    showClose: false,
                    scope: $scope,
                    closeByEscape: false
                });

            }else if(productType == "slot" && gspNo == 1005 && (browser() == "safari" && navigator.userAgent.match('CriOS'))){
                ngDialog.open({
                    template: '/mobile/popup/slotsChromeDisable.php',
                    className: 'ngdialog-theme-default ngdialog-notice',
                    showClose: false,
                    scope: $scope,
                    closeByEscape: false
                });
            }else{
                var popupWindow = $window.open(url, target, size).focus();
            }


        } else {
             $scope.openLogin();
        }
    };

    $scope.init = function(isLogin) {
        if (isLogin) {
            loggedInStatus.setLoggedInStatus();
        }
    };

    $scope.notToday = function(){
        var expireDate = new Date();
        expireDate.setDate(expireDate.getDate() + 1);
        $cookies.put('notToday','true', {'expires': expireDate});
        ngDialog.close();
    };

    $scope.openLogin = function() { slideLoginOpen(); };
    $scope.closeLogin = function() { slideLoginClose(); };

    $scope.openSignUp = function() { slideSignUpOpen(); };
    $scope.closeSignUp = function() { slideSignUpClose(); };

    $scope.openWallet = function() { slideWalletOpen(); };
    $scope.closeWallet = function() { slideWalletClose(); };

    $scope.openDeposit = function() {
        if ($rootScope.loggedIn) {
            slideDepositOpen();
        } else {
            $scope.openLogin();
        }
    };
    $scope.closeDeposit = function() { slideDepositClose(); };

    $scope.openWithdraw = function() {
        if ($rootScope.loggedIn) {
           slideWithdrawOpen();
        } else {
            $scope.openLogin();
        }
    };
    $scope.closeWithdraw = function() { slideWithdrawClose(); };

    $scope.openTransfer = function() { slideTransferOpen(); };
    $scope.closeTransfer = function() { slideTransferClose(); };

    $scope.openBonus = function() {
        $scope.bonusMemberComp();
        $scope.bonusFriendComp();
        slideBonusOpen();
    };
    $scope.closeBonus = function() { slideBonusClose(); };

    $scope.openCoupon = function() { slideCouponOpen(); };
    $scope.closeCoupon = function() { slideCouponClose(); };

    $scope.closeFriends = function() { slideFriendsClose(); };
    $scope.closeCashHistory = function() { slideCashHistoryClose(); };

    $scope.openAccount = function() { slideAccountOpen(); };
    $scope.closeAccount = function() { slideAccountClose(); };

    $scope.closePanel = function () {
        slideLoginClose();
        slideSignUpClose();
        slideWalletClose();
        slideDepositClose();
        slideWithdrawClose();
        slideTransferClose();
        slideBonusClose();
        slideAccountClose();
    };
});

app.controller("LoginController", function($scope, $http, $window, SweetAlert) {
    $scope.loginForm = {};
    $scope.isProcessing = false;
    $scope.processForm = function () {
        if (!$scope.isProcessing) {
            $scope.isProcessing = true;

            var url = "../api/player/Login";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.loginForm), // pass in data as strings
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                } // set the headers so angular passing info as form data (not request payload)
            }).success(function (data) {
                if (data.result == 1) {
                    $window.location.href = "/mobile/#/";
                    $window.location.reload();
                } else {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        SweetAlert.swal(data.message, "Please Try Again", "error");
                    }
                }
            }).error(function (data, status) {
                console.error('Repos error', status, data);
            })["finally"](function () {
                $scope.isProcessing = false;
            });
        }
    };
});

app.controller("LogoutController", function($scope, $http, $window, SweetAlert, loggedInStatus) {
    $scope.isProcessing = false;
    $scope.logout = function() {
        $scope.isProcessing = true;
        $http.get("../api/player/Logout")
            .success(function(data) {
                if (data.result == 1) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert("로그아웃 되었습니다");
                    } else {
                        SweetAlert.swal("로그아웃 되었습니다", "", "success");
                    }
                    loggedInStatus.setLoggedOutStatus();
                    $window.location.reload();
                } else {
                    if (data.alert) {
                        if (bowser.msie && bowser.version <= 8) {
                            alert(data.message);
                        } else {
                            SweetAlert.swal("로그아웃 되었습니다", "Please Try Again", "error");
                        }
                    }
                }
            }).error(function(data, result) {
            console.error('Repos error', result, data);
        })["finally"](function() {
            $scope.isProcessing = false;
        });
    }
});