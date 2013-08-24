<?php $this->beginContent('/layouts/main'); ?>
<div class="col-sm-2">
    <?php
    $this->widget('ext.widgets.submenu', array(
        'items' => array(
            array(
                'label' => '统计',
                'action' => array('stats'),
            ),
            array(
                'label' => '成绩表',
                'action' => array('effectiveScore'),
            ),
        ),
    ));
    ?>
</div>
<div class="col-sm-10">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
