<form method="post" class="row">
    <div class="form-group col-sm-offset-3 col-sm-6">
        <label class="radio-inline">
            <input
                type="radio"
                name="operateType"
                <?php
                if (!isset($_POST['operateType']) ||
                    $_POST['operateType'] == 'query')
                    echo 'checked';
                ?>
                value="query"> 查询
        </label>
        <label class="radio-inline">
            <input
                type="radio"
                name="operateType"
                <?php
                if (isset($_POST['operateType']) &&
                    $_POST['operateType'] == 'execute')
                    echo 'checked';
                ?>
                value="execute"> 执行
        </label>
    </div>
    <div class="form-group col-sm-offset-3 col-sm-6">
        <textarea name="sql" rows="4" class="form-control"><?php if (isset($_POST['sql'])) echo $_POST['sql']; ?></textarea>
    </div>
    <div class="form-group col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-block">
            <span class="glyphicon glyphicon-play"></span>
        </button>
    </div>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['operateType']) {
        case 'query':
            $this->widget(
                'ext.widgets.queryTable',
                array('sql' => $_POST['sql']));
            break;

        case 'execute':
            $results = Yii::app()->db->createCommand(
                $_POST['sql'])->execute();
            echo <<<EOT
            <div class="executeResult col-sm-offset-3 col-sm-6">
                <div class="alert alert-success">
                    执行成功，{$results} 行受影响。
                </div>
            </div>
EOT;
            
            break;
    }
}
