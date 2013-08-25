<div class="content table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>状态</th>
                <th>发送者</th>
                <th>内容</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($messages as $message):
                $student = Student::model()->findByPk($message->sender);
            ?>
            <tr>
                <td>
                    <form method="post" class="text-center">
                        <input type="hidden" name="id" value="<?php echo $message->id; ?>">
                        <input
                            type="checkbox"
                            name="state"
                            class="state"
                            <?php if ($message->state == 0) echo 'checked'; ?>>
                    </form>
                </td>
                <td>
                    <a
                        href="#detail-modal"
                        class="detail"
                        data-toggle="modal"
                        data-json='<?php echo $student->info; ?>'>
                        <?php echo $message->sender; ?>
                    </a>
                </td>
                <td><?php echo CHtml::encode($message->message); ?></td>
                <td><?php echo $message->time; ?></td>
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
