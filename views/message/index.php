<?php if (count($messages) > 0): ?>
<div class="content table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>发送者</th>
                <th>内容</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($messages as $message):
            if ($message->sender) {
                // TODO
            } else {
                $sender = '管理员';
            }
            ?>
            <tr>
                <td><?php echo $sender; ?></td>
                <td><?php echo CHtml::encode($message->message); ?></td>
                <td class="time"><?php echo $message->time; ?></td>
                <td>
                    <a
                        href="#send-modal"
                        class="send"
                        title="发送消息"
                        data-toggle="modal"
                        data-sid='<?php echo $message->sender; ?>'>
                        <span class="glyphicon glyphicon-send"></span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<div class="modal fade" id="send-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">发送消息</h4>
            </div>
            <div class="modal-body">
                <form
                    id="ajaxSendForm"
                    action="<?php echo Yii::app()->createUrl('message/send')?>"
                    method="post">
                    <input type="hidden" name="receiver" id="send-form-sid">
                    <div class="form-group">
                        <textarea
                            type="text"
                            name="message"
                            rows="4"
                            id="send-msg"
                            class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn">
                        <i class="glyphicon glyphicon-send"></i> 发送
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
