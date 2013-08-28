<div class="article">
    <div class="page-header">
      <h3>为什么叫相思青果？</h3>
    </div>
    <p>不用在意细节，现在只是暂时想不到什么好的名字。原为“教务系统代理”，然而未免太过无味。鉴于该系统运行于相思湖网站，开发者又是相思湖网站的成员，加之学校教务系统名为青果，便取“相思”与“青果”二者结合，名曰“相思青果”。</p>

    <div class="page-header">
      <h3>意图</h3>
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
            <p>通过这个平台提供统一的数据接口，可以进一步开发出手机客户端；</p>
        </li>
    </ul>

    <div class="page-header">
      <h3>浏览器兼容性</h3>
    </div>
    <p>如果你很关心浏览器兼容性问题，或者在这方面遇到了问题，请点击<a href="<?php echo Yii::app()->createUrl('site/compatibility')?>">这里</a>。</p>

    <div class="page-header">
      <h3>隐私与安全</h3>
    </div>
    <p>我们注重个人隐私，在涉及个人隐私的时候，我们会提醒你，让你决定是否公开自己的信息。需要声明的是，为了提高效率，你的密码和学籍信息会被缓存在数据库中，不过不用担心，密码经过 MD5 加密，而你的个人信息我们会保证安全并且不用作其他用途。</p>
    <p>然而说的话总归只是一面之词，为了让你可以清楚的知道我们的系统到底做了什么，我们公开了源代码，在 <a href="https://github.com/QiuXiang/AmsProxy">github</a> 你可以查看整个项目的源代码，如果你也是开发者，甚至可以向我们贡献你的代码。</p>
    <p>我们清楚的知道，没有绝对安全的系统，特别是在相思湖网站漏洞百出的服务器，但我们仍然可以自信的将源代码公开，因为我们相信，虽然开源更容易将 bug 暴露，但系统也将因此而更加健壮。</p>

    <div class="page-header">
      <h3>开发者</h3>
    </div>
    <ul>
        <li>
            <p>
                丘翔，10网络工程，<a href="mailto:qiuxiang55aa@gmail.com">qiuxiang55aa@gmail.com</a>
            </p>
        </li>
        <li>
            <p>
                徐伟榕，11软件工程1班，<a href="mailto:weirongxuraidou@gmail.com">weirongxuraidou@gmail.com</a>
            </p>
        </li>
    </ul>
</div>
