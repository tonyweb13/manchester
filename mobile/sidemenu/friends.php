<?session_start()?>
<div class="closeMenu" ng-click="closeFriends()"></div>

<div class="slide-menu-header">
    <h1 class="text-center" style="padding-left: 44px;"> 친구 목록 </span></h1>
</div>

<div class="friend-header" ng-controller="FriendController">
    <h4></h4>
    <div class="friend-body" ng-repeat="friend in friendList | limitTo:5">
        <div class="friend-left">
            <div class="friend-title"><span>번호:</span></div>
            <div class="friend-title"><span>아이디:</span></div>
            <div class="friend-title"><span>가입일:</span></div>
        </div>
        <div class="friend-name" ng-bind="$index+1"></div>
        <div class="friend-name" ng-bind="friend.RefererID"></div>
        <div class="friend-name" ng-bind="friend.RegisterDate"></div>
        <div class="clear"></div>
    </div>
</div>