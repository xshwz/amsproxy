<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="相思青果,相思湖网站,广西民族大学,教务系统">
        <meta name="description" content="“相思青果”是由相思湖网站开发的，广西民族大学教务系统代理。在这里，你可以不受校园网限制，方便的使用教务系统。">

        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"> 

        <title>
        <% if ($this->pageTitle) echo $this->pageTitle . ' - '; %>
        相思青果
        </title>

        <base href="<%= $this->createAbsoluteUrl('/') . '/'; %>">

        <link rel="shortcut icon" href="favicon.ico">

        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/common.css" rel="stylesheet">
        <link href="css/site.css" rel="stylesheet">

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

        <%= $content; %>

        <script src="js/libs/jquery.min.js"></script>
        <script src="js/libs/bootstrap.min.js"></script>
        <script src="js/libs/jquery.form.min.js"></script>

        <% $this->renderScript(); %>
        <% $this->renderPartial('/common/stats'); %>
    </body>
</html>
