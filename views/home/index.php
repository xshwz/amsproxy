<div class="jumbotron">
    <?php
    $now = date_create('now');
    $start_date = date_create($this->setting->start_date);
    if ($now > $start_date):
    ?>
    <?php else: ?>
    <h1>
        <p>
            你的暑假余额仅剩
            <strong class="text-danger"><?php echo date_diff($now, $start_date)->days; ?></strong>
            天。
        </p>
        <p>
            <img src="img/rage_comics/fuck-that-bitch-yao-ming.png" height="128" alt="暴走漫画 - 姚明">
        </p>
    </h1>
    <?php endif; ?>
</div>
