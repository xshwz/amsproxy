<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="相思青果,相思湖网站,广西民族大学,教务系统">
        <meta name="description" content="“相思青果”是由相思湖网站开发的，广西民族大学教务系统代理。">
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
    <body class="site">
        <?php echo $content; ?>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.form.min.js"></script>
        <script src="js/amsProxy.js"></script>

        <?php include '../views/common/stats.php'; ?>
    </body>
</html>
