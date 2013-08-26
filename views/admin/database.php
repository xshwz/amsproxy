<form method="post" class="row">
    <div class="form-group col-sm-offset-3 col-sm-6">
        <label class="radio-inline">
            <input type="radio" name="operateType" checked value="query"> 查询
        </label>
        <label class="radio-inline">
            <input type="radio" name="operateType" value="execute"> 执行
        </label>
    </div>
    <div class="form-group col-sm-offset-3 col-sm-6">
        <textarea name="sql" rows="4" class="form-control"></textarea>
    </div>
    <div class="form-group col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-block">
            <span class="glyphicon glyphicon-play"></span>
        </button>
    </div>
</form>
