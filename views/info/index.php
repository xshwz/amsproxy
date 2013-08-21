<div class="main form-horizontal">
    <br>
    <?php foreach ($_SESSION['student']['info'] as $key => $value): ?>
    <div class="form-group">
        <label class="col-sm-4 control-label"><?php echo $key; ?></label>
        <div class="col-sm-8">
            <p class="form-control-static"><?php echo $value; ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>
