<% $this->pageTitle = '设置'; %>

<br>
<div class="form-horizontal">
    <div class="form-group">
        <label for="inputPassword" class="col-sm-4 control-label">密码</label>
        <div class="col-sm-4">
            <form class="form-inline" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control"
                            name="password"
                            id="inputPassword"
                            placeholder="新密码">
                        <span class="input-group-btn">
                            <button class="btn" type="submit">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label" for="inputCrypt">cookie 密钥</label>
        <div class="col-sm-4">
            <form class="form-inline" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            name="crypt_key"
                            value="<%= $this->setting->crypt_key; %>"
                            id="inputCrypt">
                        <span class="input-group-btn">
                            <button class="btn" type="submit">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="form-group">
        <label for="inputStartDate" class="col-sm-4 control-label">开学时间</label>
        <div class="col-sm-4">
            <form class="form-inline" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            value="<%= $this->setting->start_date; %>"
                            data-date-format="yyyy-mm-dd"
                            type="text"
                            class="form-control date-picker"
                            name="start_date"
                            id="inputStartDate">
                        <span class="input-group-btn">
                            <button class="btn" type="submit">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="form-group">
        <label
            for="inputEndDate"
            class="col-sm-4 control-label">放假时间</label>
        <div class="col-sm-4">
            <form class="form-inline" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            value="<%= $this->setting->end_date; %>"
                            data-date-format="yyyy-mm-dd"
                            type="text"
                            class="form-control date-picker"
                            name="end_date"
                            id="inputEndDate">
                        <span class="input-group-btn">
                            <button class="btn" type="submit">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
