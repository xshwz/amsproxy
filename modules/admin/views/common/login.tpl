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
            value="<%? $sid %>">
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
        <button class="btn btn-block" type="submit">登录</button>
    </div>
</form>
