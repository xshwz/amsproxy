<?php $this->beginContent('/layouts/site-base'); ?>
<div id="wrap">
    <div id="site-header">
        <div class="container">
            <h1>
                <a href="<?php echo Yii::app()->createUrl('site/index'); ?>">
                    <img src="img/xsh-logo.png" width="64" alt="相思湖网站 logo">
                    相思<span>青果</span>
                </a>
            </h1>
        </div>
    </div>
    <div class="container">
        <?php echo $content; ?>
    </div>
    <div id="site-footer">
        <p class="powered">
            <em>
                Powered By
                <a href="http://xsh.gxun.edu.cn/">相思湖网站</a>
            </em>
        </p>
    </div>
</div>
<?php $this->endContent(); ?>
