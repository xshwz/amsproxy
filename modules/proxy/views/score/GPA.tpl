
<%
if (!isset($isCollapse)) $isCollapse = true;

$this->widget('ext.widgets.dataTable', array(
    'data' => $data,
    'isCollapse' => $isCollapse,
));
%>

<%
if (!isset($isCollapse)) $isCollapse = true;

if(isset($graduateRequirement->score))
    $this->widget('ext.widgets.dataTable', array(
        'data' => $graduateRequirement->score,
        'isCollapse' => $isCollapse,
    ));
%>

<br>
<p class="text-muted"><em>
    <span class="glyphicon glyphicon-info-sign"></span>
    点击<strong>右上角的刷新</strong>按钮可以获取最新数据~<br>
    部分同学可能因为教务系统那边没有数据, 所以导致这边最新数据刷新不出来
</em></p>