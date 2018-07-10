<?session_start()?>
<div class="closeMenu" ng-click="closeCashHistory()"></div>

<div class="slide-menu-header">
    <h1 class="text-center" style="padding-left: 44px;"> 입출금 내역 </span></h1>
</div>

<div class="cashHistory-header" ng-controller="CashHistoryController">
    <h4></h4>
    <div class="cashHistory-body" ng-repeat="history in filteredPage | limitTo: 5">
        <div class="friend-left">
            <div class="cashHistory-title"><span>구분:</span></div>
            <div class="cashHistory-title"><span>게임:</span></div>
            <div class="cashHistory-title"><span>신청 금액:</span></div>
<!--            <div class="cashHistory-title"><span>서비스타입:</span></div>-->
            <div class="cashHistory-title"><span>서비스금액:</span></div>
            <div class="cashHistory-title"><span>진행상태:</span></div>
            <div class="cashHistory-title"><span>신청일자:</span></div>
        </div>
        <div class="cashHistory-name" ng-bind="transactionType.{{history.TransactionType}}"></div>
        <div class="cashHistory-name"><strong ng-bind="(agentGspList | filter: {gspNo: history.Wallet})[0].gspName"></strong></div>
        <div class="cashHistory-name-amount" ng-bind="history.Amount | number" format="number"></div>
        <div class="cashHistory-name" ng-if='history.ServiceDescription != undefined' class="row-col width10 text-center" ng-bind="transactionType.{{history.ServiceDescription}}"></div>
        <div class="cashHistory-name" ng-if='history.ServiceDescription == undefined' class="row-col width10 text-center" ></div>
        <div class="cashHistory-name" ng-bind="history.ServiceAmount"></div>
        <div class="cashHistory-name" ng-bind="status.{{history.Status}}"></div>
        <div class="cashHistory-name" ng-bind="history.Date"></div>
        <div class="clear"></div>
    </div>
</div>