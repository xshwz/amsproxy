<div class="index">
    <div class="jumbotron" id="top">
        <div class="container">
            <div class="logo img-responsive">
                <img src="img/logo.png" width="64" alt="相思湖网站 logo">
            </div>
            <h1><span>相思</span>青果</h1>
            <p class="description"><em>广西民族大学教务系统代理</em></p>
            <a
                href="<%= Yii::app()->createUrl('/proxy'); %>"
                class="btn btn-lg btn-bottom">进入</a>
        </div>
    </div>

    <div class="jumbotron" id="functions-intro">
        <div class="container">
            <h2>主要功能</h2>
            <div class="col-sm-3 course">
                <div class="img">
                    <img src="img/icons/Book.png" alt="课程">
                </div>
                <div class="description">
                    <h3>课程</h3>
                    <ul>
                        <li>查看教学计划</li>
                        <li>查看课程表</li>
                        <li>更直观的显示今日课程</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3 score">
                <div class="img">
                    <img src="img/icons/Clipboard.png" alt="成绩">
                </div>
                <div class="description">
                    <h3>成绩</h3>
                    <ul>
                        <li>成绩统计</li>
                        <li>查看成绩</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3 exam">
                <div class="img">
                    <img src="img/icons/Pensils.png" alt="考试">
                </div>
                <div class="description">
                    <h3>考试</h3>
                    <ul>
                        <li>查看考试安排</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3 rankExam">
                <div class="img">
                    <img src="img/icons/Retina-Ready.png" alt="等级考试">
                </div>
                <div class="description">
                    <h3>等级考试</h3>
                    <ul>
                        <li>等级考试报名</li>
                        <li>查看等级考试成绩</li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="jumbotron" id="responsive-design">
        <div class="container">
            <div class="col-sm-8">
                <h2>响应式设计</h2>
                <p>在这里，所有页面都经过响应式设计，这意味着无论在桌面、手机还是平板上访问，都可以获得一致的体验。</p>
            </div>
            <div class="col-sm-4 text-center">
                <img src="img/responsive-design.jpg" alt="响应式设计">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div id="footer">
        <div class="container">
            <ul class="links list-inline">
                <li>
                    <a href="<%= Yii::app()->createUrl('site/home/faq'); %>">FAQ</a>
                </li>
                <li>
                    <a href="<%= Yii::app()->createUrl('site/home/about'); %>">关于</a>
                </li>
                <li>
                    <a href="<%= Yii::app()->createUrl('site/home/api'); %>">API</a>
                </li>
            </ul>
            <p class="powered">
                <em>
                    Powered By
                    <a href="//xsh.gxun.edu.cn/">
                        <img src="img/logo.png" width="16" alt="xsh logo">相思湖网站
                    </a>
                </em>
            </p>
        </div>
    </div>
</div>
