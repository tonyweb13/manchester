app.controller("TransferController", function($scope, $rootScope, $http, SweetAlert, AmountService) {
    $scope.transfer = {};
    $scope.transfer.amount = 0;
    $scope.isProcessing=false;

    $scope.gspTransfer={};
    $scope.filteredGspWalletList = $rootScope.agentGspList;
    $scope.$watch('transfer.fromWallet', function() {
        $scope.filteredGspWalletList = [];
        angular.forEach($rootScope.agentGspList, function(val) {
            if (val.gspNo != $scope.transfer.fromWallet) {
                //console.log(val);
                this.push(val);
            }
        }, $scope.filteredGspWalletList);
    });


    $scope.addAmount = function(sumAmount) {
        $scope.transfer.amount = AmountService.sumAmount($scope.transfer.amount, sumAmount);
    };

    $scope.resetAmount = function() {
        $scope.transfer.amount = AmountService.resetAmount();
    };

    $scope.processForm = function() {
        if(!$scope.isProcessing){
            $scope.isProcessing = true;
            var url = "../api/finance/WalletTransfer";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.transfer), // pass in data as strings
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                } // set the headers so angular passing info as form data (not request payload)
            }).success(function(data) {
                if (data.result == 1) {
                    if (bowser.msie && bowser.version <= 8) {
                        //Balance.getBalance("all");
                        alert(data.message);
                    } else {
                        //Balance.getBalance("all");
                        SweetAlert.swal(data.message,"","success");
                        $scope.closeTransfer();
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
                $scope.getBalance();
                $scope.isProcessing = false;
            });
        }
    };
});

app.controller("DepositController", function($scope, $http, AmountService, SweetAlert) {
    $scope.isProcessing=false;
    $scope.deposit = {};
    $scope.deposit.Amount = 0;
    var _timezone = jstz.determine();

    //$scope.error={};

    $scope.addAmount = function(sumAmount) {
        $scope.deposit.Amount = AmountService.sumAmount($scope.deposit.Amount, sumAmount);
    };

    $scope.resetAmount = function() {
        $scope.deposit.Amount = AmountService.resetAmount();
    };

    $scope.processForm = function() {
        if(!$scope.isProcessing){
            $scope.isProcessing = true;

            $scope.deposit.DepositDate =  moment.tz($scope.deposit.DepositDate,_timezone.name()).format("YYYY-MM-DD HH:mm:ss Z");

            var url = "/api/finance/RequestDeposit";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.deposit), // pass in data as strings
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                } // set the headers so angular passing info as form data (not request payload)
            }).success(function(data) {
                //$scope.error.status=false;
                if (data.result == 1) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        SweetAlert.swal(data.message,"","success");
                        $scope.closeDeposit();
                    }

                } else {
                    //if (data.alert) {
                        if (bowser.msie && bowser.version <= 8) {
                            alert(data.message);
                        } else {
                            SweetAlert.swal(data.message, "Please Try Again", "error");
                        }
                }
            }).error(function(data, result) {
                console.error('Repos error', result, data);
            })["finally"](function() {
                $scope.isProcessing = false;
            });
        }
    };

});

app.controller("WithdrawalController", function($scope, $http, AmountService, SweetAlert) {
    $scope.isProcessing=false;
    $scope.withdrawal = {};
    $scope.withdrawal.Amount = 0;

    $scope.addAmount = function(sumAmount) {
        $scope.withdrawal.Amount = AmountService.sumAmount($scope.withdrawal.Amount, sumAmount);
    };
    $scope.resetAmount = function() {
        $scope.withdrawal.Amount = AmountService.resetAmount();
    };

    $scope.processForm = function() {
        if (!$scope.isProcessing) {
            $scope.isProcessing = true;
            var url = "../api/finance/RequestWithdrawal";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.withdrawal), // pass in data as strings
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                } // set the headers so angular passing info as form data (not request payload)
            }).success(function (data) {
                //$scope.error.status = false;
                if (data.result == 1) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                       SweetAlert.swal(data.message, "", "success");
                        $scope.closeWithdraw();
                    }
                } else {
                        if (bowser.msie && bowser.version <= 8) {
                            alert(data.message);
                        } else {
                            SweetAlert.swal(data.message, "Please Try Again", "error");
                        }
                }
            }).error(function (data, result) {
                alert("withdraw" + data);
                console.error('Repos error', result, data);
            })["finally"](function () {
                $scope.isProcessing = false;
            });
        }
    };
});

app.controller("ChangePasswordController", function($scope, $http, SweetAlert) {
    $scope.changePwd = {};
    $scope.processForm = function() {
        $scope.isProcessing = true;
        var url = "../api/player/ChangePassword";
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.changePwd), // pass in data as strings
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function(data) {
            if (data.result == 1) {
                if (bowser.msie && bowser.version <= 8) {
                    alert(data.message);
                } else {
                    SweetAlert.swal(data.message,"","success");
                    $scope.closeAccount();
                    $scope.closeWallet();
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
        }).error(function(data, status) {
            console.error('Repos error', status, data);
        })["finally"](function() {
            $scope.isProcessing = false;
        });
    };
});

app.controller("BonusMCompController", function($scope, $rootScope, $http) {

    $scope.bonusHistoryMainList={};

    $rootScope.bonusMemberComp = function(){
        var url = "../api/player/GetBonusHistory.php?type=mComp";
        $http.get(url).success(function(data) {
            $scope.bonusHistoryMainList=data.list;
        });
    }

});

app.controller("BonusFCompController", function($scope, $rootScope, $http) {

    $scope.bonusHistoryMainList={};

    $rootScope.bonusFriendComp = function(){
        var url = "../api/player/GetBonusHistory.php?type=fComp";
        $http.get(url).success(function(data) {
            $scope.bonusHistoryMainList=data.list;
        });
    }

});

app.controller("CouponController", function($scope, $http, $rootScope, SweetAlert, $filter) {

    $scope.couponList = {};
    $scope.filteredPage = [];
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.maxSize = 5;
    $scope.numPerPage = 10;
    $rootScope.couponCount = 0;
    $scope.currentDate = $filter('date')(new Date(),'yyyy-MM-dd');

    $rootScope.loadCoupon = function(){
        var url = "../api/player/GetPlayerCoupon";
        $http.get(url).success(function(data) {
            $scope.couponList=data.list;
            angular.forEach($scope.couponList, function(value, key) {
                if (value.Status == "G" && value.CouponExpiredDate >= $scope.currentDate) {
                    $rootScope.couponCount += 1;
                }
            });
        })["finally"](function() {
            $scope.totalItems=$scope.couponList.length;
            $scope.numPagesCal = function() {
                return Math.ceil($scope.couponList.length / $scope.numPerPage);
            };

            $scope.numPages = $scope.numPagesCal();

            $scope.$watch('currentPage + numPerPage', function() {
                var begin = (($scope.currentPage - 1) * $scope.numPerPage),
                    end = begin + $scope.numPerPage;
                $scope.filteredPage = $scope.couponList.slice(begin, end);
            });
        });
    };

    $scope.useCoupon = function(GameCode, CouponCode) {

        var url = "../api/marketing/UseCoupon";
        $http({
            method: 'POST',
            url: url,
            data: $.param({
                'GameCode': GameCode,
                'CouponCode': CouponCode
            }), // pass in data as strings
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function (data) {
            //console.log(data+ " " +self+ " "+couponCode+ " "+$scope.claim);
            if (data.result == 1) {
                if (data.alert) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        SweetAlert.swal(data.message, "", "success");
                    }
                    $scope.loadCoupon();
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
        }).error(function (data, result) {
            console.error('Repos error', result, data);
        })["finally"](function () {
        });
    }
});

app.controller("FriendController", function($scope,$rootScope,$http) {

    $scope.filteredPage = [];
    $scope.friendList={};
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.maxSize = 5;
    $scope.numPerPage = 10;

    $rootScope.getFriendList = function(){
        var url = "../api/player/GetFriendList";
        $http.get(url).success(function(data) {
            slideFriendsOpen();
            $scope.friendList=data;
        });
    };

});

app.controller("CashHistoryController", function($rootScope,$scope,$http) {
    $scope.transactionType = {'Transfer':'머니이동','Withdrawal':'출금',Deposit:'입금','NO':'일반','FS':'첫입금','DA':'일일첫입금','CO':'콤프','CP':'콤프','ET':'기타','':''};
    $scope.status = {'D':'취소','P':'확인중','R':'신청','S':'처리완료'};
    $scope.filteredPage = [];
    $scope.historyList={};
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.maxSize = 5;
    $scope.numPerPage = 10;

    $rootScope.loadHistory = function(){
        var url = "../api/player/GetHistory";
        $http.get(url).success(function(data) {
            slideCashHistoryOpen();
            $scope.historyList=data.list;
        })["finally"](function() {
            $scope.totalItems=$scope.historyList.length;
            $scope.numPagesCal = function() {
                return Math.ceil($scope.historyList.length / $scope.numPerPage);
            };

            $scope.numPages = $scope.numPagesCal();

            $scope.$watch('currentPage + numPerPage', function() {
                var begin = (($scope.currentPage - 1) * $scope.numPerPage),
                    end = begin + $scope.numPerPage;
                $scope.filteredPage = $scope.historyList.slice(begin, end);
            });
        });
    };

});