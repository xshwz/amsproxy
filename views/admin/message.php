<div class="article table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>发送者</th>
                <th>接收者</th>
                <th>内容</th>
                <th>时间</th>
                <th>状态</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
            <tr>
                <td>
                    <?php if ($message->sender): ?>
                    <a
                        href="#detail-modal"
                        class="detail"
                        data-toggle="modal"
                        data-json='<?php echo $message->_sender['archives']; ?>'>
                        <?php echo $message->sender; ?>
                    </a>
                    <?php else: ?>
                    管理员
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($message->receiver): ?>
                    <a
                        href="#detail-modal"
                        class="detail"
                        data-toggle="modal"
                        data-json='<?php echo $message->_receiver['archives']; ?>'>
                        <?php echo $message->receiver; ?>
                    </a>
                    <?php else: ?>
                    管理员
                    <?php endif; ?>
                </td>
                <td><?php echo CHtml::encode($message->message); ?></td>
                <td class="time"><?php echo $message->time; ?></td>
                <td>
                    <?php
                    if ($message->state == 0)
                        echo '已读';
                    else
                        echo '未读';
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php // TODO: 分页 ?>
</div>

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
                    action="<?php echo Yii::app()->createUrl('admin/send'); ?>"
                    method="post">
                    <input type="hidden" name="sender" value="0">
                    <input type="hidden" name="receiver" id="send-form-sid">
                    <div class="form-group">
                        <textarea
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

<div class="modal fade" id="detail-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">详细资料</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
