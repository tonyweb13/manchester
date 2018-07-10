<div id="popup-customer" class="popup" ng-controller="CustomerController" ng-init="setTab(selectCustomerTab)">
    <div class="popup-heading">
        <h1>파파카지노 <strong>고객센터</strong></h1>
    </div>
    <div class="popup-tabs" ng-controller="NoticeController">
        <ul class="popTabs">
            <li id="customerTab1"     ng-class="{ active:isSet(1) }"  ng-click="setTab(1)"><strong>공지사항</strong>        <span>Notice</span></li>
            <li id="customerTab2"     ng-class="{ active:isSet(2) }"  ng-click="setTab(2)"><strong>프로모션/이벤트</strong>  <span>Promotion / Event</span></li>
            <li id="customerTab3"     ng-class="{ active:isSet(3) }"  ng-click="setTab(3)"><strong>자주 묻는 질문</strong>   <span>FAQ</span></li>
            <li id="customerTab4"     ng-class="{ active:isSet(4) }"  ng-click="setTab(4)"><strong>1:1 문의</strong>        <span>1:1 Customer Service</span></li>
            <li id="customerTab5"     ng-class="{ active:isSet(5) }"  ng-click="setTab(5)"><strong>파트너 제휴 문의</strong> <span>Partnership</span></li>
        </ul>
        <div class="clear"></div>
        <div ng-show="isSet(1)" class="popup-content" >
            <div class="header-box-pop">Notice</div>
            <div class="header-box-pop-box" ng-bind-html="readContents"></div>
            <div class="header-row-box">
                <div class="header-title width08 text-center">번호</div>
                <div class="header-title width63 text-center">제목</div>
                <div class="header-title width18 text-center">작성일</div>
                <div class="header-title width08 text-center">조회수</div>
                <div class="clear"></div>
            </div>
            <div class="list-row-box" ng-repeat="announce in announceList | limitTo: 10">
                <div class="row-col width08 text-center" ng-bind="announce.num"></div>
                <div class="row-col width63-5 text-center" ng-bind="announce.Subject" ng-click="readBoardContent(announce.Type,announce.BoardCode)" style="cursor: pointer;" ></div>
                <div class="row-col width18 text-center" ng-bind="formatDate(announce.WriteDate) | date:'yyyy-MM-dd'"></div>
                <div class="row-col width08 text-center" ng-bind="announce.ViewCount"></div>
            </div>
        </div>
        <div ng-show="isSet(2)" class="popup-content">
            <div class="header-box-pop">EVENTS</div>
            <div class="header-box-pop-box" ng-bind-html="readContents"></div>
            <div class="header-row-box">
                <div class="header-title width08 text-center">번호</div>
                <div class="header-title width63 text-center">제목</div>
                <div class="header-title width18 text-center">작성일</div>
                <div class="header-title width08 text-center">조회수</div>
                <div class="clear"></div>
            </div>
            <div class="list-row-box" ng-repeat="event in eventList | limitTo: 10">
                <div class="row-col width08 text-center" ng-bind="event.num"></div>
                <div class="row-col width63-5 text-center" ng-bind="event.Subject" ng-click="readBoardContent(event.Type,event.BoardCode)" style="cursor: pointer;"></div>
                <div class="row-col width18 text-center" ng-bind="formatDate(event.WriteDate) | date:'yyyy-MM-dd'"></div>
                <div class="row-col width08 text-center" ng-bind="event.ViewCount"></div>
            </div>
        </div>
        <div ng-show="isSet(3)" class="popup-content">
            <div class="header-box-pop">FAQ</div>
            <div class="header-box-pop-box" ng-bind-html="readContents"></div>
            <div class="header-row-box">
                <div class="header-title width08 text-center">번호</div>
                <div class="header-title width63 text-center">제목</div>
                <div class="header-title width18 text-center">작성일</div>
                <div class="header-title width08 text-center">조회수</div>
                <div class="clear"></div>
            </div>
            <div class="list-row-box" ng-repeat="faq in faqList | limitTo: 10">
                <div class="row-col width08 text-center" ng-bind="faq.num"></div>
                <div class="row-col width63-5 text-center" ng-bind="faq.Subject" ng-click="readBoardContent(faq.Type,faq.BoardCode)" style="cursor: pointer;"></div>
                <div class="row-col width18 text-center" ng-bind="formatDate(faq.WriteDate) | date:'yyyy-MM-dd'"></div>
                <div class="row-col width08 text-center" ng-bind="faq.ViewCount"></div>
            </div>
        </div>
        <div ng-show="isSet(4)" class="popup-content">
            <div class="header-box-pop">Customer Service</div>
            <div ng-hide="showme">
                <div class="header-box-pop-box" ng-bind-html="readContents"></div>
                <div class="header-row-box">
                    <div class="header-title width08 text-center">번호</div>
                    <div class="header-title width63 text-center">제목</div>
                    <div class="header-title width18 text-center">작성일</div>
                    <div class="header-title width08 text-center">조회수</div>
                    <div class="clear"></div>
                </div>
                <div class="list-row-box" ng-repeat="customer in customerList | limitTo: 10">
                    <div class="row-col width08 text-center" ng-bind="customer.num"></div>
                    <div class="row-col width63-5 text-center" ng-bind="customer.Subject" ng-click="readBoardContent(customer.Type,customer.BoardCode)" style="cursor: pointer;"></div>
                    <div class="row-col width18 text-center" ng-bind="formatDate(customer.WriteDate) | date:'yyyy-MM-dd'"></div>
                    <div class="row-col width08 text-center" ng-bind="customer.ViewCount"></div>
                </div>
                <button type="button" class="btn btn-form" ng-click="showme=true">1:1문의하기</button>
            </div>
            <form ng-show="showme" id="customer-write-form" novalidate ng-submit="processForm()">
                <input ng-model="writeQuestion.type" type="hidden" value="{{4}}" >
                <div class="form-group">
                    <label>제목</label>
                    <p><input ng-model="writeQuestion.Subject" type="text" value="" class="form-control input-lg"></p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>내용</label>
                    <p><textarea rows="4" cols="20" ng-model="writeQuestion.Contents" class="form-control inputTextarea" placeholder="1000자 이내로 작성해 주시기 바랍니다"></textarea></p>
                    <div class="clearfix"></div>
                </div>
                <button type="submit" class="btn btn-form" ng-disabled="isProcessing">작성 완료</button>
            </form>
        </div>
        <div ng-show="isSet(5)" class="popup-content">
            <form id="partner-write-form" novalidate ng-submit="processForm()">
                <input ng-model="writeQuestion.type" type="hidden" value="{{5}}" >
                <div class="form-group">
                    <label>제목</label>
                    <p><input ng-model="writeQuestion.Subject" type="text" value="" class="form-control input-lg"></p>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>내용</label>
                    <p><textarea rows="4" cols="20" ng-model="writeQuestion.Contents" class="form-control inputTextarea" placeholder="1000자 이내로 작성해 주시기 바랍니다"></textarea></p>
                    <div class="clearfix"></div>
                </div>
                <button type="submit" class="btn btn-form" ng-disabled="isProcessing">작성 완료</button>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>
