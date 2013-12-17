<%
$this->pageTitle = '课程表';
$this->widget('ext.widgets.courseTable',
    array('courses' => $courses)
);
%>
<br>
<p class="text-muted"><em>
    <span class="glyphicon glyphicon-info-sign"></span>
    点击课程可以显示详细信息
</em></p>
