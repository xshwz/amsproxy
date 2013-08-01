<?php include 'view/header.html'; ?>
<div class="container">
    <div class="page">
        <div class="page-header">
            <h2><i class="icon-question-sign"></i> 这是什么</h2>
        </div>
        <p>简而言之，输入学号和密码，提交后即可查到成绩。</p>
        <div class="page-header">
            <h2><i class="icon-cogs"></i> 技术实现</h2>
        </div>
        <p>学校的教务系统只能通过内网访问，外网要想访问内网的数据，必须通过中间代理。</p>
        <p>但是与一般的简单代理不同，这个代理只提供统一特定的接口，比如成绩查询，所以对内网是安全的。</p>
        <div class="page-header">
            <h2><i class="icon-shield"></i> 隐私</h2>
        </div>
        <p>你可能会有所顾虑，把学号和密码交给一个第三方系统会不会存在安全隐患。</p>
        <p>所以你可能想要清楚的知道这个代理系统到底做了什么，为此我们公开了源代码（详见<a href="#opensource">#开源</a>）。</p>
        <p>值得一提的是，为了提高与教务系统通信的效率，我们会做一些缓存，这以意味着你的学号和密码会被保存下来。但是不用担心，被保存的密码是经过加密的。</p>
        <div class="page-header" id="opensource">
            <h2><i class="icon-github"></i> 开源</h2>
        </div>
        <p>为什么要将源代码藏起来不让人看见呢？</p>
        <p>我们的源代码公开在<a href="" target="_blank">github</a>，你可以在上面对我们的项目进行讨论、查看源代码、贡献。</p>
        <div class="page-header">
            <h2><i class="icon-group"></i> 开发者</h2>
        </div>
        <p>有什么问题可以联系我们。</p>
        <ul>
            <li>丘翔，10网络工程，<a href="mailto:qiuxiang55aa@gmail.com">qiuxiang55aa@gmail.com</a></li>
            <li>徐伟榕，11软件工程，<a href="mailto:weirongxuraidou@gmail.com">weirongxuraidou@gmail.com</a></li>
        </ul>
    </div>
</div>
<?php include 'view/footer.html'; ?>
