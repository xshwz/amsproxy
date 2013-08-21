<?php $this->beginContent('/layouts/main'); ?>
<div class="col-sm-2">
    <?php
    $this->widget('ext.widgets.submenu', array(
        'items' => array(
            array(
                'label' => '原始成绩',
                'action' => array('originalScore'),
            ),
            array(
                'label' => '有效成绩',
                'action' => array('effectiveScore'),
            ),
            array(
                'label' => '统计',
                'action' => array('stats'),
            ),
        ),
    ));
    ?>
</div>
<div class="col-sm-10">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
