<form id="send-form" class="form-horizontal" method="post">
    <div class="form-group">
        <label class="col-sm-3 col-sm-4 control-label">学号</label>
        <div class="col-sm-6 col-lg-4">
            <input type="text" name="receiver" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 col-sm-4 control-label">内容</label>
        <div class="col-sm-6 col-lg-4">
            <textarea
                name="message"
                type="text"
                rows="4"
                class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-4">
            <button class="btn" type="submit">
                <span class="glyphicon glyphicon-send"></span> 发送
            </button>
        </div>
    </div>
</form>
