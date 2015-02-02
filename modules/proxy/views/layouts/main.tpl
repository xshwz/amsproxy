<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"> 
        <meta name="renderer" content="webkit">

        <title>
        <% if ($this->pageTitle) echo $this->pageTitle . ' - '; %>
        相思青果
        </title>

        <base href="<%= $this->createAbsoluteUrl('/') . '/'; %>">

        <link rel="shortcut icon" href="favicon.ico">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/common.css" rel="stylesheet">
        <link href="css/proxy.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <link href="css/ie.css" rel="stylesheet">
        <![endif]-->

        <% $this->renderStyle(); %>

        <!--[if lt IE 9]>
        <script src="js/libs/html5shiv.min.js"></script>
        <script src="js/libs/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!--[if lt IE 8]>
        <div class="alert alert-warning">
            <h2>噢！你的IE浏览器版本太低了！</h2>
            <p>相思青果不兼容低版本IE浏览器，为了正常使用相思青果，建议：</p>
            <ul>
                <li>请把你的IE浏览器升级到最新版本</li>
                <li>如果你的IE浏览器已经是最新版本，请<a href="http://windows.microsoft.com/zh-cn/internet-explorer/use-compatibility-view">关闭兼容性试图</a></li>
                <li>如果你使用的是双核浏览器，比如360安全浏览器，请<a href="http://se.360.cn/v6/help/help5.html">切换至极速模式</a></li>
            </ul>
            <p>为什么不能兼容？</p>
            <p>需要同学们知道的是，相思青果最初是我（相思湖网站网络部某某）为了方便大家可以在校外使用教务系统而开发的，从最初到现在，所有的开发维护、服务器配置，几乎只有我一个人在做（吐槽一下，徐伟榕太懒了）。尽管从技术上可以做到更好的兼容，但是请原谅我已经没有再多的精力。</p>
        </div>
        <![endif]-->
        <div id="body">
            <div id="side">
                <div class="side-header">
                    <h1>
                        <a href="<%= $this->createUrl('/site/home/index'); %>">
                            <img src="img/logo-white.png" width="32" alt="相思湖网站 Logo" title="相思青果">
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
                                        'label' => '<span class="glyphicon glyphicon-check"></span> 认定成绩',
                                        'url' => array('/proxy/score/affirmScore'),
                                    ),
                                    // array(
                                    //     'label' => '<span class="glyphicon glyphicon-check"></span> 有效成绩',
                                    //     'url' => array('/proxy/score/effectiveScore'),
                                    // ),
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
        <script src="js/libs/jquery.form.js"></script>
        <script src="js/libs/jquery.easing.min.js"></script>
        <script src="js/libs/highcharts.js"></script>
        <script src="js/proxy.js"></script>

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
