<div class="jumbotron">
    <h1>Welcome!</h1>
    <?php if (defined('IS_LOGGED')):  ?>
    <p>登录成功，点击上面的菜单可以查看，学藉，课表，成绩等信息。</p>
    <?php else: ?>
    <p>在这里，你可以查看课表和成绩</p>
    <a
        href="<?php echo Yii::app()->createUrl('site/login')?>"
        class="btn btn-lg">登录</a>
    <?php endif; ?>
</div>
