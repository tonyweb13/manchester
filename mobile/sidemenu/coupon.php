<?session_start()?>
<div class="closeMenu" ng-click="closeCoupon()"></div>

<div class="slide-menu-header">
    <h1 class="text-center" style="padding-left: 44px;"> 쿠폰 <strong class="ccount" ng-bind="couponCount"></strong> </span></h1>
</div>

<div class="coupon-header" ng-controller="CouponController" ng-init="loadCoupon()">
    <h4></h4>
    <div class="coupon-body" ng-repeat="coupon in filteredPage" ng-if="coupon.Status == 'G'">
        <div class="coupon-left">
            <div class="coupon-title"><span>쿠폰코드:</span></div>
            <div class="coupon-title"><span>쿠폰이름:</span></div>
            <div class="coupon-title"><span>쿠폰금액:</span></div>
            <div class="coupon-title"><span>만료일자:</span></div>
            <div class="coupon-title"><span>요청:</span></div>
        </div>
        <div class="coupon-name"><strong ng-bind="coupon.CouponCode"></strong></div>
        <div class="coupon-name" ng-bind="coupon.CouponName"></div>
        <div class="coupon-name-amount" ng-bind="coupon.CounponAmount | number" format="number"></div>
        <div class="coupon-name" ng-bind="coupon.CouponExpiredDate | userDate"></div>
        <div class="coupon-name" ng-if="!coupon.CouponExpiredDate">무제한</div>
        <div class="coupon-name" ng-bind="coupon.CouponUsedDate"></div>
        <div class="coupon-name" ng-if="coupon.Status=='G' && coupon.CouponExpiredDate >= currentDate" class="row-col width-coupon1 text-right" >
            <select class="coupon-name" ng-model="transfer.fromWallet" name="GameCode" ng-options="agentGsp.gspNo as agentGsp.gspName for agentGsp in agentGspList">
                <option value="">게임 선택</option>
            </select>
            <input class="coupon-name" style="width:128px; " type="hidden" name="CouponCode" value="{{coupon.CouponCode}}">
            <button class="coupon-name" type="button" ng-click="useCoupon(transfer.fromWallet,coupon.CouponCode)" >신청</button>
        </div>
        <div class="coupon-name" ng-if="coupon.Status=='G' && coupon.CouponExpiredDate < currentDate">Expired</div>
        <div class="coupon-name" ng-if="coupon.Status=='Y'">Used</div>
        <div class="clear"></div>
    </div>
</div>