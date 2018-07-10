<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/client.php";
session_start();
?>
<div id="popup-wallet" class="popup" ng-controller="WalletController" ng-init="setTab(selectWalletTab)">
    <div class="popup-heading">
        <h1>파파카지노 <strong>마이월렛</strong></h1>
    </div>
    <div class="popup-tabs">
        <ul class="popTabs">
            <li id="walletTab1"     ng-class="{ active:isSet(1) }"  ng-click="setTab(1)"><strong>머니 확인 / 이동</strong><span>Balance & Transfer</span></li>
            <li id="walletTab2"     ng-class="{ active:isSet(2) }"  ng-click="setTab(2)"><strong>입금신청</strong>       <span>Deposit</span></li>
            <li id="walletTab3"     ng-class="{ active:isSet(3) }"  ng-click="setTab(3)"><strong>출금신청</strong>       <span>Withdraw</span></li>
            <li id="walletTab4"     ng-class="{ active:isSet(4) }"  ng-click="setTab(4); loadBonus(); loadBonusHistory('mComp',1); loadBonusHistory('fComp',1)" >
                <strong>보너스 내역</strong>    <span>Bonus History</span></li>
            <li id="walletTab5"     ng-class="{ active:isSet(5) }"  ng-click="setTab(5);"><strong>친구 목록</strong>    <span>Friend List</span></li>
            <li id="walletTab6"     ng-class="{ active:isSet(6) }"  ng-click="setTab(6);" ng-controller="CouponController" ng-init="loadCoupon"><strong>쿠폰 내역</strong>
                <span>Coupon List <span class="ccount" ng-bind="couponCount"></span> </span></strong></li>
            <li id="walletTab7"     ng-class="{ active:isSet(7) }"  ng-click="setTab(7);"><strong>입출금 내역</strong>    <span>Cash History</span></li>
            <li id="walletTab8"     ng-class="{ active:isSet(8) }"  ng-click="setTab(8)"><strong>비밀번호 변경</strong>   <span>Change Password</span></li>
        </ul>
        <div class="clear"></div>
        <div ng-show="isSet(1)" class="popup-content">
            <div class="balance">
                <h1>내 게임머니 확인 <button type="button" class="btn btn-refresh2" ng-click="getBalance()" ng-disabled="isProcessing">새로 고침</button></h1>
                <div class="box-balance" ng-init="init()">
                   <ul>
                        <li ng-repeat="agentGsp in agentGspList" >
                            <!--<p class="bal-logo"><img src="http://kat.front888.com/manchester/common/img/icon-logo-ag.png" /></p>-->
                            <p class="bal-logo game-{{agentGsp.gspNo}}" ></p>
                            <p class="bal-name">
                                <span ng-bind="agentGsp.gspName"></span>
                            </p>
                            <p class="bal-type game-casino-{{agentGsp.gspNo}}" ></p>
                            <p class="bal-type game-sports-{{agentGsp.gspNo}}" ></p>
                            <p class="bal-type game-slots-{{agentGsp.gspNo}}" ></p>

                            <p class="bal-amount">
                                <strong  ng-show="agentGsp.amount == 'Loading'" ng-bind="agentGsp.amount"></strong>
                                <strong  ng-show="agentGsp.amount != 'Loading'" ng-bind="agentGsp.amount | customCurrency:cc_currency_symbol[userCurrency]"></strong>
                            </p>
                            <br class="clear" />
                        </li>
                       <li>
                           <p class="bal-logo">&nbsp;</p>
                           <p class="bal-name">
                               <strong style="margin-top: 17px;">내 밸런스</strong>
                           </p>
                           <p class="bal-type">&nbsp;</p>
                           <p class="bal-amount">
                                   <strong ng-show="totalBalance =='Loading'" ng-bind="totalBalance"></strong>
                                   <strong ng-show="totalBalance !='Loading'" ng-bind="totalBalance | customCurrency:cc_currency_symbol[userCurrency]"></strong>
                           </p>
                           <br class="clear">
                       </li>

                    </ul>
                </div>
            </div>
            <div class="transfer" ng-controller="TransferController">
                <h1>게임 머니 이동</h1>
                <div class="box-balance">
                    <form novalidate ng-submit="processForm()">
                        <div class="form-group">
                            <label>이동전 게임선택</label>
                            <p>
                                <select class="form-control input-sm"
                                        ng-model="transfer.fromWallet"
                                        ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in agentGspList  | filter:{transferEnable:true}">
                                    <option selected="selected" value="">게임을 선택해주세요.</option>
                                </select>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label>이동하실 금액</label>
                            <p>
                                <input type="text" placeholder="원" ng-model="transfer.amount" class="form-control input-sm" format="number" value="{{transfer.amount | number}}" valid-method="blur" />
                                <div class="btn-amounts">
                                    <button type="button" class="btn btn-option" ng-click="addAmount(10000)">1만원</button>
                                    <button type="button" class="btn btn-option" ng-click="addAmount(50000)">5만원</button>
                                    <button type="button" class="btn btn-option" ng-click="addAmount(100000)">10만원</button>
                                    <button type="button" class="btn btn-option" ng-click="addAmount(500000)">50만원</button>
                                    <button type="button" class="btn btn-option" ng-click="addAmount(1000000)">100만원</button>
                                    <button type="button" class="btn btn-option" ng-click="resetAmount()">Clear</button>
                                    <div class="clearfix"></div>
                                </div>
                            </p>
                            <div class="clear"></div>
                        </div>
                        <div class="form-group">
                            <label>이동후 게임 선택</label>
                            <p>
                                <select class="form-control input-sm"
                                        ng-model="transfer.toWallet"
                                        ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in filteredGspWalletList  | filter:{transferEnable:true}">
                                    <option selected="selected" value="">게임을 선택해주세요.</option>
                                </select>
                            </p>
                            <div class="clear"></div>
                        </div>
                        <button type="submit" class="btn btn-form" ng-disabled="isProcessing">게임 머니 이동</button>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div ng-show="isSet(2)" class="popup-content" ng-controller="DepositController">
            <form name="depositForm" novalidate ng-submit="processForm()">
                <blockquote class="blkAlert">수표입금시 입금처리 절대 되지 않습니다.</blockquote>
                <div class="form-group">
                    <label>게임선택</label>
                    <p>
                        <select class="form-control input-sm" ng-model="deposit.wallet">
                            <option selected="selected">게임을 선택해주세요.</option>
                            <? foreach ($variables['gameText'] as $k => $v) { ?>
                                <option value="<?= $k ?>"><?= $v ?></option>
                            <? } ?>
                        </select>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>핸드폰 번호</label>
                    <p>
                        <input type="text" class="form-control input-sm" placeholder="OOO-OOOO-OOOO" ng-model="deposit.phone">
                        <em class="notes">입력하실 번호로 계좌번호가 발송됩니다.</em>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>입금하실 금액</label>
                    <p>
                        <input type="text" maxlength="12" placeholder="0" class="form-control input-sm" ng-model="deposit.amount" format="number" value="{{deposit.amount | number}}" valid-method="blur"/>
                        <div class="btn-amounts">
                            <button type="button" class="btn btn-option" ng-click="addAmount(10000)">1만원</button>
                            <button type="button" class="btn btn-option" ng-click="addAmount(50000)">5만원</button>
                             <button type="button" class="btn btn-option" ng-click="addAmount(100000)">10만원</button>
                             <button type="button" class="btn btn-option" ng-click="addAmount(500000)">50만원</button>
                             <button type="button" class="btn btn-option" ng-click="addAmount(1000000)">100만원</button>
                            <button type="button" class="btn btn-option" ng-click="resetAmount()">Clear</button>
                            <div class="clearfix"></div>
                        </div>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>입금자 명</label>
                    <p>
                        <input type="text" class="form-control input-sm" ng-model="deposit.depositor" placeholder="한글 2-10 자">
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>Select Deposit Type</label>
                    <p>
                    <select ng-model="deposit.depositType">
                        <option value="">Please Select Deposit Type</option>
                        <option value="ATM">ATM</option>
                        <option value="Counter">Counter</option>
                    </select>
                    </p>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label>남길 말</label>
                    <p>
                        <textarea rows="4" cols="20" maxlength="300" class="form-control inputTextarea" ng-model="deposit.memo" placeholder="Type your comments here"></textarea>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <blockquote>
                    23:50 ~ 00:30, 휴일 다음 첫 영업일 새벽에는 은행점검으로 인해 계좌이체가 지연될 수 있습니다.<br />
                    위 시간 이외에도 몇몇 은행은 추가적 점검시간이 따로 있으니 이점 유념하시기 바랍니다.
                </blockquote>
                <button type="submit" class="btn btn-form" ng-disabled="isProcessing">입금신청</button>
            </form>
            <div class="clear"></div>
        </div>
        <div ng-show="isSet(3)" class="popup-content" ng-controller="WithdrawalController">
            <form novalidate ng-submit="processForm()">
                <div class="form-group">
                    <label>게임선택</label>
                    <p>
                        <select class="form-control input-sm" ng-model="withdrawal.wallet">
                            <option selected="selected">게임을 선택해주세요.</option>
                            <!--                            <option value="뉴오퍼스/슬롯">뉴오퍼스/슬롯</option>
                                                        <option value="마이크로/슬롯">마이크로/슬롯</option>
                                                        <option value="아시안게임">아시안게임</option>
                                                        <option value="신천지">신천지</option>
                                                        <option value="벳소프트슬롯">벳소프트슬롯</option>
                                                        <option value="ASC 스포츠">ASC 스포츠</option>-->
                            <? foreach ($variables['gameText'] as $k => $v) { ?>
                                <option value="<?= $k ?>"><?= $v ?></option>
                            <? } ?>
                        </select>
                    </p>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label>출금하실 금액 <em>*</em></label>
                    <p>
                        <input type="text" maxlength="12" placeholder="0" class="form-control input-sm" ng-model="withdrawal.amount"  format="number" value="{{withdrawal.amount | number}}" valid-method="blur"/>
                        <div class="btn-amounts">
                            <button type="button" class="btn btn-option" ng-click="addAmount(10000)">1만원</button>
                            <button type="button" class="btn btn-option" ng-click="addAmount(50000)">5만원</button>
                            <button type="button" class="btn btn-option" ng-click="addAmount(100000)">10만원</button>
                            <button type="button" class="btn btn-option" ng-click="addAmount(500000)">50만원</button>
                            <button type="button" class="btn btn-option" ng-click="addAmount(1000000)">100만원</button>
                            <button type="button" class="btn btn-option" ng-click="resetAmount()">Clear</button>
                            <div class="clearfix"></div>
                        </div>
                    </p>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label>은행 <em>*</em></label>
                    <p>
<!--                        <select class="form-control input-sm marginBottom">
                            <option value="" selected="selected">은행을 선택하세요</option>
                            <option value="1">SC제일은행</option>
                            <option value="2">경남은행</option>
                            <option value="3">광주은행</option>
                            <option value="4">국민은행</option>
                        </select>-->
                        <select  class="form-control input-sm marginBottom" ng-model="withdrawal.bankNo">
                            <option value="" selected="selected">은행을 선택하세요</option>
                            <? foreach ($variables['bank'] as $k => $v) { ?>
                                <option value="<?= $k ?>"><?= $v ?></option>
                            <? } ?>
                        </select>
                        <input type="number" ng-model="withdrawal.bankAccountNo" class="form-control input-sm" placeholder="계좌번호" />
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>입금자 명</label>
                    <p>
                        <input type="text" ng-model="withdrawal.bankHolder" class="form-control input-sm" placeholder="한글 2-10 자">
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>핸드폰 번호</label>
                    <p>
                        <input type="text" ng-model="withdrawal.phone" class="form-control input-sm" placeholder="OOO-OOOO-OOOO" value="">
                        <em class="notes">입력하실 번호로 계좌번호가 발송됩니다.</em>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>남길 말</label>
                    <p>
                        <textarea rows="4" cols="20" maxlength="300" ng-model="withdrawal.memo" class="form-control inputTextarea" placeholder="Type your comments here"></textarea>
                    </p>
                    <div class="clearfix"></div>
                </div>
                <blockquote>입금자명과 출금자명이 다를경우 본인확인 요청이 있을 수 있습니다.</blockquote>
                <button type="submit" class="btn btn-form" ng-disabled="isProcessing">Withdraw</button>
            </form>
        </div>
        <div ng-show="isSet(4)" class="popup-content">
            <div class="header-row-box">
                <div class="header-title width33 text-center">잔여 보너스</div>
                <div class="header-title width33 text-center">사용한 보너스</div>
                <div class="header-title width33 text-center">총 보너스</div>
                <div class="clear"></div>
            </div>
            <div class="list-row-box" ng-init="init()">
                <div class="row-col width33 text-center current-comp" ></div>
                <div class="row-col width33 text-center used-comp"></div>
                <div class="row-col width33 text-center total-comp"></div>
            </div>
            <div class="option-box" ng-controller="BonusController">
                <form novalidate ng-submit="processForm()">
                    <p>
                        <select class="form-control input-sm" ng-model="bonus.gameCode">
                            <option value="" selected="selected">게임을 선택해주세요</option>
                            <? foreach ($variables['gameText'] as $k => $v) { ?>
                                <option value="<?= $k ?>"><?= $v ?></option>
                            <? } ?>
                        </select>
                        <input type="text" ng-model="bonus.compAmount" class="form-control input-sm text-right" placeholder="금액" format="number" value="{{bonus.compAmount | number}}" valid-method="blur">
                        <button type="submit" class="btn" ng-disabled="isProcessing">콤프사용</button>
                    </p>
                </form>
            </div>

            <h1>유저 콤프 적립현황</h1>
            <div class="header-row-box">
                <div class="header-title width10 text-center">번호</div>
                <div class="header-title width14 text-center">베팅날짜</div>
                <div class="header-title width20 text-center">게임</div>
                <div class="header-title width30 text-center">플레이게임</div>
                <div class="header-title width10 text-center">베팅횟수</div>
                <div class="header-title width14 text-center">콤프</div>
                <div class="clear"></div>
            </div>

            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody class="mcomp-list"><tr><td colspan="7" class="text-center" style="height:100px;padding-top:100px;">Loading...</td></tr></tbody>
            </table>

            <uib-pagination boundary-links="true" total-items="totalItems" ng-model="currentPage" class="pagination-sm pagination-mComp" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination>


            <h1>친구 콤프 적립현황</h1>
            <div class="header-row-box">
                <div class="header-title width10 text-center">번호</div>
                <div class="header-title width14 text-center">베팅날짜</div>
                <div class="header-title width20 text-center">게임</div>
                <div class="header-title width30 text-center">플레이게임</div>
                <div class="header-title width10 text-center">베팅횟수</div>
                <div class="header-title width14 text-center">콤프</div>
                <div class="clear"></div>
            </div>

            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody class="fcomp-list"><tr><td colspan="7" class="text-center" style="height:100px;padding-top:100px;">Loading...</td></tr></tbody>
            </table>

            <uib-pagination boundary-links="true" total-items="totalItems" ng-model="currentPage" class="pagination-sm pagination-mComp" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination>

            <br /><br />
        </div>
        <div ng-show="isSet(5)" class="popup-content" ng-controller="FriendController" ng-init="getFriendList()" >
            <div class="header-row-box">
                <div class="header-title width33 text-center">번호</div>
                <div class="header-title width33 text-center">아이디</div>
                <div class="header-title width33 text-center">가입일</div>
                <div class="clear"></div>
            </div>

            <div class="list-row-box"  ng-repeat="friend in filteredPage">
                <div class="row-col width33 text-center" ng-bind="$index+1"></div>
                <div class="row-col width33 text-center" ng-bind="friend.RefererID"></div>
                <div class="row-col width33 text-center" ng-bind="friend.RegisterDate"></div>
            </div>

            <uib-pagination boundary-links="true" total-items="totalItems" ng-model="currentPage" class="pagination-sm" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination>

        </div>
        <div ng-show="isSet(6)" class="popup-content" ng-controller="CouponController" ng-init="loadCoupon()">
            <div class="header-row-box">
                <div class="header-title width-coupon text-center">쿠폰코드</div>
                <div class="header-title width-coupon text-center">쿠폰이름</div>
                <div class="header-title width-coupon text-center">쿠폰금액</div>
                <div class="header-title width-coupon text-center">만료일자</div>
                <div class="header-title width-coupon2 text-center">사용일자</div>
                <div class="header-title width-coupon1 text-center">요청</div>
                <div class="clear"></div>
            </div>

            <div class="list-row-box-coupon" ng-repeat="coupon in filteredPage">
                    <form novalidate ng-submit="useCoupon()">
                    <div class="row-col width-coupon text-left" ng-bind="coupon.CouponCode" ></div>
                    <div class="row-col width-coupon text-center" ng-bind="coupon.CouponName | limitTo: 11"></div>
                    <div class="row-col width-coupon text-center" ng-bind="coupon.CounponAmount | number" format="number" ></div>
                    <div class="row-col width-coupon text-center" ng-if="coupon.CouponExpiredDate" ng-bind="coupon.CouponExpiredDate | userDate"></div>
                    <div class="row-col width-coupon text-center" ng-if="!coupon.CouponExpiredDate">No Expiration Date</div>
                    <div class="row-col width-coupon2 text-right" ng-bind="coupon.CouponUsedDate"></div>
                    <div ng-if="coupon.Status=='G' && coupon.CouponExpiredDate > currentDate" class="row-col width-coupon1 text-right" >
                        <select class="form-control-coupon" ng-model="usedCoupon.GameCode">
                            <option value="">Select Game</option>
                            <?foreach ($variables['gameText'] as $k => $v) { ?>
                                <option value="<?= $k ?>"><?= $v ?></option>
                            <?}?>
                        </select>
                        <input class="form-control-coupon" style="width:128px; " type="hidden" name="CouponCode" value="{{coupon.CouponCode}}">
                        <button class="btn-coupon" type="submit" ng-disabled="isProcessing" >Claim</button>
                    </div>
                    <div ng-if="coupon.Status=='G' && coupon.CouponExpiredDate < currentDate" class="row-col width-coupon3 text-center">Expired</div>
                    <div ng-if="coupon.Status!='G'" class="row-col width-coupon3 text-center">Used</div>
                    </form>
            </div>

            <uib-pagination boundary-links="true" total-items="totalItems" ng-model="currentPage" class="pagination-sm" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination>

        </div>
        <div ng-show="isSet(7)" class="popup-content" ng-controller="CashHistoryController" ng-init="loadHistory()">
            <div class="header-row-box">
                <div class="header-title width08 text-center">구분</div>
                <div class="header-title width25 text-center">게임</div>
                <div class="header-title width12 text-center">신청 금액</div>
                <div class="header-title width10 text-center">서비스타입</div>
                <div class="header-title width14 text-center">서비스금액</div>
                <div class="header-title width10 text-center">진행상태</div>
                <div class="header-title width18 text-center">신청일자</div>
            </div>
            <div class="list-row-box" ng-repeat="history in filteredPage">
                <div class="row-col width08 text-center" ng-bind="history.TransactionType" ></div>
                <div class="row-col width25 text-center" ng-bind="history.Wallet" ></div>
                <div class="row-col width12 text-center" ng-bind="history.Amount | number" format="number" ></div>
                <div class="row-col width10 text-center" ng-bind="history.ServiceDescription" ></div>
                <div class="row-col width14 text-center" ng-bind="history.ServiceAmount" ></div>
                <div class="row-col width10 text-center" ng-bind="history.Status" ></div>
                <div class="row-col width18 text-center" ng-bind="history.Date" ></div>
            </div>

            <uib-pagination boundary-links="true" total-items="totalItems" ng-model="currentPage" class="pagination-sm" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></uib-pagination>

        </div>
        <div ng-show="isSet(8)" class="popup-content" ng-controller="ChangePasswordController">
            <form class="changepass" novalidate  ng-submit="processForm()">
                <div class="form-group">
                    <label>Current Password</label>
                    <p><input type="password" ng-model="changePwd.password" class="form-control input-sm" placeholder="" /></p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <p><input type="password" ng-model="changePwd.newPassword" class="form-control input-sm" placeholder="" /></p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <p><input type="password" class="form-control input-sm" ng-model="changePwd.newConfirmPassword" placeholder="" /></p>
                    <div class="clearfix"></div>
                </div>
                <button type="submit" class="btn btn-form" ng-disabled="isProcessing">비밀번호 변경</button>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>
