<div class="jumbotron home">
    <p class="current-date">
        今天是
        <em class="date"><%= date('Y 年 n 月 j 日'); %></em>
        ，第
        <span class="week-number badge">
            <%= $this->weekNumber(); %>
        </span>
        个教学周。
    </p>
    <p>
        <a class="btn btn-lg btn-bottom" href="<%= $this->createUrl('/proxy/course/today'); %>">
            <span class="glyphicon glyphicon-list"></span>
            今日课程
        </a>
        <a class="btn btn-lg btn-warning btn-bottom" href="<%= $this->createUrl('/proxy/score/stats'); %>">
            <span class="glyphicon glyphicon-list-alt"></span>
            我的成绩
        </a>
    </p>
</div>

<!--
<div class="row">
    <% foreach ($examArrangement['tbody'] as $exam): %>
    <div class="col-sm-6 col-md-4 col-lg-3">
        <dl class="card">
            <dd>
                <span class="glyphicon glyphicon-book"></span>
                <%= $exam[0] %>
            </dd>
            <dd>
                <span class="glyphicon glyphicon-tag"></span>
                <%= $exam[2] %>/<%= $exam[3] %>课
            </dd>
            <dd>
                <span class="glyphicon glyphicon-star"></span>
                <%= $exam[1] %>（学分）
            </dd>
            <dd>
                <span class="glyphicon glyphicon-time"></span>
                <%= $exam[4] %>
            </dd>
            <dd>
                <span class="glyphicon glyphicon-map-marker"></span>
                <%= $exam[5] %>
            </dd>
            <dd>
                <span class="glyphicon glyphicon-pushpin"></span>
                <%= $exam[6] %>（座位号）
            </dd>
        </dl>
    </div>
    <% endforeach; %>
</div>
-->

<em class="visible-xs tips">
    <span class="glyphicon glyphicon-info-sign"></span>
    点击左下角的小按钮可以弹出菜单哦
    <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
</em>
