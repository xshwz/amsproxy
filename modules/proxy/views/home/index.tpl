<div class="jumbotron home">
    <p class="current-date">
        今天是
        <em class="date"><%= date('Y 年 n 月 j 日'); %></em>
        ，第
        <span class="week-number badge">
            <%= $this->weekNumber('2013-11-22'); %>
        </span>
        个教学周。
    </p>
    <p>
        <a class="btn btn-lg btn-bottom" href="<%= $this->createUrl('/proxy/course/today'); %>">
            <span class="glyphicon glyphicon-list"></span>
            今日课程
        </a>
        <a class="btn btn-lg btn-warning btn-bottom" href="<%= $this->createUrl('/proxy/rankExam/form'); %>">
            <span class="glyphicon glyphicon-hand-right"></span>
            等级考试报名
        </a>
    </p>
</div>
<em class="visible-xs tips">
    <span class="glyphicon glyphicon-info-sign"></span>
    点击左下角的小按钮可以弹出菜单哦
    <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
</em>
