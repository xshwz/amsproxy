<div class="content table-responsive" id="studentList">
    <form class="form-inline search-form" method="get">
        <input type="hidden" name="r" value="<?php echo $_GET['r']; ?>">
        <div class="form-group">
            <div class="input-group">
                <input
                    type="text"
                    name="keyword"
                    placeholder="关键字"
                    class="form-control"
                    value="<?php if (isset($_GET['keyword'])) echo $_GET['keyword']; ?>">
                <span class="input-group-btn">
                    <button class="btn" type="submit" title="搜索">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
    </form>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>姓名</th>
                <th>班级</th>
                <th>最近登录时间</th>
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
                <td><?php echo $student->last_login_time; ?></td>
                <td>
                    <a
                        href="#detail-modal"
                        class="detail"
                        title="详细资料"
                        data-toggle="modal"
                        data-sid='<?php echo $student->sid; ?>'
                        data-json='<?php echo $student->info; ?>'>
                        <span class="glyphicon glyphicon-file"></span>
                    </a>
                    <a
                        href="#send-modal"
                        title="发送消息"
                        data-toggle="modal"
                        data-sid='<?php echo $student->sid; ?>'
                        class="send">
                        <span class="glyphicon glyphicon-send"></span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($count > 1): ?>
        <div>
            <?php if ($count > 20): ?>
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
                    'htmlOptions' => array(
                        'id' => 'studentLinkPager',
                        'class' => 'pagination pagination-sm pull-left hidden-xs',
                    ),
                ));
                ?>
                <div class="listPager pull-left">
                    <?php
                    $this->widget('CListPager', array(
                        'pages' => $pages,
                        'header' => '',
                        'htmlOptions' => array(
                            'id' => 'studentListPager',
                            'class' => 'form-control input-sm',
                        ),
                    ));
                    ?>
                </div>
            <?php endif; ?>
            <span class="badge pull-left"><?php echo $count; ?></span>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>
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
                    id="ajaxSendForm"
                    action="<?php echo Yii::app()->createUrl('admin/send')?>"
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
