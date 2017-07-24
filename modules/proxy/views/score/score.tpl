
<p><%= $lastXN.'年'. ((!$lastXQ)?'第一学期':'第二学期') %></p>

<img src='<%= $src %>'>

<% if(isset($scoreMinor)){ %>
<br><br>
<p>辅修</p>
<img src="<%= $scoreMinor %>">
<% } %>

<br><br>
<p class="text-muted"><em>
    <span class="glyphicon glyphicon-info-sign"></span>
    点击<strong>右上角的刷新</strong>按钮可以获取最新数据~
</em></p>