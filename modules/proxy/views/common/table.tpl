<?php
if (!isset($isCollapse)) $isCollapse = true;

$this->widget('ext.widgets.dataTable', array(
    'data' => $data,
    'isCollapse' => $isCollapse,
));

$messageContent = isset($message) ? $message : null;
?>
<br>
<br>
<? if($messageContent != null){ ?>
    <p class="text-muted">
        <span class="glyphicon glyphicon-info-sign"></span>
        <?= $messageContent?>
    </p>
<? } ?>