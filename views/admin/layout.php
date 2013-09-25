<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>相思青果后台管理</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/datepicker.css" rel="stylesheet">
        <link href="css/amsProxy.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a
                        class="navbar-toggle"
                        href="javascript:"
                        data-toggle="collapse"
                        data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a href="<?php echo Yii::app()->createUrl('admin/index'); ?>" class="navbar-brand">
                        <img width="17" height="17" src="img/logo.png" alt="logo">
                        相思青果后台管理
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <?php
                    if (defined('IS_ADMIN')):
                        $this->widget(
                            'zii.widgets.CMenu',
                            array(
                                'items' => array(
                                    array(
                                        'label' => '学生',
                                        'url' => array('admin/student'),
                                    ),
                                    array(
                                        'label' => '消息',
                                        'url' => array('admin/message'),
                                    ),
                                    array(
                                        'label' => '统计',
                                        'url' => array('admin/stats'),
                                    ),
                                    array(
                                        'label' => '设置',
                                        'url' => array('admin/setting'),
                                    ),
                                ),
                                'htmlOptions' => array(
                                    'class' => 'nav navbar-nav',
                                    'id' => 'admin-nav',
                                ),
                            )
                        );
                    ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li
                            <?php
                            if (Yii::app()->controller->action->id == 'feedback')
                                echo 'class="active"';
                            ?>>
                            <a class="bubble" href="<?php echo Yii::app()->createUrl('admin/feedback'); ?>">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <?php if (count($this->unReadMsg) > 0): ?>
                                <span class="badge admin">
                                    <?php echo count($this->unReadMsg); ?>
                                </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li>
                            <?php
                            echo CHtml::link(
                                '退出', array('admin/logout'));
                            ?>
                        </li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="container body">
            <?php echo $content; ?>
        </div>
        
        <div class="footer"></div>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.form.min.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/amsProxy.js"></script>
    </body>
</html>
