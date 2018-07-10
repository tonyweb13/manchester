<div id="popup-customer" class="popup"  ng-controller="NoticeController" ng-init="readBoardContent(anouncementPopup.Type,anouncementPopup.BoardCode)">
    <div class="notice-logo"></div>
    <div class="popup-content">
        <div class="notice">
        <span ng-bind="readTitle"></span>
        <span ng-bind-html="readContents">
        </span>
        <div class="clear"></div>
        </div>
    </div>
    <div class="notice-close"><button type="button" class="btn" ng-click="notToday()">오늘 하루 열지 않기</button></div>
</div>
