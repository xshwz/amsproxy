<% $this->pageTitle = '主页' %>

<div class="jumbotron home">
    <p class="current-date">
        今天是
        <em class="date"><%= date('Y 年 n 月 j 日'); %></em>
        ，
        <% if ($this->weekNumber() >= 0): %>
        第
        <span class="week-number badge">
            <%= $this->weekNumber(); %>
        </span>
        个教学周。
        <% endif %>
        <% if ($this->weekNumber() < 0): %>
        假期还有
        <span class="week-number badge">
            <%= -$this->weekNumber(); %>
        </span>
        周喔~
        <% endif %>
    </p>
    <p>
        <a class="btn btn-lg btn-bottom" href="<%= $this->createUrl('/proxy/course/tableImg'); %>">
            <span class="glyphicon glyphicon-list"></span>
            我的课表
        </a>
        <a class="btn btn-lg btn-warning btn-bottom" href="<%= $this->createUrl('/proxy/score/stats'); %>">
            <span class="glyphicon glyphicon-list-alt"></span>
            我的成绩
        </a>
    </p>
    <br>
    <br>
    <br>
    <br>
    <p class="text-muted" style="font-size:17px;">
        <span class="glyphicon glyphicon-info-sign"></span> Update log
    </p>
    <p class="text-muted" style="font-size:14px;">
        7/03 : 增加<b>辅修</b>成绩查看, 加快首次登陆时间~<br>
        6/28 : 修复成绩查看~现在设定为6/25号之后查看这个期末的成绩,25之前是上个学期的成绩~<br>
        4/11 : 增加入学以来的绩点统计~有什么功能需要的可以点右上角给我留言~~<br>
        3/26 : 修复更新失败的bug~<br>
        2/24 : 修复第几周的显示<br>
        1/21 : 小调整,右上角有<b>反馈</b>按钮<br>
        1/20 : 修复登陆逻辑,还有因为无法访问教务系统而导致的错误提示<br>
        1/19 : 恢复课表查询,修复有效成绩部分同学因为没有下面没有小小的统计表导致的程序错误<br>
        1/18 : 完善成绩查询,搞定右上角的<b>刷新</b>按钮,优化登陆逻辑还有缓存更新逻辑<br>
        1/17 : 数据库迁移,无验证码自动登录,感谢老大<br>
    </p>
</div>