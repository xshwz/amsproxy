<%
$this->pageTitle = '今日课程';
$this->widget(
    'ext.widgets.courseLine',
    array('courses' => $courses));
%>
