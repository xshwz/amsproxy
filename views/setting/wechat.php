<div class="wechat-header">
    <div><img src="img/wechat_qrcode.jpg" width="200" alt="微信二维码"></div>
    <div>
        <h3>相思湖网站技术部</h3>
        <em>微信号：xshwebjsb</em>
    </div>
</div>

<div class="page-header">
    <h2>介绍</h2>
</div>
<p>如果你是一个微信用户，可以通过关注“相思湖网站技术部”，向我们的公众微信发送指令即可查询课程和成绩。相信这能给你带来一些便利，同时这也是一件非常有趣的事。</p>

<div class="page-header">
    <h2>使用截图</h2>
</div>
<div class="screenshot">
    <ul>
        <?php
        for ($c = 1; $c <= 8; $c++)
            echo <<<EOT
            <li>
                <a href="#lightbox" class="lightbox" data-toggle="modal" class="thumbnail">
                    <img width="160" src="img/wechat_screenshot/{$c}.png" alt="微信公众平台使用截图 {$c}">
                </a>
            </li>
EOT;
        ?>
    </ul>
</div>
<div class="modal fade lightbox" id="lightbox">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="lightbox-wrap">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </button>
                <img class="lightbox">
            </div>
        </div>
    </div>
</div>

<div class="page-header">
    <h2>如何绑定</h2>
</div>
<ol>
    <li>查找公众号<abbr title="<img src='img/wechat_qrcode.jpg' width='160' style='margin: 5px 0;' alt='微信二维码'>" class="wechat-qrcode">相思湖网站技术部</abbr>并关注；</li>
    <li>关注成功后会收到一条 URL，点击访问；</li>
    <li>如果你的浏览器已经登录过相思青果，此时已经绑定成功，否则需要登录，登录成功后即可绑定成功；</li>
</ol>

<div class="page-header">
    <h2>支持的指令</h2>
</div>
<ul>
    <li><p><code>学籍</code>：个人学籍档案</p></li>
    <li><p><code>课程 [n]</code>：默认返回当天课程，后加空格和数字表示第n星期的课程</p></li>
    <li><p><code>成绩 [n]</code>：默认返回最近一个学期的成绩，后加空格和数字表示第n个学期的成绩</p></li>
    <li><p><code>等级考试</code>：等级考试成绩</p></li>
</ul>

<?php if (isset($this->student->wechat)): ?>
<br>
<div class="alert alert-success">
你的帐号已与相思青果微信公众平台绑定，如果需要，你可以<a href="">解除绑定</a>。
</div>
<?php endif; ?>
