<% $this->beginContent('/layouts/base'); %>
<div class="site">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a
                    class="navbar-toggle"
                    href="javascript:"
                    data-toggle="collapse"
                    data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a href="<%= Yii::app()->createUrl('site/home/index'); %>" class="navbar-brand">
                    <img width="18" height="18" src="img/logo.png" alt="logo">
                    相思青果
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <%
                    $this->widget(
                        'zii.widgets.CMenu',
                        array(
                            'items' => array(
                                array(
                                    'label' => '微信',
                                    'url' => array('/site/wechat/index'),
                                ),
                                array(
                                    'label' => '常见问题',
                                    'url' => array('/site/home/faq'),
                                ),
                                array(
                                    'label' => '关于',
                                    'url' => array('/site/home/about'),
                                ),
                                array(
                                    'label' => 'API',
                                    'url' => array('/site/home/api'),
                                ),
                            ),
                            'htmlOptions' => array(
                                'class' => 'nav navbar-nav',
                            ),
                        )
                    );
                %>
                <ul class="nav navbar-nav navbar-right">
                    <% if ($this->isAdmin()): %>
                    <li>
                        <%= CHtml::link('管理', array('/admin')); %>
                    </li>
                    <% endif; %>
                    <li
                        <%
                        if (Yii::app()->controller->action->id == 'login'
                                && !$this->isLogged())
                            echo 'class="active"';
                        %>
                        >
                        <%= CHtml::link('青果', array('/proxy')) %>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <%= $content; %>
    </div>
    <div id="footer">
        <p class="powered">
            <em>
                Powered By
                <a href="http://xsh.gxun.edu.cn/">
                    <img src="img/logo.png" width="16" alt="xsh logo">相思湖网站
                </a>
            </em>
        </p>
    </div>
</div>
<% $this->endContent(); %>
