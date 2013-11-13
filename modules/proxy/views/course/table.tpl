<%
$this->pageTitle = '课程表';
$this->widget('ext.widgets.courseTable',
    array('courses' => $courses)
);
%>
