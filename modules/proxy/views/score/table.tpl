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
    点击<%= CHtml::link('更新数据', array('/proxy/setting/update')) %>可以获取最新成绩。
</em></p>
<p class="text-muted"><em>
    <span class="glyphicon glyphicon-info-sign"></span>
    没有评教会导致无法查看成绩。
</em></p>
