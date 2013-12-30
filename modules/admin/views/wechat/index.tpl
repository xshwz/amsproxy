<div class="messages">
<%
foreach ($logs as $log):
    $message = simplexml_load_string($log->message);

    if ($message->ToUserName == 'gh_67699ccd1b26') {
        $field = 'openid_subscribe';
        $from = '来自<span class="text-warning">订阅号</span>';
    } elseif ($message->ToUserName == 'gh_a5d994754b2a') {
        $field = 'openid_server';
        $from = '来自<span class="text-info">服务号</span>';
    } else {
        $field = 'null';
        $from = '来自<span class="text-danger">未知</span>';
    }

    $student = Student::model()->find(
        $field . '=:openId',
        array(
            ':openId' => $message->FromUserName,
        )
    );

    if ($log->state)
        $stateClass = 'success';
    else
        $stateClass = '';

    switch ($message->MsgType) {
        case 'text':
            $messageTypeIcon = 'comment';
            $messageTypeTitle = '文本';
            $content = $message->Content;
            break;

        case 'event':
            $messageTypeIcon = 'bell';
            $messageTypeTitle = '事件';
            $content = '<span class="label">' . $message->Event . '</span>';

            if (isset($message->EventKey)) {
                $content .=
                    ' <span class="label label-warning">' .
                        $message->EventKey .
                    '</span>';
            }

        default:
            $messageTypeIcon = 'question-sign';
            $messageTypeTitle = '未知';
            $content = '<span class="label label-danger">' . $message->MsgType . '</span>';
    }
%>
<div class="session <%= $stateClass %>">
    <p><%= $content %></p>
    <div class="bottom">
        <div class="pull-left">
            <p><em><small>
                <%= date('Y-m-d H:i:s', (int)$message->CreateTime) %>
                <%= $from %>
            </small></em></p>
        </div>
        <div class="pull-right">
            <%
            if ($student):
                $archives = (array)json_decode($student->archives);
            %>
            <a
                href="#detail-modal"
                class="detail user"
                title="用户信息"
                data-toggle="modal"
                data-json='<%= $student->archives; %>'>
                <small>
                    <%= $archives['行政班级'] . ' ' . $archives['姓名'] %>
                </small>
            </a>
            <% endif %>
            <span title="<%= $messageTypeTitle %>" class="glyphicon glyphicon-<%= $messageTypeIcon %>"></span>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<% endforeach %>
</div>

<div class="modal fade" id="detail-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">
                    <span class="glyphicon glyphicon-user"></span>
                    用户信息
                </h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<% $this->renderPartial('/common/pages', array(
    'count' => $count,
    'pages' => $pages,
)) %>
