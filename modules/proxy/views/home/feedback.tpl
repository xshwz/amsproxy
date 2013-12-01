<% $this->pageTitle = '反馈'; %>

<div class="alert alert-info text-muted">
    <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
    <em>
        <span class="glyphicon glyphicon-info-sign"></span>
        你也可以关注我们的微信公众号“相思青果”，通过微信向我们反馈。
        <a href="<%= $this->createUrl('/site/wechat'); %>">&gt;&gt;关于微信公众号</a>
    </em>
</div>

<form
    id="feedback-form"
    method="post">
    <input type="hidden" value="<?php echo $_SESSION['student']['sid']; ?>">
    <div class="form-group">
        <textarea
            name="message"
            rows="4"
            placeholder="有什么想要对我们说的吗？"
            id="input-msg"
            class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-block">
        <i class="glyphicon glyphicon-ok"></i> 反馈
    </button>
</form>
