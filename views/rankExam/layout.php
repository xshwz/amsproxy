<?php $this->beginContent('/layouts/main'); ?>
<div class="col-sm-2">
    <?php
    $this->widget('ext.widgets.submenu', array(
        'items' => array(
            array(
                'label' => '报名情况',
                'action' => 'index',
            ),
            array(
                'label' => '考试成绩',
                'action' => 'score',
            ),
            array(
                'label' => '更新数据',
                'action' => 'refresh',
            )
        ),
    ));
    ?>
</div>
<div class="col-sm-10">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
