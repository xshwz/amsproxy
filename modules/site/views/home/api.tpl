<% $this->pageTitle = 'API'; %>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>用途</th>
                <th>身份验证</th>
                <th>URL</th>
                <th>请求方法</th>
                <th>参数</th>
                <th>返回值</th>
                <th>说明</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>读取验证码</td>
                <td><span class="label label-success">不需要</span></td>
                <td>
                    <a href="<%= $this->createUrl('/site/api/vcode') %>">
                        api/vcode
                    </a>
                </td>
                <td><span class="label">GET</span></td>
                <td>
                    <code>base64</code>: <code>true</code> 或 <code>false</code>
                    默认为 <code>flase</code>
                </td>
                <td>验证码数据</td>
                <td>获取验证码</td>
            </tr>
            <tr>
                <td rowspan="2">登录</td>
                <td rowspan="2"><span class="label label-success">不需要</span></td>
                <td rowspan="2">
                    <a href="<%= $this->createUrl('/site/api/login') %>">
                        api/login
                    </a>
                </td>
                <td><span class="label">GET</span></td>
                <td></td>
                <td rowspan="2"><code>true</code> 或 <code>false</code></td>
                <td>检查当前会话是否已经登录</td>
            </tr>
            <tr>
                <td><span class="label label-danger">POST</span></td>
                <td>
                    <ul class="list-unstyled">
                        <li><code>sid</code>：学号</li>
                        <li><code>pwd</code>：密码</li>
                    </ul>
                </td>
                <td>进行登录</td>
            </tr>

            <tr>
                <td>获取个人学籍档案</td>
                <td><span class="label label-warning">需要</span></td>
                <td>
                    <a href="<%= $this->createUrl('/proxy/api/archives') %>">
                        api/archives
                    </a>
                </td>
                <td><span class="label">GET</span></td>
                <td></td>
                <td><span class="label">json</span></td>
                <td></td>
            </tr>

            <tr>
                <td rowspan="2">获取课程</td>
                <td rowspan="2"><span class="label label-warning">需要</span></td>
                <td rowspan="2">
                    <a href="<%= $this->createUrl('/proxy/api/courses') %>">
                        api/courses
                    </a>
                </td>
                <td><span class="label">GET</span></td>
                <td rowspan="2"></td>
                <td rowspan="2"><span class="label">json</span></td>
                <td>从缓存获取数据</td>
            </tr>
            <tr>
                <td><span class="label label-danger">POST</span></td>
                <td>获取最新数据，同时更新缓存</td>
            </tr>

            <tr>
                <td rowspan="2">获取成绩</td>
                <td rowspan="2"><span class="label label-warning">需要</span></td>
                <td rowspan="2">
                    <a href="<%= $this->createUrl('/proxy/api/scores') %>">
                        api/scores
                    </a>
                </td>
                <td><span class="label">GET</span></td>
                <td rowspan="2"></td>
                <td rowspan="2"><span class="label">json</span></td>
                <td>从缓存获取数据</td>
            </tr>
            <tr>
                <td><span class="label label-danger">POST</span></td>
                <td>获取最新数据，同时更新缓存</td>
            </tr>

            <tr>
                <td rowspan="2">获取等级考试成绩</td>
                <td rowspan="2"><span class="label label-warning">需要</span></td>
                <td rowspan="2">
                    <a href="<%= $this->createUrl('/proxy/api/rankExam') %>">
                        api/rankexam
                    </a>
                </td>
                <td><span class="label">GET</span></td>
                <td rowspan="2"></td>
                <td rowspan="2"><span class="label">json</span></td>
                <td>从缓存获取数据</td>
            </tr>
            <tr>
                <td><span class="label label-danger">POST</span></td>
                <td>获取最新数据，同时更新缓存</td>
            </tr>

            <tr>
                <td rowspan="2">获取考试安排表</td>
                <td rowspan="2"><span class="label label-warning">需要</span></td>
                <td rowspan="2">
                    <a href="<%= $this->createUrl('/proxy/api/exam') %>">
                        api/exam
                    </a>
                </td>
                <td><span class="label">GET</span></td>
                <td rowspan="2"></td>
                <td rowspan="2"><span class="label">json</span></td>
                <td>从缓存获取数据</td>
            </tr>
            <tr>
                <td><span class="label label-danger">POST</span></td>
                <td>获取最新数据，同时更新缓存</td>
            </tr>

            <tr>
                <td>更新数据</td>
                <td><span class="label label-warning">需要</span></td>
                <td>
                    <a href="<%= $this->createUrl('/proxy/api/update') %>">
                        api/update
                    </a>
                </td>
                <td><span class="label label-danger">POST</span></td>
                <td><code>field</code><small>（以后再说……）</small></td>
                <td><code>true</code></td>
                <td>默认更新所有数据</td>
            </tr>
        </tbody>
    </table>
</div>
