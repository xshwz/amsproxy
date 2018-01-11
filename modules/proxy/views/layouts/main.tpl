<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"> 
        <meta name="renderer" content="webkit">
        <meta name="keywords" content="惠州学院,教务系统,教务,惠大微报,手机" />
        <meta name="description" content="惠州学院,教务系统,教务,移动教务,免验证码登陆,保存课表图片,手机显示适配" />
        <title>
        <% if ($this->pageTitle) echo $this->pageTitle . ' - '; %>
        惠大微报 - 移动 - 教务系统 - 惠州学院
        </title>

        <base href="<%= $this->createAbsoluteUrl('/') . '/'; %>">

        <link rel="shortcut icon" href="favicon.ico">

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/common.css" rel="stylesheet">
        <link href="/css/proxy.css" rel="stylesheet">
        <% $this->renderStyle(); %>
    </head>
    <body>
        <div id="body">
            <div id="side">
                <div class="side-header">
                    <h1 style="color:white;">
                    惠大微报
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
                                    //array(
                                    //    'label' => '<span class="glyphicon glyphicon-list"></span> 今日课程',
                                    //    'url' => array('/proxy/course/today'),
                                    //),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-th"></span> 课程表',
                                        'url' => array('/proxy/course/tableImg'),
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
                                        'label' => '<span class="glyphicon glyphicon-stats"></span> 原始成绩',
                                        'url' => array('/proxy/score/stats'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-list-alt"></span> 有效成绩',
                                        'url' => array('/proxy/score/validScore'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-check"></span> 认定成绩',
                                        'url' => array('/proxy/score/affirmScore'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-th"></span> 绩点统计',
                                        'url' => array('/proxy/score/GPA'),
                                    ),
                                    // array(
                                    //     'label' => '<span class="glyphicon glyphicon-unchecked"></span> 原始成绩',
                                    //     'url' => array('/proxy/score/originalScore'),
                                    // ),
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
                                        'label' => '<span class="glyphicon glyphicon-refresh"></span> 更新数据',
                                        'url' => array('/proxy/setting/update'),
                                    ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-lock"></span> 修改密码',
                                        'url' => array('/proxy/setting/password'),
                                    ),
                                    //array(
                                    //    'label' => '<span class="glyphicon glyphicon-phone"></span> 微信',
                                    //    'url' => array('/proxy/wechat/index'),
                                    //),
                                ),
                            ),
                            array(
                                'label' => '帮助',
                                'items' => array(
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-comment"></span> 反馈',
                                        'url' => array('/proxy/home/feedback'),
                                    ),
                            //      array(
                            //            'label' => '<span class="glyphicon glyphicon-question-sign"></span> 常见问题',
                            //            'url' => array('/site/home/FAQ'),
                            //        ),
                                    array(
                                        'label' => '<span class="glyphicon glyphicon-info-sign"></span> 关于',
                                        'url' => array('/proxy/home/about'),
                                    ),
                                ),
                            ),
                        ),
                    )
                );
                %>
            </div>
            <div id="main">
                <nav id="top-nav">
                    <a class="navbar-toggle" id="side-toggle" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <h2 class="title"><%= $this->pageTitle %></h2>
                    <ul class="links">
                        <li>
                            <a 
                                title="刷新"
                                href="<%= $this->createUrl('/proxy/home/refreshThis?' . 
                                ((isset($this->field))? 'field='.$this->field.'&' : '') .
                                ((isset($this->fileField))? 'fileField='.$this->fileField.'&' : '').
                                ((isset($this->commonField))? 'commonField='.$this->commonField.'&' : '')
                                ) %>"><span class="glyphicon glyphicon-refresh"></span>
                            </a>
                        </li>
                        <% if ($this->isAdmin()): %>
                        <li>
                            <a
                                title="管理"
                                href="<%= $this->createUrl('/admin') %>">
                                <span class="glyphicon glyphicon-wrench"></span>
                            </a>
                        </li>
                        <% endif %>
                        <li>
                            <a
                                title="消息"
                                class="bubble"
                                id="message-label"
                                href="<%= $this->createUrl('/proxy/home/message') %>">
                                <span class="glyphicon glyphicon-envelope"></span>
                            </a>
                        </li>
                        <li>
                            <a
                                title="反馈"
                                href="<%= $this->createUrl('/proxy/home/feedback') %>">
                                <span class="glyphicon glyphicon-comment"></span>
                            </a>
                        </li>
                        <li>
                            <a
                                title="退出"
                                href="<%= $this->createUrl('/proxy/home/logout') %>">
                                <span class="glyphicon glyphicon-log-out"></span>
                            </a>
                        </li>
                    </ul>
                </nav>
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
                            Powered By 惠大微报
                        </em>
                    </p>
                </div>
            </div>
        </div>

        <script src="/js/libs/jquery.min.js"></script>
        <script src="/js/libs/bootstrap.min.js"></script>
        <script src="/js/libs/jquery.form.js"></script>
        <script src="/js/libs/jquery.easing.min.js"></script>
        <script src="/js/libs/highcharts.js"></script>
        <script src="/js/proxy.js"></script>

        <% $this->renderScript(); %>
        <script>
        (function(){
            var unread = <%= CJSON::encode($this->unread); %>;

            if (unread.length) {
                $('#message-label').append(
                    '<span class="badge">' +
                        unread.length +
                    '</span>'
                );
            }
        })();
        </script>

        <% $this->renderPartial('/common/stats'); %>
    </body>
</html>
