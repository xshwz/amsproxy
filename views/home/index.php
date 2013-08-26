<!--
<div class="page-header">
    <h2>今日课程</h2>
</div>
-->
<?php
$now = date_create('now');
$start_date = date_create($this->setting->start_date);

if ($now > $start_date):
    $this->widget(
        'ext.widgets.courseLine',
        array('courses' => $courses));
else:
?>
<div class="jumbotron">
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
</div>
<?php endif; ?>
