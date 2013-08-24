<form
    id="feedback-form"
    class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2"
    action="<?php echo Yii::app()->createUrl('home/feedback')?>"
    method="post">
    <input type="hidden" value="<?php echo $_SESSION['student']['sid']; ?>">
    <div class="form-group">
        <textarea
            type="text"
            name="msg"
            rows="4"
            placeholder="有什么意见或问题想要对我们说？"
            id="input-msg"
            class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-block">
        <i class="glyphicon glyphicon-ok"></i> 反馈
    </button>
</form>
