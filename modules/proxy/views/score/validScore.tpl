<img src='<%= $src %>' style="margin-bottom:20px;">

<%
if (!isset($isCollapse)) $isCollapse = true;

$this->widget('ext.widgets.dataTable', array(
    'data' => $data,
    'isCollapse' => $isCollapse,
));
%>

<br>
<p class="text-muted"><em>
    <span class="glyphicon glyphicon-info-sign"></span>
    点击<strong>右上角的刷新</strong>按钮可以获取最新数据~
</em></p>