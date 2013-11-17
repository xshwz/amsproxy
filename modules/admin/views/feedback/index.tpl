<% $this->pageTitle = '反馈'; %>

<div class="messages">
    <% foreach ($messages as $group): %>
    <div class="session">
        <%
        foreach ($group['session'] as $message):
            $className = 'other';
            if ($message->sender == 0)
                $className = 'admin';
            elseif ($message->receiver == 0)
                $className = 'user';

            if ($message->state)
                $className .= ' unread';
        %>
            <div class="<%= $className; %>">
                <p><%= $message->message; %></p>
                <em class="time"><%= $message->time; %></em>

                <% if ($message->sender == 0): %>
                <a
                    href="#edit-modal"
                    class="edit operate"
                    title="编辑"
                    data-toggle="modal"
                    data-id='<%= $message->id; %>'>
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <% elseif ($message->receiver == 0): %>
                <a
                    href="#send-modal"
                    class="send operate"
                    title="发送消息"
                    data-toggle="modal"
                    data-reply='<%= $message->id; %>'
                    data-sid='<%= $group['sender']->sid; %>'>
                    <span class="glyphicon glyphicon-send"></span>
                </a>
                <% endif; %>
            </div>
        <% endforeach; %>
        <div class="bottom text-right">
            <a
                href="#detail-modal"
                class="detail"
                title="用户信息"
                data-toggle="modal"
                data-json='<%= $group['sender']->archives; %>'>
                <span class="glyphicon glyphicon-user"></span>
            </a>
        </div>
    </div>
    <% endforeach; %>
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
                    action="<%= Yii::app()->createUrl('admin/message/send'); %>"
                    method="post">
                    <input type="hidden" name="sender" value="0">
                    <input type="hidden" name="receiver" id="send-form-sid">
                    <input type="hidden" name="reply" id="reply-id">
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
                <h4 class="modal-title">
                    <span class="glyphicon glyphicon-user"></span>
                    用户信息
                </h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
