<div class="article">
    <form class="form-inline" method="get">
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control">
                <span class="input-group-btn">
                    <button class="btn" type="button">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
    </form>
    <br>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>姓名</th>
                <th>班级</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($students as $student):
            $studentInfo = json_decode($student->info, true);
            ?>
            <tr>
                <td><?php echo $studentInfo['姓名']; ?></td>
                <td><?php echo $studentInfo['行政班级']; ?></td>
                <td>
                    <a
                        href="#detail-modal"
                        class="detail"
                        data-toggle="modal"
                        data-json='<?php echo $student->info; ?>'>
                        <span class="glyphicon glyphicon-search"></span>
                    </a>
                    <a
                        href="#send-modal"
                        data-toggle="modal"
                        class="send">
                        <span class="glyphicon glyphicon-send"></span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pages,
        'header' => '',
        'cssFile' => '',
        'hiddenPageCssClass' => 'disabled',
        'selectedPageCssClass' => 'active',
        'nextPageLabel' => '&gt;',
        'prevPageLabel' => '&lt;',
        'firstPageLabel' => '&lt;&lt;',
        'lastPageLabel' => '&gt;&gt;',
        'maxButtonCount' => 5,
        'htmlOptions' => array(
            'id' => 'pager',
            'class' => 'pagination',
        ),
    ));
    ?>
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

<div class="modal fade" id="send-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">发送消息</h4>
            </div>
            <div class="modal-body">
                <form
                    id="send-form"
                    action="<?php echo Yii::app()->createUrl('admin/send')?>"
                    method="post">
                    <input type="hidden" id="send-form-sid">
                    <div class="form-group">
                        <textarea
                            type="text"
                            name="msg"
                            rows="4"
                            id="input-msg"
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
