<% $this->pageTitle = '微信公众平台'; %>

<div class="wechat-header">
    <div><img src="img/wechat-qrcode.jpg" width="200" alt="微信二维码"></div>
    <div>
        <h3>相思青果</h3>
    </div>
</div>

<div class="page-header">
    <h2>介绍</h2>
</div>
<p>如果你是一个微信用户，可以关注我们的微信公众号“相思青果”，简单绑定后，即可通过微信向我们的公众号发送指令消息查询课程、成绩等信息。这些功能基于微信公众平台开发模式实现，保证消息的自动及时回复。</p>
<p>同时，我们的公众号也作为与使用者沟通交流的平台，欢迎同学们的交流反馈。</p>

<div class="page-header">
    <h2>使用截图</h2>
</div>
<div class="screenshot">
    <ul>
        <%
        for ($c = 1; $c <= 8; $c++) {
            echo <<<EOT
            <li>
                <a href="#lightbox" class="lightbox" data-toggle="modal" class="thumbnail">
                    <img width="160" src="img/wechat_screenshot/{$c}.png" alt="微信公众平台使用截图 {$c}">
                </a>
            </li>
EOT;
        }
        %>
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
    <li>查找公众号“相思青果”或<abbr title="<img src='img/wechat-qrcode.jpg' width='160' style='margin: 5px 0;' alt='微信二维码'>" class="wechat-qrcode">扫描二维码</abbr>；</li>
    <li>关注后会收到一条消息，点击链接，成功登录后即可完成绑定。</li>
</ol>

<div class="page-header">
    <h2>支持的指令</h2>
</div>
<ul>
    <li><p><code>帮助</code>：获取帮助</p></li>
    <li><p><code>/学籍</code>：返回个人学籍档案</p></li>
    <li><p><code>/课程</code>：默认返回当天课程，可带参数，比如“/课程3”返回星期三的课程</p></li>
    <li><p><code>/成绩</code>：默认返回最近一个学期的成绩，可带参数，比如“/成绩1”返回第一个学期的成绩</p></li>
    <li><p><code>/等级考试</code>：返回等级考试成绩</p></li>
</ul>
<p>PS. 发送的指令不一定都能成功返回，可以多试几次。</p>
