<%
$this->widget('ext.widgets.courseTable',
    array('courses' => $courses)
);
%>
<p class="text-muted padding-box"><em>
    <span class="glyphicon glyphicon-info-sign"></span>
    点击课程可以显示详细信息
</em></p>
