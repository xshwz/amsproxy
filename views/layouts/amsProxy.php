<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
        <?php
        if (isset($this->pageTitle) && $this->pageTitle)
            echo $this->pageTitle . ' - ';
        ?>
        相思青果
        </title>
        <link rel="shortcut icon" href="favicon.ico">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/amsProxy.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <link href="css/ie.css" rel="stylesheet">
        <![endif]-->
    </head>
    <body class="amsProxy">
        <div id="body">
            <div id="side">
                <?php
                $this->widget(
                    'zii.widgets.CMenu',
                    array(
                        'encodeLabel' => false,
                        'items' => array(
                            array(
                                'label' => '个人',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-user"></span> 学籍档案',
                                        'url' => array('personal/archives'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '课程',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-list"></span> 今日课程',
                                        'url' => array('course/today'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-th"></span> 课程表',
                                        'url' => array('course/table'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-list-alt"></span> 理论课程',
                                        'url' => array('course/theorySubject'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '成绩',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-stats"></span> 统计',
                                        'url' => array('score/stats'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-check"></span> 有效成绩',
                                        'url' => array('score/effectiveScore'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-unchecked"></span> 原始成绩',
                                        'url' => array('score/originalScore'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '等级考试',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-hand-right"></span> 报名',
                                        'url' => array('rankExam/form'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-list-alt"></span> 成绩',
                                        'url' => array('rankExam/score'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '设置',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-refresh"></span> 清除缓存',
                                        'url' => array('setting/clear'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-lock"></span> 修改密码',
                                        'url' => array('setting/password'),
                                    ),
                                    /*
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-phone"></span> 微信',
                                        'url' => array('setting/wechat'),
                                    ),
                                    */
                                ),
                            ),
                            array(
                                'label' => '帮助',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-comment"></span> 反馈',
                                        'url' => array('help/feedback'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-question-sign"></span> FAQ',
                                        'url' => array('help/FAQ'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-envelope"></span> 消息',
                                        'url' => array('home/message'),
                                        'linkOptions' => array('id' => 'message-label'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-log-out"></span> 退出',
                                        'url' => array('home/logout'),
                                    ),
                                ),
                            ),
                        ),
                    )
                );
                ?>
            </div>
            <button class="navbar-toggle" id="side-toggle" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div id="main">
                <div class="container">
                    <?php
                    if (isset($this->breadcrumbs)) {
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                            'tagName' => 'ol',
                            'separator' => '',
                            'activeLinkTemplate' => '
                                <li><a href="{url}">{label}</a></li>',
                            'inactiveLinkTemplate' => '
                                <li class="active">{label}</li>',
                            'htmlOptions' => array('class' => 'breadcrumb'),
                            'homeLink' => false,
                            'links' => $this->breadcrumbs,
                        ));
                    }

                    echo $content;
                    ?>
                </div>

                <div class="footer">
                    <p class="powered">
                        <em>
                            Powered By
                            <a href="http://xsh.gxun.edu.cn/">
                                <img src="img/xsh-logo.png" width="16" alt="xsh logo">相思湖网站
                            </a>
                        </em>
                    </p>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.form.min.js"></script>
        <script src="js/highcharts.js"></script>
        <script src="js/amsProxy.js"></script>
        <script>
        (function(){
            var unread = <?php echo CJSON::encode($this->unread); ?>;

            if (unread.length) {
                $('#message-label').append(
                    '<span class="badge pull-right">' +
                        unread.length +
                    '</span>'
                );
            }
        })();
        </script>

        <div id="cnzz_stat_icon_1000039522"></div>
        <script src="http://s22.cnzz.com/z_stat.php?id=1000039522"></script>
        <script src="http://tajs.qq.com/stats?sId=28159787"></script>
    </body>
</html>
