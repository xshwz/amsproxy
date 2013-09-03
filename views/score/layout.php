<?php $this->beginContent('/layouts/main'); ?>
<div class="col-sm-2">
    <?php
    $this->widget('ext.widgets.submenu', array(
        'items' => array(
            array(
                'label' => '统计',
                'action' => 'stats',
            ),
            array(
                'label' => '有效成绩',
                'action' => 'effectiveScore',
            ),
            array(
                'label' => '原始成绩',
                'action' => 'originalScore',
            ),
            array(
                'label' => '等级考试成绩',
                'action' => 'rankScore',
            ),
            array(
                'label' => '更新数据',
                'action' => 'refreshScore',
            )
        ),
    ));
    ?>
</div>
<div class="col-sm-10">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
