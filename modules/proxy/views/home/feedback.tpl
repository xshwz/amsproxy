<% $this->pageTitle = '反馈'; %>

<div class="alert alert-info">
    <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
    <em>
        <span class="glyphicon glyphicon-info-sign"></span>
        建议通过邮箱 &lt;<a href="mailto:xiang.qiu@qq.com">xiang.qiu@qq.com</a>&gt; 向我反馈，我会第一时间回复你~
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
