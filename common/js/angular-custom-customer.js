app.controller('CustomerController', function($scope, $rootScope, $http) {
    $scope.isSet = function (checkTab) {
        return $rootScope.customerTab == checkTab;
    };

    $scope.setTab = function (setTab) {
        $rootScope.customerTab = setTab;

        if ($rootScope.customerTab == 2) {
            $http.get("/api/operation/GetBoardDetail?type=3&page=1")
                .success(function (data) {
                    angular.forEach(data.list, function (val) {
                        if (val.PopUp == 'y' && !$scope.getNotice) {
                            $rootScope.anouncementPopup = val;
                            //console.log($rootScope.anouncementPopup);
                            $scope.getNotice = true;
                            if (!$cookies.get('notToday')) {
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
                    $scope.eventList = data.list;

                }).error(function (data, result) {
                console.error('Repos error', result, data);
                })["finally"](function () {

                });

        } else if ($rootScope.customerTab == 3) {

            $http.get("/api/operation/GetBoardDetail?type=2&page=1")
                .success(function (data) {
                    angular.forEach(data.list, function (val) {
                        if (val.PopUp == 'y' && !$scope.getNotice) {
                            $rootScope.anouncementPopup = val;
                            //console.log($rootScope.anouncementPopup);
                            $scope.getNotice = true;
                            if (!$cookies.get('notToday')) {
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
                    $scope.faqList = data.list;

                }).error(function (data, result) {
                console.error('Repos error', result, data);
                })["finally"](function () {

                });

        } else if ($rootScope.customerTab == 4) {

            $http.get("/api/operation/GetBoardDetail?type=4&page=1")
                .success(function (data) {
                    angular.forEach(data.list, function (val) {
                        if (val.PopUp == 'y' && !$scope.getNotice) {
                            $rootScope.anouncementPopup = val;
                            //console.log($rootScope.anouncementPopup);
                            $scope.getNotice = true;
                            if (!$cookies.get('notToday')) {
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
                    $scope.customerList = data.list;

                }).error(function (data, result) {
                console.error('Repos error', result, data);
                })["finally"](function () {

                });
        }
    };
});
