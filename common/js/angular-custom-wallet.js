//WalletPopup
/*app.controller("WalletController", function($scope, $rootScope, $http, $q, SweetAlert, $translate) {

    $rootScope.addAmountUSD = [{
        price: 100,
        currency: 'USD'
    }, {
        price: 500,
        currency: 'USD'
    }, {
        price: 1000,
        currency: 'USD'
    }, {
        price: 5000,
        currency: 'USD'
    }, {
        price: 10000,
        currency: 'USD'
    }];

    $rootScope.addAmountKRW = [{
        price: 1000,
        currency: 'KRW'
    }, {
        price: 10000,
        currency: 'KRW'
    }, {
        price: 500000,
        currency: 'KRW'
    }, {
        price: 1000000,
        currency: 'KRW'
    }, {
        price: 10000000,
        currency: 'KRW'
    }];

    $rootScope.addAmountTHB = [{
        price: 100,
        currency: 'THB'
    }, {
        price: 500,
        currency: 'THB'
    }, {
        price: 1000,
        currency: 'THB'
    }, {
        price: 5000,
        currency: 'THB'
    }, {
        price: 10000,
        currency: 'THB'
    }];

    $rootScope.addAmountCNY = [{
        price: 100,
        currency: 'CNY'
    }, {
        price: 500,
        currency: 'CNY'
    }, {
        price: 1000,
        currency: 'CNY'
    }, {
        price: 5000,
        currency: 'CNY'
    }, {
        price: 10000,
        currency: 'CNY'
    }];

    $rootScope.addAmountMYR = [{
        price: 10,
        currency: 'MYR'
    }, {
        price: 100,
        currency: 'MYR'
    }, {
        price: 500,
        currency: 'MYR'
    }, {
        price: 1000,
        currency: 'MYR'
    }, {
        price: 5000,
        currency: 'MYR'
    }];

    $scope.getAgentBankList = function(){
        var url = "/api/system/GetAgentBankList";
        $http.get(url).success(function(data) {
            if (data.status == 200) {
                $rootScope.depositBankList = data.result.bankAccountList;
                //console.log($rootScope.depositBankList);
            } else {
                if (data.alert) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        $translate([data.message, "PleaseTryAgain"]).then(function (translations) {
                            SweetAlert.swal(translations[data.message], translations.PleaseTryAgain, "error");
                        });
                    }
                }
            }
        }).error(function(data, status) {
            console.error('Repos error', status, data);
        })["finally"](function() {

        });
    };

    $scope.alreadyLoadCountryAndLangue=false;
    $scope.getCountryAndLanguage = function(){
        if(!$scope.alreadyLoadCountryAndLangue){
            $q.all([
                $http.get("/api/system/GetLanguageList", {
                    cache: true
                })
                .success(function(data) {
                    if (data.status == 200) {
                        $rootScope.getLanguages = data.result.languageList;
                    }
                }).error(function(data, status) {
                    console.error('Repos error', status, data);
                })
            ]);
            $scope.alreadyLoadCountryAndLangue=true;
        }
    };

    $scope.isSet = function(checkTab) {
        return $rootScope.walletTab == checkTab;
    };

    $scope.setTab = function(setTab) {
        $rootScope.walletTab = setTab;
        if(setTab == 6){
            $scope.getCountryAndLanguage();
        }else if(setTab == 2){
            $scope.getAgentBankList();
        }
    };
});*/

app.controller('WalletController', function($scope, $rootScope, $http) {
    $scope.isSet = function(checkTab) {
        return $rootScope.walletTab == checkTab;
    };
    $scope.setTab = function(setTab) {
        $rootScope.walletTab = setTab;
    };
    $rootScope.loadBonus();

    $scope.loadBonusHistory = function (bonusType, page) {
        var url = "/api/player/GetBonusHistory.php?type=" + bonusType + "&page=" + page;
        $http({
            method: 'GET',
            url: url,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function (data) {

           // console.log(data);
            var table_data="";
            var page_data="";
            if(data.list.length){
                for(var i = 0 ;i<data.list.length;i++){
                    if(i%2 == 0){
                        table_data += "<tr>";
                    }else{
                        table_data += "<tr class='list-row-box'>";
                    }
                    table_data += "<td class=\"row-col width10 text-center\">"+data.list[i].num + "</td>";
                    table_data += "<td class=\"row-col width14 text-center\">"+data.list[i].BetDate.substr(0,10) + "</td>";
                    table_data += "<td class=\"row-col width20 text-center\">"+data.list[i].GameCode +"</td>";
                    table_data += "<td class=\"row-col width30 text-center\">"+data.list[i].GameName +"</td>";
                    table_data += "<td class=\"row-col width10 text-center\">"+data.list[i].BetCount +"</td>";
                    table_data += "<td class=\"row-col width14 text-center\">"+data.list[i].Comp +"</td>";
                    table_data += "</tr>";
                }
            }else{
                table_data += "<tr><td colspan='7' class=\"text-center\" style='height:100px;padding-top:100px;'>Non existing data.</td></tr>";
            }

            if(data.pages){
                for(var i=1;i<=data.pages;i++){
                    if(i==data.page){
                        page_data += "<li class='active'>"+i+"</li>";
                    }else {
                        page_data += "<li class=\"pointer link\" ng-click=\"loadBonusHistory('"+bonusType+"',"+i+")\">"+i+"</li>";
                    }
                }
            }
            if(bonusType=="mComp"){
                $(".mcomp-list").html(table_data);
                $(".pagination-mcomp").html(page_data);
            }else if(bonusType=="fComp"){
                $(".fcomp-list").html(table_data);
                $(".pagination-fcomp").html(page_data);
            }

        });
    }

});

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
            var url = "/api/finance/WalletTransfer";
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
                        //ngDialog.close();
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
                $scope.isProcessing = false;
            });
        }
    };
});

app.controller("BonusController", function($scope, $rootScope, $http, SweetAlert) {
    $scope.bonus = {};
    $scope.bonus.compAmount = 0;
    $scope.isProcessing=false;

    $scope.processForm = function() {
        if(!$scope.isProcessing){
            $scope.isProcessing = true;
            var url = "/api/marketing/UseBonus";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.bonus), // pass in data as strings
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
                        $scope.bonus.compAmount = 0;
                        $scope.bonus.gameCode = "";
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
                $scope.isProcessing = false;
            });
        }
    };
});

app.controller("CashHistoryController", function($scope, $http) {

    $scope.filteredPage = [];
    $scope.historyList={};
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.maxSize = 5;
    $scope.numPerPage = 10;

    $scope.loadHistory = function(){
        var url = "/api/player/GetHistory";
        $http.get(url).success(function(data) {
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

app.controller("DepositController", function($scope, $http, AmountService, SweetAlert, ngDialog) {
    $scope.isProcessing=false;
    $scope.deposit = {};
    $scope.deposit.amount = 0;
    var _timezone = jstz.determine();

    //$scope.error={};

    $scope.addAmount = function(sumAmount) {
        $scope.deposit.amount = AmountService.sumAmount($scope.deposit.amount, sumAmount);
    };

    $scope.resetAmount = function() {
        $scope.deposit.amount = AmountService.resetAmount();
    };

    $scope.processForm = function() {
        if(!$scope.isProcessing){
            $scope.isProcessing = true;

            $scope.deposit.depositDate =  moment.tz($scope.deposit.depositDate,_timezone.name()).format("YYYY-MM-DD HH:mm:ss Z");

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
                        ngDialog.close();
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

app.controller("WithdrawalController", function($scope, $http, AmountService, SweetAlert, ngDialog) {
    $scope.isProcessing=false;
    $scope.withdrawal = {};
    $scope.withdrawal.amount = 0;

    $scope.addAmount = function(sumAmount) {
        $scope.withdrawal.amount = AmountService.sumAmount($scope.withdrawal.amount, sumAmount);
    };
    $scope.resetAmount = function() {
        $scope.withdrawal.amount = AmountService.resetAmount();
    };

    $scope.processForm = function() {
        if (!$scope.isProcessing) {
            $scope.isProcessing = true;
            //var countryData = $("#withdrawalPhone").intlTelInput("getSelectedCountryData");
            //console.log(countryData.dialCode);
            //$scope.withdrawal.dialCode=countryData.dialCode;
            var url = "/api/finance/RequestWithdrawal";
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
                        ngDialog.close();
                    }

/*                    var defaultForm = {
                        amount : 0,
                        bankNo : "",
                        bankAccountNo : "",
                        bankHolder : "",
                        bankAccountType : "",
                        bankPlace : "",
                        bankOffice : "",
                        phone : $rootScope.playerDetail.phone,
                        memo : ""
                    };*/

                    //$scope.withdrawalForm.$setUntouched();
                    //$scope.withdrawal=defaultForm;

                } else {
                    //if (data.alert) {
                        if (bowser.msie && bowser.version <= 8) {
                            alert(data.message);
                        } else {
                            SweetAlert.swal(data.message, "Please Try Again", "error");
                        }
                    /*} else {
                        $scope.error.status = true;
                        $translate([data.message]).then(function (translations) {
                            if (data.amount != undefined) {
                                $scope.error.message = translations[data.message] + " " + data.amount;
                            } else {
                                $scope.error.message = translations[data.message];
                            }
                        });
                    }*/
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

app.controller("TransactionHistoryController", function($scope, $http, $rootScope, SweetAlert, $translate) {
    $scope.transactionList = {};
    $scope.filteredPage = [];
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.maxSize = 5;
    $scope.numPerPage = 10;

    $scope.loadTransactionHistory = function() {
        var url = "/api/finance/GetPlayerTransactionHistory";
        $http.get(url).success(function(data) {
            if (data.status == 200) {
                $scope.transactionList = data.result.transactionList;
                $scope.totalItems = data.result.transactionList.length;

            } else {
                if (data.alert) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        $translate([data.message, "PleaseTryAgain"]).then(function (translations) {
                            SweetAlert.swal(translations[data.message], translations.PleaseTryAgain, "error");
                        });
                    }
                }
            }
        }).error(function(data, status) {
            console.error('Repos error', status, data);
        })["finally"](function() {
            $scope.numPagesCal = function() {
                return Math.ceil($scope.transactionList.length / $scope.numPerPage);
            };

            $scope.numPages = $scope.numPagesCal();

            $scope.$watch('currentPage + numPerPage', function() {
                var begin = (($scope.currentPage - 1) * $scope.numPerPage),
                    end = begin + $scope.numPerPage;
                $scope.filteredPage = $scope.transactionList.slice(begin, end);

            });
        });
    };

    $scope.$watch(function() {
        return $rootScope.walletTab;
    }, function() {
        if($rootScope.walletTab == 5){
            $scope.loadTransactionHistory();
        }
    }, true);
});

app.controller("CouponController", function($scope, $http, $rootScope, SweetAlert, $filter) {
    $scope.isProcessing = false;
    $scope.coupone = {};
    $scope.couponList = {};
    $scope.filteredPage = [];
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.maxSize = 5;
    $scope.numPerPage = 10;
    $rootScope.couponCount = 0;
    $scope.usedCoupon = {};
    $scope.currentDate = $filter('date')(new Date(),'yyyy-MM-dd');

    $scope.loadCoupon = function(){
        var url = "/api/player/GetPlayerCoupon";
        $http.get(url).success(function(data) {
            $scope.couponList=data.list;
             angular.forEach($scope.couponList, function(value, key) {
             if (value.Status == "G") {
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

    $scope.useCoupon = function() {
        if (!$scope.isProcessing) {
            $scope.isProcessing = true;
            var url = "/api/marketing/UseCoupon";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.usedCoupon), // pass in data as strings
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                } // set the headers so angular passing info as form data (not request payload)
            }).success(function (data) {
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
                $scope.isProcessing = false;
            });
        }
    }
});

app.controller("FriendController", function($scope, $http) {

    $scope.filteredPage = [];
    $scope.friendList={};
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.maxSize = 5;
    $scope.numPerPage = 10;

    $scope.getFriendList = function(){
        var url = "/api/player/GetFriendList";
        $http.get(url).success(function(data) {
            $scope.friendList=data.list;
        })["finally"](function() {
            $scope.totalItems=$scope.friendList.length;
            //console.log($scope.totalItems);
            $scope.numPagesCal = function() {
                return Math.ceil($scope.friendList.length / $scope.numPerPage);
            };

            $scope.numPages = $scope.numPagesCal();

            $scope.$watch('currentPage + numPerPage', function() {
                var begin = (($scope.currentPage - 1) * $scope.numPerPage),
                    end = begin + $scope.numPerPage;
                $scope.filteredPage = $scope.friendList.slice(begin, end);
            });
        });
    };

});

app.controller("AccountDetailsController", function($scope, $http, $rootScope,SweetAlert,$translate) {
    $scope.editPlayerForm =  $rootScope.playerDetail;

    $scope.loadPlayerDetail = function() {
        var url = "/api/player/GetPlayerDetail";
        $http.get(url).success(function(data) {
            if (data.status == 200) {
                //console.log(data.result);
                $scope.editPlayerForm = data.result;
                $rootScope.playerDetail = data.result;
            } else {
                if (data.alert) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        $translate([data.message, "PleaseTryAgain"]).then(function (translations) {
                            SweetAlert.swal(translations[data.message], translations.PleaseTryAgain, "error");
                        });
                    }
                }
            }
        }).error(function(data, status) {
            console.error('Repos error', status, data);
        })["finally"](function() {

        });
    };

    $scope.processForm = function(){
        $scope.isProcessing = true;
        var url = "/api/player/EditPlayerDetail";
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.editPlayerForm), // pass in data as strings
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function (data) {
            if (data.status == 200) {
                if (bowser.msie && bowser.version <= 8) {
                    alert(data.message);
                    $scope.loadPlayerDetail();
                } else {
                    $translate([data.message]).then(function (translations) {
                        SweetAlert.swal(translations[data.message],"", "success");
                    });
                    $scope.loadPlayerDetail();
                    $scope.closeThisDialog();
                }
            } else {
                if (data.alert) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        $translate([data.message, "PleaseTryAgain"]).then(function (translations) {
                            SweetAlert.swal(translations[data.message], translations.PleaseTryAgain, "error");
                        });
                    }
                }
            }
        }).error(function (data, status) {
            console.error('Repos error', status, data);
        })["finally"](function () {
            $scope.isProcessing = false;
        });

    };

    $scope.$watch(function() {
        return $rootScope.walletTab;
    }, function() {
        if($rootScope.walletTab == 6){
            $scope.editPlayerForm =  $rootScope.playerDetail;
            $("#editPlayerFormPhone").intlTelInput("setNumber", $rootScope.playerDetail.phone);
        }
    }, true);
});

app.controller("ChangePasswordController", function($scope, $http, SweetAlert, ngDialog) {
    $scope.changePwd = {};
    $scope.processForm = function() {
        $scope.isProcessing = true;
        var url = "/api/player/ChangePassword";
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
                        ngDialog.close();
                }
                /*$scope.changePasswordForm.$setUntouched();
                $scope.changePwd ={};*/
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

app.controller("ChangePasswordPopupController", function($scope, $http, SweetAlert, ngDialog, $translate) {
    $scope.changePwd = {};

    $scope.processForm = function() {
        $scope.isProcessing = true;
        var url = "/api/player/ChangePassword";
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.changePwd), // pass in data as strings
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            } // set the headers so angular passing info as form data (not request payload)
        }).success(function(data) {
            if (data.status == 200) {
                if (bowser.msie && bowser.version <= 8) {
                    alert(data.message);
                } else {
                    $translate([data.message]).then(function (translations) {
                        SweetAlert.swal(translations[data.message],"","success");
                    });
                }
                $scope.changePwd ={};
                $scope.closeThisDialog();
            } else {
                if (data.alert) {
                    if (bowser.msie && bowser.version <= 8) {
                        alert(data.message);
                    } else {
                        $translate([data.message, "PleaseTryAgain"]).then(function (translations) {
                            SweetAlert.swal(translations[data.message], translations.PleaseTryAgain, "error");
                        });
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
