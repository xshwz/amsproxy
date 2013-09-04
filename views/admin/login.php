<form class="login-form" method="post">
    <?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        密码错误
    </div>
    <?php endif; ?>
    <div class="form-group">
        <input
            name="pwd"
            id="input-pwd"
            type="password"
            class="form-control"
            placeholder="密码"/>
        <label for="input-pwd" class="input-icon">
            <span class="glyphicon glyphicon-lock"></span>
        </label>
    </div>
    <div class="form-group">
        <button class="btn btn-block" type="submit">登录</button>
    </div>
</form>
