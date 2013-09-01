<div class="courseTable">
    <?php
    if (isset($refresh)):
    ?>
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>刷新课表成功!</strong>
    </div>
    <?php
    endif;

    $this->widget(
        'ext.widgets.courseTable',
        array('courses' => $courses));

    echo CHtml::link(
        '<span class="glyphicon glyphicon-refresh"></span>刷新',
        array('course/refresh'),
        array('class' => 'btn')
    );
    ?>
</div>
