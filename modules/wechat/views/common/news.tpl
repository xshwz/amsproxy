<xml>
    <ToUserName><%= $this->request->FromUserName %></ToUserName>
    <FromUserName><%= $this->request->ToUserName %></FromUserName>
    <CreateTime><%= time() %></CreateTime>
    <MsgType>news</MsgType>
    <ArticleCount><%= count($data) %></ArticleCount>
    <Articles>
        <% foreach ($data as $article): %>
        <item>
            <% if (isset($article->title)): %>
            <Title><![CDATA[<%= $article->title %>]]></Title> 
            <% endif %>

            <% if (isset($article->description)): %>
            <Description><![CDATA[<%= $article->description %>]]></Description>
            <% endif %>

            <% if (isset($article->pictureUrl)): %>
            <PicUrl><![CDATA[<%= $article->pictureUrl %>]]></PicUrl>
            <% endif %>

            <% if (isset($article->url)): %>
            <Url><![CDATA[<%= $article->url %>]]></Url>
            <% endif %>
        </item>
        <% endforeach %>
    </Articles>
</xml>
