<?php
if (!isset($type))
    $type = 0;

$this->widget('ext.widgets.dataTable', array(
    'data' => $data,
    'type' => $type,
));
