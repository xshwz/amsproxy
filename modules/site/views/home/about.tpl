<% $this->pageTitle = '关于' %>

<div class="article">
    <div class="page-header">
        <h3><span class="glyphicon glyphicon-screenshot"></span> 意图</h3>
    </div>
    <p>你有没有吐槽过学校的教务系统不能从校外访问，并且难以使用？这就对了，这也正是我们的意图所在：让教务系统更易用。</p>
    <ul>
        <li>
            <p>利用相思湖网站服务器做数据中转，可以实现校外成绩查询；</p>
        </li>
        <li>
            <p>使用缓存机制，和更直接的 <abbr title="超文本传输协议">HTTP</abbr> 操作，让你在选课阶段拥挤的教务系统中选到想选的课；</p>
        </li>
        <li>
            <p>移动设备兼容的网页设计，方便你随时随地使用教务系统；</p>
        </li>
        <li>
            <p>通过这个平台提供统一的数据接口，可以进一步开发出手机客户端、<a href="<%= $this->createUrl('/site/wechat'); %>">微信公众平台</a>；</p>
        </li>
    </ul>

    <div class="page-header">
        <h3><span class="glyphicon glyphicon-lock"></span> 隐私与安全</h3>
    </div>
    <p>我们注重个人的隐私，并保证你的个人信息不会以任何形式公开。需要声明的是，为了提高系统效率，你的一些信息（班级、课表、成绩）会被缓存在数据库中。</p>
    <p>为了让你可以清楚的知道我们的系统做了什么，我们选择将源代码公开，在 <a href="https://github.com/QiuXiang/AmsProxy">Github</a> 你可以查看整个项目的源代码，如果你也是开发者，欢迎你的贡献。</p>
    <p>我们清楚的知道，没有绝对安全的系统，但我们仍然可以自信的将源代码公开，因为我们相信，虽然开源更容易将 bug 暴露，但系统也将因此而更加健壮。</p>

    <div class="page-header">
        <h3><span class="glyphicon glyphicon-wrench"></span> 开发者</h3>
    </div>
    <p>目前的开发者主要是相思湖网站网络部的成员们。如果你也是开发者，如果你也对“相思青果”感兴趣，欢迎你的 fork and pull :)</p>
    <ul>
        <li>
            <p>
                <span class="glyphicon glyphicon-user"></span> 丘翔<br>
                <span class="glyphicon glyphicon-tag"></span> 10网络工程<br>
                <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:qiuxiang55aa@gmail.com">xiang.qiu@foxmail.com</a>
            </p>
        </li>
        <li>
            <p>
                <span class="glyphicon glyphicon-user"></span> 徐伟榕<br>
                <span class="glyphicon glyphicon-tag"></span> 11软件工程1班<br>
                <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:weirongxuraidou@gmail.com">weirongxuraidou@gmail.com</a>
            </p>
        </li>
    </ul>
</div>
