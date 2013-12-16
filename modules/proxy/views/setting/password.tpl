<% $this->pageTitle = '修改密码'; %>

<form method="post" class="form-horizontal col-md-6" role="form">
    <legend><%= $_SESSION['student']['sid'] %> - 修改密码</legend>
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
        <label for="origin-password" class="col-md-4 control-label">原始密码：</label>
        <div class="col-md-8">
            <input id="origin-password" class="form-control" type="password" name="origin-password" placeholder="输入你的原始密码" />
        </div>
    </div>
    <div class="form-group">
        <label for="new-password" class="col-md-4 control-label">新密码：</label>
        <div class="col-md-8">
            <input id="new-password" class="form-control" type="password" name="new-password" placeholder="输入你的新密码" />
        </div>
    </div>
    <div class="form-group">
        <label for="new-password-t" class="col-md-4 control-label">新密码确认：</label>
        <div class="col-md-8">
            <input id="new-password-t" class="form-control" type="password" name="new-password-t" placeholder="再次输入你的新密码" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            <button type="submit" class="btn btn-block">确认修改</button>
        </div>
    </div>
</form>
