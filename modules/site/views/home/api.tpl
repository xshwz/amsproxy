<% $this->pageTitle = 'API'; %>

<div class="page-header">
    <h3>API 访问控制及分类</h3>
</div>
<p><code>/site/api/*</code> 是公共 API，不做身份验证。</p>
<p><code>/proxy/api/*</code> 是个人 API，需要进行身份验证，主要用于获取用户相关数据。</p>

<div class="page-header">
    <h3>
        登录
        <small>
        <a href="<%= $this->createUrl('/site/api/login'); %>">
            <%= $this->createUrl('/site/api/login'); %>
        </a>
        </small>
    </h3>
</div>
<p>“相思青果”的身份认证基于 <a href="http://us2.php.net/manual/refs.basic.session.php">PHP Session</a>，即通过 Ｃookie 中的 PHPSESSID 标识身份。</p>
<h4>GET</h4>
<p>用于检测用户是否已经登录，如果用户已登录，则返回 <code>true</code>，否则返回 <code>false</code>。</p>
<pre class="example">$ curl -i <%= $this->createFullUrl('/site/api/login'); %>

HTTP/1.1 200 OK
Server: nginx/1.4.1 (Ubuntu)
Date: Sun, 01 Dec 2013 06:39:53 GMT
Content-Type: text/html
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.3-1ubuntu2
Set-Cookie: PHPSESSID=0ff8c39cbnvctth9tafmu6sm36; path=/
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache

false</pre>
<h4>POST</h4>
<p>用于进行登录，参数：</p>
<ul>
    <li><code>sid</code>：学号</li>
    <li><code>pwd</code>：密码</li>
</ul>
<p>返回值：登录成功返回“true”，失败返回“false”。</p>
<pre class="example">$ curl -i -d 'sid=110263100166&pwd=385438' <%= $this->createFullUrl('/site/api/login'); %>

HTTP/1.1 200 OK
Server: nginx/1.4.1 (Ubuntu)
Date: Sun, 01 Dec 2013 07:09:57 GMT
Content-Type: text/html
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.3-1ubuntu2
Set-Cookie: PHPSESSID=imi5quhvltc07ohbuab1h87k27; path=/
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache
Set-Cookie: sid=%DB%F0%ABp%4F%BAZ%D8%BF7%0F%A6%14%24%F2O; expires=Tue, 31-Dec-2013 07:09:57 GMT; Max-Age=2592000
Set-Cookie: pwd=%2F%10%DC%BD%C5%9B%3C%B9; expires=Tue, 31-Dec-2013 07:09:57 GMT; Max-Age=2592000

true</pre>

<div class="page-header">
    <h3>
        获取课表
        <small>
        <a href="<%= $this->createUrl('/proxy/api/courses'); %>">
            <%= $this->createUrl('/proxy/api/courses'); %>
        </a>
        </small>
    </h3>
</div>
<p>返回当前学期课程。</p>
<pre class="example">$ curl -i -b PHPSESSID=imi5quhvltc07ohbuab1h87k27 <%= $this->createFullUrl('/proxy/api/courses'); %>

HTTP/1.1 200 OK
Server: nginx/1.4.1 (Ubuntu)
Date: Sun, 01 Dec 2013 07:27:34 GMT
Content-Type: text/html
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.3-1ubuntu2
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache

[{"courseName":"\u56fe\u50cf\u5904\u7406\u6280\u672f","credit":"2.5","totalHour":"45","examType":"\u8003\u67e5","teacherName":"\u9ec4\u6587\u94a7","weekStart":6,"weekTo":18,"weekDay":2,"lessonStart":1,"lessonTo":3,"location":"\u591a505"},{"courseName":"\u56fe\u50cf\u5904\u7406\u6280\u672f","credit":"2.5","totalHour":"45","examType":"\u8003\u67e5","teacherName":"\u9ec4\u6587\u94a7","weekStart":6,"weekTo":18,"weekDay":3,"lessonStart":4,"lessonTo":5,"location":"\u4fe1\u5de5\u697c208\u7269\u8054\u7f51\u5b9e\u9a8c\u5ba4"},{"courseName":"\u7ec4\u7f51\u6280\u672f","credit":"3.5","totalHour":"60","examType":"\u8003\u67e5","teacherName":"\u5218\u52c7","weekStart":6,"weekTo":18,"weekDay":4,"lessonStart":10,"lessonTo":12,"location":"\u591a104"},{"courseName":"\u7ec4\u7f51\u6280\u672f","credit":"3.5","totalHour":"60","examType":"\u8003\u67e5","teacherName":"\u5218\u52c7","weekStart":6,"weekTo":18,"weekDay":4,"lessonStart":4,"lessonTo":5,"location":"\u9038605"}]</pre>

<div class="page-header">
    <h3>
        获取成绩
        <small>
        <a href="<%= $this->createUrl('/proxy/api/scores'); %>">
            <%= $this->createUrl('/proxy/api/scores'); %>
        </a>
        </small>
    </h3>
</div>
<p>返回所有成绩。</p>
<pre class="example">$ curl -i -b PHPSESSID=nllta4f4uhiloujcibkru803v0 <%= $this->createFullUrl('/proxy/api/scores'); %>

HTTP/1.1 200 OK
Server: nginx/1.4.1 (Ubuntu)
Date: Sun, 01 Dec 2013 07:35:32 GMT
Content-Type: text/html
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.3-1ubuntu2
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache

{"thead":["\u8bfe\u7a0b\/\u73af\u8282","\u5b66\u5206","\u7c7b\u522b","\u8bfe\u7a0b\u7c7b\u522b","\u8003\u6838\u65b9\u5f0f","\u4fee\u8bfb\u6027\u8d28","\u6210\u7ee9","\u53d6\u5f97\u5b66\u5206","\u7ee9\u70b9","\u5b66\u5206\u7ee9\u70b9"],"tbody":{"2012-2013\u5b66\u5e74\u7b2c\u4e00\u5b66\u671f":[["\u9a6c\u514b\u601d\u4e3b\u4e49\u57fa\u672c\u539f\u7406\uff0812\u7ea7\u7528\uff09","3.0","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","","\u8003\u8bd5","\u521d\u4fee","73.00","3.0","2.3","6.90"],["\u5927\u5b66\u82f1\u8bed\u2160\uff0811\u7ea7\u300112\u7ea7\u7528\uff09","3.5","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","","\u8003\u8bd5","\u521d\u4fee","74.00","3.5","2.4","8.40"],["\u516c\u5171\u4f53\u80b2\u2160\uff0811\u7ea7\u300112\u7ea7\u7528\uff09","1.5","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","","\u8003\u8bd5","\u521d\u4fee","88.00","1.5","3.8","5.70"],["\u5927\u5b66\u751f\u5fc3\u7406\u5065\u5eb7\u6559\u80b2","2.0","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","","\u8003\u67e5","\u521d\u4fee","75.00","2.0","2.5","5.00"],["\u4f1a\u8ba1\u5b66\u539f\u7406","2.5","\u5b66\u79d1\u57fa\u7840\u8bfe\/\u5b66\u4f4d\u8bfe","\u7406\u8bba\u8bfe","\u8003\u67e5","\u521d\u4fee","67.00","2.5","1.7","4.25"],["\u65c5\u6e38\u5b66","2.5","\u5b66\u79d1\u57fa\u7840\u8bfe\/\u5b66\u4f4d\u8bfe","\u7406\u8bba\u8bfe","\u8003\u67e5","\u521d\u4fee","87.00","2.5","3.7","9.25"],["\u7ba1\u7406\u5b66","3.0","\u5b66\u79d1\u57fa\u7840\u8bfe\/\u5b66\u4f4d\u8bfe","\u7406\u8bba\u8bfe","\u8003\u8bd5","\u521d\u4fee","89.00","3.0","3.9","11.70"],["\u9ad8\u7b49\u6570\u5b66D1","4.0","\u5b66\u79d1\u57fa\u7840\u8bfe\/\u975e\u5b66\u4f4d\u8bfe","","\u8003\u8bd5","\u521d\u4fee","85.00","4.0","3.5","14.00"]],"2012-2013\u5b66\u5e74\u7b2c\u4e8c\u5b66\u671f":[["\u601d\u60f3\u9053\u5fb7\u4fee\u517b\u4e0e\u6cd5\u5f8b\u57fa\u7840","3.0","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","\u7406\u8bba\u8bfe","\u8003\u67e5","\u521d\u4fee","84.00","3.0","3.4","10.20"],["\u5927\u5b66\u82f1\u8bed\u2161\uff0811\u7ea7\u300112\u7ea7\u7528\uff09","4.5","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","","\u8003\u8bd5","\u521d\u4fee","71.00","4.5","2.1","9.45"],["\u8ba1\u7b97\u673a\u6587\u5316\u57fa\u7840\uff0811\u300112\u7ea7\u7528\uff09","4.0","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","","\u8003\u8bd5","\u521d\u4fee","91.00","4.0","4.1","16.40"],["\u516c\u5171\u4f53\u80b2\u2161\uff0811\u7ea7\u300112\u7ea7\u7528\uff09","1.5","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","","\u8003\u8bd5","\u521d\u4fee","87.00","1.5","3.7","5.55"],["\u6c11\u65cf\u7406\u8bba\u4e0e\u6c11\u65cf\u653f\u7b56","1.5","\u516c\u5171\u8bfe\/\u5fc5\u4fee\u8bfe","","\u8003\u67e5","\u521d\u4fee","85.00","1.5","3.5","5.25"],["\u897f\u65b9\u7ecf\u6d4e\u5b66","3.0","\u5b66\u79d1\u57fa\u7840\u8bfe\/\u5fc5\u4fee\u8bfe","\u7406\u8bba\u8bfe","\u8003\u67e5","\u521d\u4fee","69.00","3.0","1.9","5.70"],["\u65c5\u6e38\u5730\u7406\u5b66","2.5","\u5b66\u79d1\u57fa\u7840\u8bfe\/\u5fc5\u4fee\u8bfe","\u7406\u8bba\u8bfe","\u8003\u8bd5","\u521d\u4fee","74.00","2.5","2.4","6.00"],["\u5e94\u7528\u6587\u5199\u4f5c","3.0","\u5b66\u79d1\u57fa\u7840\u8bfe\/\u5fc5\u4fee\u8bfe","\u7406\u8bba\u8bfe","\u8003\u67e5","\u521d\u4fee","86.00","3.0","3.6","10.80"],["\u65c5\u6e38\u5fc3\u7406\u5b66","2.5","\u4e13\u4e1a\u57fa\u7840\u8bfe\/\u5fc5\u4fee\u8bfe","\u7406\u8bba\u8bfe","\u8003\u67e5","\u521d\u4fee","90.00","2.5","4.0","10.00"],["\u57fa\u7840\u6cf0\u8bedI","3.5","\u4e13\u4e1a\u8bfe\/\u9650\u9009\u8bfe","\u7406\u8bba\u8bfe","\u8003\u8bd5","\u521d\u4fee","86.00","3.5","3.6","12.60"],["\u519b\u4e8b\u8bfe","3.5","\u516c\u5171\u8bfe\/\u4efb\u9009\u8bfe","","\u8003\u67e5","\u521d\u4fee","79.00","3.5","2.9","10.15"],["\u79d1\u5b66\u6280\u672f\u4e0e\u6587\u660e\u53ca\u4eba\u7c7b\u7684\u672a\u6765","1.0","\u901a\u8bc6\u8bfe\/\u4efb\u9009\u8bfe","","\u8003\u67e5","\u521d\u4fee","86.00","1.0","3.6","3.60"],["\u5e78\u798f\u5fc3\u7406\u5b66","1.0","\u901a\u8bc6\u8bfe\/\u4efb\u9009\u8bfe","","\u8003\u67e5","\u521d\u4fee","89.00","1.0","3.9","3.90"],["\u9ad8\u7b49\u6570\u5b66D2","4.0","\u5b66\u79d1\u57fa\u7840\u8bfe\/\u975e\u5b66\u4f4d\u8bfe","","\u8003\u8bd5","\u521d\u4fee","72.00","4.0","2.2","8.80"]]}}</pre>

<div class="page-header">
    <h3>
        获取等级考试报名情况及成绩
        <small>
        <a href="<%= $this->createUrl('/proxy/api/rankExam'); %>">
            <%= $this->createUrl('/proxy/api/rankExam'); %>
        </a>
        </small>
    </h3>
</div>

<pre class="example">$ curl -i -b PHPSESSID=nllta4f4uhiloujcibkru803v0 <%= $this->createFullUrl('/proxy/api/scores'); %>

HTTP/1.1 200 OK
Server: nginx/1.4.1 (Ubuntu)
Date: Sun, 01 Dec 2013 07:44:05 GMT
Content-Type: text/html
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/5.5.3-1ubuntu2
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache

{"form":{"thead":["\u7b49\u7ea7","\u6784\u6210","\u8003\u8bd5\u5e74\u6708","\u6536\u8d39\u6807\u51c6\uff08\u5143\uff09","\u62a5\u540d\u65f6\u95f4\u533a\u6bb5","\u9650\u5b9a\u540d\u989d","\u5269\u4f59\u540d\u989d","\u72b6\u6001","\u64cd\u4f5c"],"tbody":{"\u5168\u56fd\u5927\u5b66\u82f1\u8bed\u7b49\u7ea7\u8003\u8bd5":[{"0":"CET-4","1":"\u7406\u8bba\u6210\u7ee9","2":"2013\u5e7412\u6708","3":"28.00","4":"2013-09-04 09:00 - 2013-09-15 23:00","5":"5500","6":"14","7":"\u5df2\u6279\u51c6\u5df2\u4ea4\u8d39","8":"","id":"T1"},{"0":"CET-6","1":"\u7406\u8bba\u6210\u7ee9","2":"2013\u5e7412\u6708","3":"30.00","4":"2013-09-04 09:00 - 2013-09-15 23:00","5":"3500","6":"800","7":"","8":"","id":"T2"}],"\u5168\u56fd\u9ad8\u6821\u8ba1\u7b97\u673a\u8054\u5408\u8003\u8bd5\uff08\u5e7f\u897f\u8003\u533a\uff09":[{"0":"\u4e00\u7ea7WINDOWS","1":"\u7406\u8bba\u6210\u7ee9\u64cd\u4f5c\u6210\u7ee9","2":"2013\u5e7412\u6708","3":"18.00","4":"2013-11-13 11:28 - 2013-11-21 15:00","5":"3000","6":"1029","7":"","8":"\u62a5\u540d","id":"T3"},{"0":"\u4e8c\u7ea7C","1":"\u7406\u8bba\u6210\u7ee9","2":"2013\u5e7412\u6708","3":"18.00","4":"2013-11-13 11:45 - 2013-11-18 11:45","5":"500","6":"484","7":"","8":"","id":"T4"},{"0":"\u4e8c\u7ea7ACCESS","1":"\u7406\u8bba\u6210\u7ee9","2":"2013\u5e7412\u6708","3":"18.00","4":"2013-11-13 11:44 - 2013-11-18 11:44","5":"200","6":"192","7":"","8":"","id":"T5"},{"0":"\u4e8c\u7ea7VB.net","1":"\u7406\u8bba\u6210\u7ee9","2":"2013\u5e7412\u6708","3":"18.00","4":"2013-11-13 11:46 - 2013-11-20 18:00","5":"500","6":"490","7":"","8":"\u62a5\u540d","id":"T6"}]}},"score":{"thead":["\u7b49\u7ea7","\u8003\u8bd5\u5e74\u6708","\u7406\u8bba\u6210\u7ee9","\u64cd\u4f5c\u6210\u7ee9","\u7efc\u5408\u6210\u7ee9"],"tbody":{"\u7c7b\u522b\uff1a\u5168\u56fd\u9ad8\u6821\u8ba1\u7b97\u673a\u8054\u5408\u8003\u8bd5\uff08\u5e7f\u897f\u8003\u533a\uff09":[["\u4e00\u7ea7WINDOWS","2013\u5e7406\u6708","85.00","97.00","91.00"]]}}}</pre>
