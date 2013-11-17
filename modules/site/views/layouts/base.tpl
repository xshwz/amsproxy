<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="相思青果,相思湖网站,广西民族大学,教务系统">
        <meta name="description" content="“相思青果”是由相思湖网站开发的，广西民族大学教务系统代理。在这里，你可以不受校园网限制，方便的使用教务系统。">

        <title>
        <% if ($this->pageTitle) echo $this->pageTitle . ' - '; %>
        相思青果
        </title>

        <link rel="shortcut icon" href="favicon.ico">

        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/common.css" rel="stylesheet">
        <link href="css/site.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <link href="css/ie.css" rel="stylesheet">
        <![endif]-->

        <% $this->renderStyle(); %>
    </head>
    <body>
        <%= $content; %>

        <script src="js/libs/jquery.min.js"></script>
        <script src="js/libs/bootstrap.min.js"></script>
        <script src="js/libs/jquery.form.min.js"></script>

        <% $this->renderScript(); %>
        <% $this->renderPartial('/common/stats'); %>
    </body>
</html>
