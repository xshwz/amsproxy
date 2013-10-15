<div class="article form-horizontal">
    <?php foreach ($archives as $key => $value): ?>
    <div class="form-group">
        <label class="col-xs-5 control-label"><?php echo $key; ?></label>
        <div class="col-xs-7">
            <p class="form-control-static"><?php echo $value; ?></p>
        </div>
    </div>
    <?php endforeach; ?>

    <!--
    <a href="#archives-edit" title="编辑" data-toggle="modal" class="btn archives-edit">
        <span class="glyphicon glyphicon-pencil"></span>
    </a>
    -->

    <div class="modal fade" id="archives-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">编辑个人信息</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="post">
                        <div class="form-group">
                            <label for="phone" class="col-sm-3 control-label">联系电话</label>
                            <div class="col-sm-8">
                                <input name="txt0" type="text" class="form-control" id="phone"
                                    <?php if (isset($archives['联系电话'])) echo "value=\"{$archives['联系电话']}\""; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="usedName" class="col-sm-3 control-label">曾用名</label>
                            <div class="col-sm-8">
                                <input name="txt1" type="text" class="form-control" id="usedName"
                                    <?php if (isset($archives['曾用名'])) echo "value=\"{$archives['曾用名']}\""; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hometown" class="col-sm-3 control-label">籍贯</label>
                            <div class="col-sm-8">
                                <select name="txt2" class="form-control" id="hometown" 
                                    <?php if (isset($archives['籍贯'])) echo "value=\"{$archives['籍贯']}\""; ?>>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">联系地址</label>
                            <div class="col-sm-8">
                                <input name="txt3" type="text" class="form-control" id="address"
                                    <?php if (isset($archives['联系地址'])) echo "value=\"{$archives['联系地址']}\"" ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact" class="col-sm-3 control-label">联系人</label>
                            <div class="col-sm-8">
                                <input name="txt4" type="text" class="form-control" id="contact"
                                    <?php if (isset($archives['联系人'])) echo "value=\"{$archives['联系人']}\"" ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zip-code" class="col-sm-3 control-label">邮政编码</label>
                            <div class="col-sm-8">
                                <input name="txt5" type="text" class="form-control" id="zip-code"
                                    <?php if (isset($archives['邮政编码'])) echo "value=\"{$archives['邮政编码']}\"" ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="political-landscape" class="col-sm-3 control-label">政治面貌</label>
                            <div class="col-sm-8">
                                <select name="txt6" class="form-control" id="political-landscape"
                                    <?php if (isset($archives['政治面貌'])) echo "value=\"{$archives['政治面貌']}\"" ?>>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell-phone" class="col-sm-3 control-label">手机号码</label>
                            <div class="col-sm-8">
                                <input name="txt7" type="text" class="form-control" id="cell-phone"
                                    <?php if (isset($archives['手机号码'])) echo "value=\"{$archives['手机号码']}\"" ?>>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn">
                                    <i class="glyphicon glyphicon-ok"></i> 提交
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#archives-edit').on('show.bs.modal', function () {
    $.getJSON('js/hometown.json', function(data){
        initSelect($('#hometown'), data);
    });
    $.getJSON('js/political-landscape.json', function(data){
        initSelect($('#political-landscape'), data);
    });
});

function initSelect($node, data) {
    var value = $node.attr('value'),
        select_key = '',
        similar = 1000;
    $.each(data, function(key, val) {
        var s = key.indexOf(value);
        if (s != -1 && s < similar) {
            similar = s;
            select_key = val;
        }
        $node.append('<option value="' + val + '">' + key + '</option>');
    });
    $node.find('option[value="' + select_key + '"]').prop('selected', true);
}
</script>
