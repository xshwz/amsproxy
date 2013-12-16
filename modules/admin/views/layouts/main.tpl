<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
        <% if ($this->pageTitle) echo $this->pageTitle . ' - '; %>
        相思青果后台管理
        </title>

        <base href="<%= $this->createAbsoluteUrl('/') . '/'; %>">

        <link rel="shortcut icon" href="favicon.ico">

        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/common.css" rel="stylesheet">
        <link href="css/admin.css" rel="stylesheet">

        <% $this->renderStyle(); %>

        <!--[if lt IE 9]>
        <script src="js/libs/html5shiv.js"></script>
        <script src="js/libs/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="admin">
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
                    <a href="<%= Yii::app()->createUrl('/admin'); %>" class="navbar-brand">
                        <img width="17" height="17" src="img/logo.png" alt="logo">
                        相思青果后台管理
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <%
                    if ($this->isLogged()):
                        $this->widget(
                            'zii.widgets.CMenu',
                            array(
                                'encodeLabel' => false,
                                'items' => array(
                                    array(
                                        'label' => '
                                            <span class="glyphicon glyphicon-user"></span>
                                            <span class="visible-xs">学生</span>',
                                        'url' => array('/admin/student/index'),
                                    ),
                                    array(
                                        'label' => '
                                            <span class="glyphicon glyphicon-stats"></span>
                                            <span class="visible-xs">统计</span>',
                                        'url' => array('/admin/stats/index'),
                                    ),
                                    array(
                                        'label' => '
                                            <span class="glyphicon glyphicon-cog"></span>
                                            <span class="visible-xs">设置</span>',
                                        'url' => array('/admin/setting/index'),
                                    ),
                                ),
                                'htmlOptions' => array(
                                    'class' => 'nav navbar-nav',
                                    'id' => 'admin-nav',
                                ),
                            )
                        );
                    %>
                    <ul class="nav navbar-nav navbar-right">
                        <li <% if (Yii::app()->controller->id == 'feedback') echo 'class="active"' %> >
                            <a class="bubble" href="<%= Yii::app()->createUrl('/admin/feedback'); %>" >
                                <span class="glyphicon glyphicon-envelope"></span>
                                <span class="visible-xs">反馈</span>

                                <% if (count($this->unread) > 0): %>
                                <span class="badge">
                                    <%= count($this->unread); %>
                                </span>
                                <% endif; %>
                            </a>
                        </li>
                        <li>
                            <%=
                            CHtml::link('
                                <span class="glyphicon glyphicon-home"></span>
                                <span class="visible-xs">首页</span>',
                                array('/site/home/index'));
                            %>
                        </li>
                        <li>
                            <%=
                            CHtml::link('
                                <span class="glyphicon glyphicon-log-out"></span>
                                <span class="visible-xs">退出</span>',
                                array('/proxy/home/logout'));
                            %>
                        </li>
                    </ul>
                    <% endif; %>
                </div>
            </div>
        </div>

        <div class="container body">
            <%= $content; %>
        </div>
        
        <script src="js/libs/jquery.min.js"></script>
        <script src="js/libs/bootstrap.min.js"></script>
        <script src="js/libs/jquery.form.min.js"></script>
        <script src="js/libs/highcharts.js"></script>
        <script src="js/admin.js"></script>
        <% $this->renderScript(); %>
    </body>
</html>
