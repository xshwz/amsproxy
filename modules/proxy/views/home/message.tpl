<% $this->pageTitle = '消息'; %>

<div class="messages">
    <%
    foreach ($messages as $message):
        if ($message->sender == 0)
            $className = 'admin';
        elseif ($message->receiver == 0)
            $className = 'user';
        else
            continue;
    %>
    <div class="message <%= $className; %>">
        <div class="message-arrow"></div>
        <div class="message-inner">
            <p class="content"><%= $message->message; %></p>
            <em class="time"><%= $message->time; %></em>
        </div>
    </div>
    <% endforeach; %>
</div>
