<div class="pages">
    <% if ($count > 1): %>
        <div>
            <% if ($count > 20): %>
                <%
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
                %>
            <% endif; %>
            <span class="badge"><%= $count; %></span>
            <div class="clearfix"></div>
        </div>
    <% endif; %>
</div>
