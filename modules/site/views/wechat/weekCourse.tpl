<div class="padding-box">
<%
$this->pageTitle = '';
$this->widget(
    'ext.widgets.courseLine',
    array('courses' => $courses, 'wday' => $wday));
%>
</div>
