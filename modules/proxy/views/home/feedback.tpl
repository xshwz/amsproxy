<% $this->pageTitle = '反馈'; %>


<form
    id="feedback-form"
    method="post">
    <input type="hidden" value="<?php echo $_SESSION['student']['sid']; ?>">
    <div class="form-group">
        <textarea
            name="message"
            rows="4"
            placeholder="有什么想要对我们说的吗？有什么建议或者遇到问题?"
            id="input-msg"
            class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-block">
        <i class="glyphicon glyphicon-ok"></i> 反馈
    </button>
</form>
