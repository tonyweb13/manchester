<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";
session_start(); ?>
<div class="closeMenu" ng-click="closeWithdraw()"></div>

<div ng-controller="WithdrawalController">
    <div class="slide-menu-header">
        <h1 class="text-center" style="padding-left: 14px;">출금신청</span></h1>
    </div>

    <form novalidate ng-submit="processForm()">
        <div class="form-group">
            <label>게임선택 <em>*</em></label>
            <select class="form-control input-sm" ng-model="withdrawal.Wallet" ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in agentGspList">
                <option selected="selected" value="">게임을 선택해주세요.</option>
            </select>
        </div>
        <div class="form-group">
            <label>출금하실 금액 <em>*</em></label>
            <input type="text" class="form-control input-sm custom-width" maxlength="12" placeholder="0" ng-model="withdrawal.Amount"  format="number" value="{{withdrawal.Amount | number}}" valid-method="blur"/>
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
            <label>은행 <em>*</em></label>
            <select  class="form-control input-sm marginBottom" ng-model="withdrawal.BankNo">
                <option value="" selected="selected">은행을 선택하세요</option>
                <? foreach ($variables['bank'] as $k => $v) { ?>
                    <option value="<?= $k ?>"><?= $v ?></option>
                <? } ?>
            </select>
        </div>

        <div class="form-group">
            <label>계좌번호 <em>*</em></label>
            <input type="number" ng-model="withdrawal.BankAccountNo" class="form-control input-sm" placeholder="계좌번호" />
        </div>

        <div class="form-group">
            <label>입금자 명 <em>*</em></label>
            <input type="text" class="form-control input-sm" placeholder="한글 2-10 자" ng-model="withdrawal.BankAccount" />
        </div>

        <div class="form-group">
            <label>핸드폰 번호 <em>*</em></label>
            <input type="text" class="form-control input-sm" placeholder="000-0000-0000" ng-model="withdrawal.Phone" />
            <div class="notes" style="margin-top: -1px;">
                <p>입력하실 번호로 계좌번호가 발송됩니다.</p>
            </div>
        </div>

        <div class="form-group">
            <label>남길 말</label>
            <textarea class="form-control input-group-sm" placeholder="남기실말을 적어주세요" ng-model="withdrawal.Memo"></textarea>
        </div>

        <blockquote>입금자명과 출금자명이 다를경우 본인확인 요청이 있을 수 있습니다.</blockquote>

        <button type="submit" class="btn btn-form" ng-disabled="isProcessing">출금신청</button>
    </form>
</div>
