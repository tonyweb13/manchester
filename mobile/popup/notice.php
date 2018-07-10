<div id="popup-notice" class="popup" ng-init="readBoardContent(anouncementPopup.Type,anouncementPopup.BoardCode)">
    <div class="slide-menu-header">
        <label ng-bind="readTitle"></label>
        <div class="clear"></div>
    </div>
    <div class="ngDialog">
        <div class="popup-content" ng-bind-html="readContents"></div>
        <button type="button" class="btn btn-form btn-gray" ng-click="notToday()">오늘 하루 열지 않기</button>
    </div>
</div>
