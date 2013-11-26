<% $this->pageTitle = '微信公众平台'; %>

<div class="alert alert-info">
    欢迎关注我们的微信公众号“<abbr title="<img src='img/wechat-qrcode.jpg' width='160' style='margin: 5px 0;' alt='微信二维码'>" class="wechat-tooltip">相思青果</abbr>”，通过向我们的微信公众号发送指令消息，即可查看成绩、课表；同时，任何有关“相思青果”的问题都可以向我们吐槽。
    <a href="<%= $this->createUrl('/site/wechat'); %>">&gt;&gt;了解详情</a>
</div>
<% if ($this->student->wechat_openid): %>
<div class="alert alert-success">
    你的微信已与“相思青果”绑定。 <a href="<%= $this->createUrl('/proxy/wechat/unbind'); %>">解除绑定</a>
</div>
<% endif; %>
