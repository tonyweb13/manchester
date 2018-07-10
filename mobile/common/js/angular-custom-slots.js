app.controller("TabController", function() {
    this.tab = 1;

    this.isSet = function(checkTab) {
        return this.tab === checkTab;
    };

    this.setTab = function(setTab) {
        this.tab = setTab;
    };
});

app.controller('SlotController', function($scope,$http,$filter,SweetAlert) {
    $scope.gspNo = "";
    //$scope.gspSlotItems = {};
    $scope.slotItems = {};
    $scope.category={};

    $scope.init = function () {
        $scope.loadSlot(1005);
    };

    $scope.comingSoon = function() {
        SweetAlert.swal("준비중입니다.");
    };

    $scope.loadSlot = function(gspNo, category){
        $scope.slotItems={};
        if ($scope.gspSlotItems == undefined) {
            $http.get("../api/system/GetGspSlotGameList")
                .success(function (data) {
                    $scope.gspSlotItems = data;
                }).error(function (data, result) {
                console.error('Repos error', result, data);
            })["finally"](function () {
                $scope.gspNo = gspNo;
            });
        }

        $scope.gspNo = gspNo;
        $('#nav-slot-list li').click(function(){
            $(this).siblings('.active').removeClass('active');
            $(this).addClass('active');
        });

        if (category == undefined) {
            if (gspNo == 1005) {
                $scope.category = "Advanced_Slot";
                $('.slot-1005-first').addClass('active');
            } else if (gspNo == 1000) {
                $scope.category = "Slots_3d";
                $('.slot-1000-first').addClass('active');
            } else if (gspNo == 1004) {
                $scope.category = "Slots";
                $('.slot-1004-first').addClass('active');
            }
        }else{
            $scope.category=category;
        }

        $scope.slotFilter = function(slot){
            return (slot.cat == $scope.category);
        };
    }

});

