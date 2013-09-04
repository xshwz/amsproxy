<form class="login-form" method="POST">
    <?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        登录失败，可能是学号或密码错误
    </div>
    <?php endif; ?>
    <div class="form-group">
        <input
            name="sid"
            id="input-sid"
            type="text"
            class="form-control"
            placeholder="学号"
            value="<?php if (isset($sid)) echo $sid; ?>">
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
