<% $this->pageTitle = '修改密码'; %>

<form method="post" class="form-horizontal" role="form">
    <% if (isset($error)): %>
    <div class="form-group">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <span class="glyphicon glyphicon-exclamation-sign"></span>
            <%= $error %>
        </div>
    </div>
    <% endif; %>
    <div class="form-group">
        <label for="origin-password" class="col-sm-5 control-label">当前密码：</label>
        <div class="col-lg-3 col-md-4 col-sm-5">
            <input id="origin-password" class="form-control" type="password" name="origin-password" placeholder="请输入你的当前密码" />
        </div>
    </div>
    <div class="form-group">
        <label for="new-password" class="col-sm-5 control-label">新密码：</label>
        <div class="col-lg-3 col-md-4 col-sm-5">
            <input id="new-password" class="form-control" type="password" name="new-password" placeholder="请输入你的新密码" />
        </div>
    </div>
    <div class="form-group">
        <label for="new-password-t" class="col-sm-5 control-label">确认密码：</label>
        <div class="col-lg-3 col-md-4 col-sm-5">
            <input id="new-password-t" class="form-control" type="password" name="new-password-t" placeholder="请再次输入你的新密码" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-5 col-md-4 col-sm-5 col-lg-3">
            <button type="submit" class="btn btn-block">确认修改</button>
        </div>
    </div>
</form>
