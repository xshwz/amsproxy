<div class="messages">
<%
foreach ($logs as $log):
$message = simplexml_load_string($log->message);
$student = Student::model()->find('wechat_openid=:openId',
    array(':openId' => $message->FromUserName));

$from = '';

if ($message->ToUserName == 'gh_67699ccd1b26')
    $from = '来自订阅号';

if ($message->ToUserName == 'gh_a5d994754b2a')
    $from = '来自服务号';

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
}
%>
<div class="session <%= $stateClass %>">
    <blockquote>
    <%= $content %>
    </blockquote>
    <div class="bottom">
        <div class="pull-left">
            <p><em><small>
                <%= date('Y-m-d H:i:s', (int)$message->CreateTime) %>
                <%= $from %>
            </small></em></p>
        </div>
        <div class="pull-right">
            <% if ($student): %>
            <a
                href="#detail-modal"
                class="detail"
                title="用户信息"
                data-toggle="modal"
                data-json='<%= $student->archives; %>'>
                <span class="glyphicon glyphicon-user"></span>
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
