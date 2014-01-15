<% $this->pageTitle = '登录' %>

<link rel="stylesheet" href="css/site.css">

<form class="login-form" method="POST">
    <% if (isset($error)): %>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        <%= $error %>
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
            placeholder="密码">
        <label class="input-icon" for="input-pwd">
            <span class="glyphicon glyphicon-lock"></span>
        </label>
    </div>
    <div class="form-group">
        <div class="input-group">
            <input
                name="captcha"
                id="input-captcha"
                type="text"
                class="form-control"
                placeholder="验证码">
            <span class="input-group-addon">
                <img src="data:image/gif;base64,<%= $captcha %>" alt="captcha">
            </span>
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-block" type="submit">登录</button>
    </div>
    <p><em class="text-muted">
        <span class="glyphicon glyphicon-info-sign"></span>
        密码默认是身份证后六位，建议登录后修改
    </em></p>
</form>
