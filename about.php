<?php include 'view/header.html'; ?>
<div class="container">
    <div class="page">
        <div class="page-header">
            <h2><i class="icon-question-sign"></i> 这是什么</h2>
        </div>
        <p>这是一个面向校外的学生成绩查询代理，输入学号和密码，提交后即可查到成绩。</p>
        <p>该系统由两个<a href="http://xsh.gxun.edu.cn/" target="_blank">相思湖网站</a>网络部的成员开发完成，目的是提供一个校外查询成绩的途径。</p>
        <div class="page-header">
            <h2><i class="icon-cogs"></i> 技术实现</h2>
        </div>
        <p>学校的教务系统只能通过内网访问，外网要想访问内网的数据，必须通过中间代理。<a href="http://xsh.gxun.edu.cn/" target="_blank">相思湖网站</a>服务器充当这一角色。</p>
        <p>但是与一般的简单代理不同，这个代理只提供统一特定的接口，比如成绩查询，所以对内网是安全的。</p>
        <p>一开始，你提供的学号和密码会被提交到运行在<a href="http://xsh.gxun.edu.cn/" target="_blank">相思湖网站</a>的代理系统，代理系统收到成绩查询请求后开始尝试模拟登录教务系统，登录成功后即获取成绩。获取到的成绩是html，代理系统会将html解析成统一的格式，然后重新生成html，并加上我们的样式，最终以一种比较友好的方式呈现出来。</p>
        <p>具体实现使用的是<a href="http://php.net/" target="_blank">php</a>，利用php的HttpRequest扩展发送http请求获取教务系统数据。（PS. 最初使用的是<a href="http://www.python.org/" target="_blank">python</a>，后面考虑到部署问题而换成了php）</p>
        <div class="page-header">
            <h2><i class="icon-shield"></i> 安全性</h2>
        </div>
        <p>你可能会有所顾虑，把学号和密码交给一个第三方系统会不会存在安全隐患。所以你可能想要清楚的知道这个代理系统到底做了什么，为此我们公开了源代码（详见<a href="#opensource">#开源</a>）。</p>
        <div class="page-header" id="opensource">
            <h2><i class="icon-github"></i> 开源</h2>
        </div>
        <p>我们的源代码公开在<a href="https://github.com/QiuXiang/AmsProxy" target="_blank">github</a>，你可以在上面查看源代码、与我们进行讨论、贡献你的想法或源代码。</p>
        <div class="page-header">
            <h2><i class="icon-legal"></i> 开发者</h2>
        </div>
        <p>目前，在开发和维护的人员有：</p>
        <ul>
            <li>丘翔，10网络工程，邮箱：<a href="mailto:qiuxiang55aa@gmail.com">qiuxiang55aa@gmail.com</a></li>
            <li>徐伟榕，11软件工程，邮箱：<a href="mailto:weirongxuraidou@gmail.com">weirongxuraidou@gmail.com</a></li>
        </ul>
        <p>有什么问题可以联系我们。</p>
    </div>
</div>
<?php include 'view/footer.html'; ?>
