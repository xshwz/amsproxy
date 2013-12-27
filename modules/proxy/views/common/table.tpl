<?php
if (!isset($isCollapse)) $isCollapse = true;

$this->widget('ext.widgets.dataTable', array(
    'data' => $data,
    'isCollapse' => $isCollapse,
));
