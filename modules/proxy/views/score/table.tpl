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
    点击右上角的刷新按钮可以获取最新数据。其他页面一样的~
</em></p>
<p class="text-muted"><em>
    <span class="glyphicon glyphicon-info-sign"></span>
    没有评教可能会导致无法查看成绩,去看看有木有原始成绩
</em></p>
