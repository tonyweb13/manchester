<div class="sub-gamebutton" ng-controller="SportsController" ng-init="playGame('1018','sports')">
    <ul>
        <li class="active" ng-click="playGame('1018','sports')">CMD</li>
        <li  ng-click="playGame('1016','sports')">ASC</li>
    </ul>
</div>
<div class="sports-content">
<!--    <iframe width="1022px" height="824px" ng-src="http://podds.sbsports.gsoft88.net/web-root/restricted/?lang=ko&amp;oddstyle=HK"></iframe>-->
    <iframe name="sport" width="1022px" height="824px" ng-src="{{sportIURL}}"></iframe>
</div>
