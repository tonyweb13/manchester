<div class="slide-menu-header">
    <i class="backMenu" role="button" ng-click="closeSettings()"></i>
    <span>Account Settings</span>
</div>
<div ng-controller="SettingsController as tab">
    <ul class="tabs">
        <li id="settingsAccount"    ng-class="{ active:tab.isSet(1) }" ng-click="tab.setTab(1)">Account Details</li>
        <li id="settingsChangePass" ng-class="{ active:tab.isSet(2) }" ng-click="tab.setTab(2)">Change Password</li>
    </ul>
    <div class="clearfix"></div>
    <div ng-show="tab.isSet(1)">
        <div class="slide-bar">
            <h4><i class="icon-user"></i> Username</h4>
            <div class="clearfix"></div>
        </div>
        <div class="slide-bar">
            <h4><i class="icon-name"></i> Playername</h4>
            <div class="clearfix"></div>
            <!--<button class="btn-refresh"><i class="icon-refresh"></i> Edit</button>-->
        </div>
        <form>
            <div class="form-group">
                <label>Date of Birth</label>
                <!--<input type="text" class="form-control input-sm inputDate"
                       name="settingsDate"
                       id="settingsDatetimepicker"
                       ng-model="settings.settingsDate"
                       readonly />-->
                <select class="form-control input-sm selectDay">
                    <option value="" selected="selected">Day</option>
                    <option>1</option>
                    <option>2</option>
                </select>
                <select class="form-control input-sm selectMonth">
                    <option value="" selected="selected">Month</option>
                    <option>1</option>
                    <option>2</option>
                </select>
                <select class="form-control input-sm selectYear">
                    <option value="" selected="selected">Year</option>
                    <option>1997</option>
                    <option>1996</option>
                </select>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <div class="btn-group btn-gender" data-toggle="buttons">
                    <label class="btn active">
                        <input type="radio"
                               ng-model="settings.gender"
                               name="gender"
                               value="1"
                               required
                               checked />
                        <strong>MALE</strong>
                    </label>
                    <label class="btn">
                        <input type="radio"
                               ng-model="settings.gender"
                               name="gender"
                               value="0" />
                        <strong>FEMALE</strong>
                    </label>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control input-sm" placeholder="" />
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" class="form-control input-sm txt_phoneNo"
                       pattern="[0-9]*"
                       id="settingsPhone"
                       name="phone"
                       ng-model="settings.phone"
                       required />
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control input-sm" placeholder="" />
            </div>
            <div class="form-group">
                <label>Zip Code</label>
                <input type="number" pattern="[0-9]*" class="form-control input-sm" placeholder="" />
            </div>
            <div class="form-group">
                <label>Country</label>
                <select class="form-control input-sm">
                    <option value="" selected="selected">Please Select Country</option>
                    <option>Country 1</option>
                    <option>Country 2</option>
                </select>
            </div>
            <div class="form-group">
                <label>Language</label>
                <select class="form-control input-sm">
                    <option>Please Select Language</option>
                    <option>Language 1</option>
                    <option>Language 2</option>
                </select>
            </div>
            <button type="submit" class="btn btn-form marginBottom">Save</button>
            <button type="reset" class="btn btn-form btn-gray">Clear</button>
        </form>
    </div>
    <div ng-show="tab.isSet(2)">
        <form>
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" class="form-control input-sm" placeholder="" />
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control input-sm" placeholder="" />
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control input-sm" placeholder="" />
            </div>
            <button type="submit" class="btn btn-form">Save</button>
        </form>
    </div>
</div>