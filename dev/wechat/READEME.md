'''
$ ./send.sh text about

HTTP/1.1 200 OK
Server: nginx/1.4.1 (Ubuntu)
Date: Thu, 23 Jan 2014 05:44:34 GMT
Content-Type: text/html
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.3-1ubuntu2.1
Set-Cookie: PHPSESSID=jon1ai1vqo6d6iugmce5f15cv1; path=/
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache

<xml>
    <ToUserName>fromUserName</ToUserName>
    <FromUserName>toUserName</FromUserName>
    <CreateTime>1390455874</CreateTime>
    <MsgType>news</MsgType>
    <ArticleCount>1</ArticleCount>
    <Articles>
                <item>
                        <Title><![CDATA[关于“相思青果”]]></Title> 
            
                        <Description><![CDATA[“相思青果”是相思湖网站开发的教务系统代理，目的在于让同学们可以在外网使用教务系统，同时提供更好使用体验和更丰富的功能。

“相思青果”公众号通过开发模式提供消息自动回复，向我们的公众号发送消息（比如“成绩”），即可查询成绩、课程等（前提是要绑定哦）。]]></Description>
            
            
                        <Url><![CDATA[http://xsh.gxun.edu.cn/ams_dev/about]]></Url>
                    </item>
            </Articles>
</xml>
'''
