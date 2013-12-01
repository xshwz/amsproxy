<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
        <% if ($this->pageTitle) echo $this->pageTitle . ' - '; %>
        相思青果
        </title>

        <link rel="shortcut icon" href="favicon.ico">

        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/common.css" rel="stylesheet">
        <link href="css/proxy.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <link href="css/ie.css" rel="stylesheet">
        <![endif]-->

        <% $this->renderStyle(); %>

        <!--[if lt IE 9]>
        <script src="js/libs/html5shiv.js"></script>
        <script src="js/libs/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="body">
            <div id="side">
                <div class="side-header">
                    <h1>
                        <a href="<%= $this->createUrl('/site'); %>">
                            <img src="img/logo.png" width="32" alt="相思湖网站 Logo" title="相思青果">
                        </a>
                    </h1>
                </div>
                <%
                $this->widget(
                    'zii.widgets.CMenu',
                    array(
                        'encodeLabel' => false,
                        'items' => array(
                            array(
                                'label' => '个人',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-home"></span> 主页',
                                        'url' => array('/proxy/home/index'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-user"></span> 学籍档案',
                                        'url' => array('/proxy/personal/archives'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '课程',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-list"></span> 今日课程',
                                        'url' => array('/proxy/course/today'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-th"></span> 课程表',
                                        'url' => array('/proxy/course/table'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-list-alt"></span> 理论课程',
                                        'url' => array('/proxy/course/theorySubject'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '成绩',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-stats"></span> 统计',
                                        'url' => array('/proxy/score/stats'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-check"></span> 有效成绩',
                                        'url' => array('/proxy/score/effectiveScore'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-unchecked"></span> 原始成绩',
                                        'url' => array('/proxy/score/originalScore'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '等级考试',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-hand-right"></span> 报名',
                                        'url' => array('/proxy/rankExam/form'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-list-alt"></span> 成绩',
                                        'url' => array('/proxy/rankExam/score'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '设置',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-refresh"></span> 清除缓存',
                                        'url' => array('/proxy/setting/clear'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-lock"></span> 修改密码',
                                        'url' => array('/proxy/setting/password'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-phone"></span> 微信',
                                        'url' => array('/proxy/wechat/index'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '帮助',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-comment"></span> 反馈',
                                        'url' => array('/proxy/home/feedback'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-question-sign"></span> 常见问题',
                                        'url' => array('/site/home/FAQ'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-info-sign"></span> 关于',
                                        'url' => array('/site/home/about'),
                                    ),
                                ),
                            ),
                            array(
                                'label' => '',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-envelope"></span> 消息',
                                        'url' => array('/proxy/home/message'),
                                        'linkOptions' => array('id' => 'message-label'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-log-out"></span> 退出',
                                        'url' => array('/proxy/home/logout'),
                                    ),
                                ),
                            ),
                        ),
                    )
                );
                %>
            </div>
            <a class="navbar-toggle" id="side-toggle" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div id="main">
                <div class="container">
                    <%
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

                    if (isset($this->alert))
                        echo <<<EOT
                        <div class="alert alert-{$this->alert['type']}">
                            <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                            {$this->alert['message']}
                        </div>
EOT;

                    echo $content;
                    %>
                </div>

                <div id="footer">
                    <p class="powered">
                        <em>
                            Powered By
                            <a href="http://xsh.gxun.edu.cn/">
                                <img src="img/logo.png" width="16" alt="xsh logo">相思湖网站
                            </a>
                        </em>
                    </p>
                </div>
            </div>
        </div>

        <script src="js/libs/jquery.min.js"></script>
        <script src="js/libs/bootstrap.min.js"></script>
        <script src="js/libs/jquery.form.min.js"></script>
        <script src="js/libs/highcharts.js"></script>
        <script src="js/proxy.js"></script>

        <% $this->renderScript(); %>
        <script>
        (function(){
            var unread = <%= CJSON::encode($this->unread); %>;

            if (unread.length) {
                $('#message-label').append(
                    '<span class="badge pull-right">' +
                        unread.length +
                    '</span>'
                );
            }
        })();
        </script>

        <% $this->renderPartial('/common/stats'); %>
    </body>
</html>
