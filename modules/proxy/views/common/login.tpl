<% $this->pageTitle = '登录-惠大微报' %>

<link rel="stylesheet" href="css/site.css">

<form class="login-form" method="POST">
    <% if (isset($error)): %>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        <%= $error %>
    </div>
    <% endif %>
    <% if ($message !== null): %>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        <%= $message %>
    </div>
    <% endif %>
    <div class="form-group">
        <input
            name="sid"
            id="input-sid"
            type="text"
            class="form-control"
            placeholder="学号"
            value="<% if (isset($sid)) echo $sid; %>">
        <label class="input-icon" for="input-sid">
            <span class="glyphicon glyphicon-user"></span>
        </label>
    </div>
    <div class="form-group">
        <input
            name="pwd"
            id="input-pwd"
            type="password"
            class="form-control"
            placeholder="密码"
            value="<% if (isset($pwd)) echo $pwd; %>">
        <label class="input-icon" for="input-pwd">
            <span class="glyphicon glyphicon-lock"></span>
        </label>
    </div>
    <% if ($captcha =='') echo '<!--'; %>
    <div class="form-group">
        <div class="input-group">
            <input
                name="captcha"
                id="input-captcha"
                type="text"
                class="form-control"
                placeholder="不更新数据,不用验证码~">
            <span class="input-group-addon">
                <img src="data:image/gif;base64,<%= $captcha %>" alt="captcha">
            </span>
        </div>
    </div>
    <% if ($captcha == '') echo '-->'; %>
    <div class="form-group">
        <button class="btn btn-block" type="submit">登录</button>
    </div>
    <br>
    <p class="text-muted">
        <span class="glyphicon glyphicon-info-sign"></span>
        首次登陆时间变快了~~<br>
        最近使用人数比较多,验证码还是不启用了~
    </p>
</form>
