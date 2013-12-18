<% $this->pageTitle = '管理员' %>

<form action="<%= $this->createUrl('add') %>" class="form-inline search-form" method="POST">
    <div class="form-group">
        <div class="input-group">
            <input
                type="text"
                name="sid"
                placeholder="学号"
                class="form-control">
            <span class="input-group-btn">
                <button class="btn" type="submit" title="添加">
                    <span class="glyphicon glyphicon-plus"></span>
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
            foreach ($adminers as $student):
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
                        href="#remove-modal"
                        title="移除"
                        data-toggle="modal"
                        data-sid='<%= $student->sid; %>'
                        class="text-danger remove">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                </td>
            </tr>
            <% endforeach; %>
        </tbody>
    </table>
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

<div class="modal fade" id="remove-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">移除管理员</h4>
            </div>
            <div class="modal-body">
                <form action="<%= $this->createUrl('remove') %>" method="post">
                    <input type="hidden" name="sid" id="sid">
                    <button type="submit" class="btn btn-danger">
                        <span class="glyphicon glyphicon-remove"></span>
                        确定移除
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
