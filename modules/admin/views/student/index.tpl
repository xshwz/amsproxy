<form class="form-inline search-form" id="search-form">
    <div class="form-group">
        <div class="input-group">
            <input
                id="search-keyword"
                type="text"
                name="keyword"
                placeholder="关键字"
                class="form-control"
                value="<%= $this->param('keyword'); %>">
            <span class="input-group-btn">
                <button class="btn" type="submit" id="search-submit" title="搜索">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
</form>
<div class="article table-responsive" id="studentList">
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
            <%
            foreach ($students as $student):
            $archives = (array)$student->getArchives();
            %>
            <tr>
                <td><%= $archives['姓名']; %></td>
                <td><%= $archives['行政班级']; %></td>
                <td><%= $student->last_login_time; %></td>
                <td>
                    <a
                        href="#detail-modal"
                        class="detail"
                        title="详细资料"
                        data-toggle="modal"
                        data-sid='<%= $student->sid; %>'
                        data-json='<%= $student->archives; %>'>
                        <span class="glyphicon glyphicon-file"></span>
                    </a>
                    <a
                        href="#send-modal"
                        title="发送消息"
                        data-toggle="modal"
                        data-sid='<%= $student->sid; %>'
                        class="send">
                        <span class="glyphicon glyphicon-send"></span>
                    </a>
                </td>
            </tr>
            <% endforeach; %>
        </tbody>
    </table>
</div>

<% $this->renderPartial('/common/pages', array(
    'count' => $count,
    'pages' => $pages,
)) %>

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
                    action="<%= Yii::app()->createUrl('admin/message/send'); %>"
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
