<?php session_start(); ?>
<div class="closeMenu" ng-click="closeDeposit()"></div>

<div ng-controller="DepositController">
    <div class="slide-menu-header" >
        <h1 class="text-center" style="padding-left: 14px;">입금신청</span></h1>
    </div>

    <form name="depositForm" novalidate ng-submit="processForm()">
        <div class="form-group">
            <label>게임선택 <em>*</em></label>
            <select class="form-control input-sm" ng-model="deposit.Wallet" ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in agentGspList">
                <option selected="selected" value="">게임을 선택해주세요.</option>
            </select>
        </div>
        <div class="form-group">
            <label>핸드폰 번호 <em>*</em></label>
            <input type="text" class="form-control input-sm" placeholder="000-0000-0000" ng-model="deposit.Phone"/>
            <div class="notes" style="margin-top: -1px;">
                <p>입력하실 번호로 계좌번호가 발송됩니다.</p>
            </div>
        </div>
        <div class="form-group">
            <label>입금하실 금액 <em>*</em></label>
            <input type="text" class="form-control input-sm custom-width" ng-model="deposit.Amount" format="number" value="{{deposit.Amount | number}}" valid-method="blur"/>
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
            <label>입금자 명 <em>*</em></label>
            <input type="text" class="form-control input-sm" placeholder="한글 2-10 자" ng-model="deposit.BankAccount" />
        </div>
        <div class="form-group">
            <label>남길 말</label>
            <textarea class="form-control input-group-sm" placeholder="남기실말을 적어주세요" ng-model="deposit.Memo"></textarea>
        </div>
        <blockquote>23:50 ~ 00:30, 휴일 다음 첫 영업일 새벽에는 은행점검으로 인해 계좌이체가 지연될 수 있습니다.
                위 시간 이외에도 몇몇 은행은 추가적 점검시간이 따로 있으니 이점 유념하시기 바랍니다.</blockquote>

        <button type="submit" class="btn btn-form" ng-disabled="isProcessing">입금신청</button>
    </form>
</div>
