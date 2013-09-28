<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>相思青果</title>
        <link rel="shortcut icon" href="favicon.ico">
        <link href="css/bootstrap.css" rel="stylesheet">
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
                    <a href="<?php echo Yii::app()->createUrl('site/index')?>" class="navbar-brand">
                        <img width="17" height="17" src="img/xsh-logo.png" alt="logo">
                        相思青果
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <?php
                    if ($this->isLogged()):
                        $this->widget(
                            'ext.widgets.menu',
                            array(
                                'items' => array(
                                    array(
                                        'label' => '主页',
                                        'url' => 'home/index',
                                    ),
                                    array(
                                        'label' => '学籍',
                                        'url' => 'info/index',
                                    ),
                                    array(
                                        'label' => '课表',
                                        'url' => 'course/index',
                                    ),
                                    array(
                                        'label' => '成绩',
                                        'url' => 'score/stats',
                                    ),
                                    array(
                                        'label' => '等级考试',
                                        'url' => 'rankExam/index',
                                    ),
                                    array(
                                        'label' => '教学计划',
                                        'url' => 'theorySubject/index',
                                    ),
                                ),
                            )
                        );
                    ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li
                            <?php
                            if (Yii::app()->controller->id == 'message')
                                echo 'class="active"';
                            ?>>
                            <a class="bubble" href="<?php echo Yii::app()->createUrl('message/index'); ?>">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <?php if (count($this->unReadMsg) > 0): ?>
                                <span class="badge">
                                    <?php echo count($this->unReadMsg); ?>
                                </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li>
                            <?php
                            echo CHtml::link(
                                '退出', array('home/logout'));
                            ?>
                        </li>
                    </ul>
                    <?php else: ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('site/login')?>">
                                登录
                            </a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="container body">
            <?php echo $content; ?>
        </div>

        <div class="footer">
            <ul class="list-inline">
                <li>
                    <a href="<?php echo Yii::app()->createUrl('site/about')?>">
                        <span class="glyphicon glyphicon-exclamation-sign"></span> 关于
                    </a>
                </li>
                <?php if ($this->isLogged()): ?>
                <li>
                    <a data-toggle="modal" href="#feedbackModal">
                        <span class="glyphicon glyphicon-send"></span> 反馈
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <div class="powered">
                <em>powered by 相思湖网站</em>
            </div>
        </div>

        <?php if ($this->isLogged()): ?>
        <div class="modal fade" id="feedbackModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">反馈</h4>
                    </div>
                    <div class="modal-body">
                        <form
                            id="ajaxFeedbackForm"
                            action="<?php echo Yii::app()->createUrl('home/feedback')?>"
                            method="post">
                            <div class="form-group">
                                <textarea
                                    placeholder="有什么意见或问题想要对我们说？"
                                    name="message"
                                    rows="4"
                                    id="feedback-msg"
                                    class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn">
                                <i class="glyphicon glyphicon-ok"></i> 提交
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.form.min.js"></script>
        <script src="js/amsProxy.js"></script>

        <div id="cnzz_stat_icon_1000039522"></div>
        <script src="http://s22.cnzz.com/z_stat.php?id=1000039522"></script>
    </body>
</html>
