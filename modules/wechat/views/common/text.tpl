<xml>
    <ToUserName><%= $this->request->FromUserName %></ToUserName>
    <FromUserName><%= $this->request->ToUserName %></FromUserName>
    <CreateTime><%= time() %></CreateTime>
    <MsgType>text</MsgType>
    <Content><%= $content %></Content>
</xml>
