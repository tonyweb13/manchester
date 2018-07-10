<?session_start()?>
<div class="closeMenu" ng-click="closeTransfer()"></div>

<div class="slide-menu-header">
    <h1 class="text-center" style="padding-left: 44px;">Transfer</span></h1>
</div>

<div ng-controller="TransferController">
    <form ng-submit="processForm()">
        <div class="form-group">
            <label>이동전 게임선택 <em>*</em></label>
            <select class="form-control input-sm"
                    ng-model="transfer.fromWallet"
                    ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in agentGspList  | filter:{transferEnable:true}">
                <option selected="selected" value="">게임을 선택해주세요.</option>
            </select>
        </div>
        <div class="form-group">
            <label>이동하실 금액 <em>*</em></label>
            <input type="text" class="form-control input-sm custom-width" ng-model="transfer.amount" format="number" value="{{transfer.amount | number}}" valid-method="blur"/>
            <button type="button" class="btn btn-no-float" ng-click="resetAmount()">Clear</button>
            <div class="btn-amounts">
                <button type="button" class="btn btn-option" ng-click="addAmount(10000)">1만원</button>
                <button type="button" class="btn btn-option" ng-click="addAmount(50000)">5만원</button>
                <button type="button" class="btn btn-option" ng-click="addAmount(100000)">10만원</button>
                <button type="button" class="btn btn-option" ng-click="addAmount(500000)">50만원</button>
                <button type="button" class="btn btn-option" ng-click="addAmount(1000000)">100만원</button>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="form-group">
            <label>이동후 게임선택 <em>*</em></label>
            <select class="form-control input-sm"
                    ng-model="transfer.toWallet"
                    ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in filteredGspWalletList  | filter:{transferEnable:true}">
                <option selected="selected" value="">게임을 선택해주세요.</option>
            </select>
        </div>

        <button type="submit" class="btn btn-form" ng-disabled="isProcessing"> 게임 머니 이동</button>
    </form>
</div>
