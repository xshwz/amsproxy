<?php
class WechatController extends ProxyController {
    public function actionIndex() {
        $this->render('index');
    }

    public function actionBind() {
        $this->student->{$_GET['field']} = $_GET['openId'];
        $this->student->save();
        $this->information('
            <p><span class="glyphicon glyphicon-ok"></span> 绑定成功</p>
            <br>
            <ul>
                <li><p><code>帮助</code>：获取帮助</p></li>
                <li><p><code>关于</code>：“相思青果”介绍</p></li>
                <li><p><code>学籍</code>：个人学籍档案</p></li>
                <li><p><code>课表</code>：一周课程表</p></li>
                <li><p><code>课程</code>：默认返回当天课程，可带参数，比如“课程3”返回星期三的课程</p></li>
                <li><p><code>成绩</code>：默认返回最近一个学期的成绩，可带参数，比如“成绩1”返回第一个学期的成绩</p></li>
                <li><p><code>等级考试</code>：等级考试成绩</p></li>
                <li><p><code>考试安排</code>：考试安排列表</p></li>
            </ul>
            <em>
                <span class="glyphicon glyphicon-info-sign"></span>
                发送的指令不一定都能成功返回，可以多试几次。
            </em>');
    }

    public function actionUnbind() {
        $this->student->{$_GET['field']} = null;
        $this->student->save();
        $this->success('<span class="glyphicon glyphicon-ok"></span> 解除绑定成功');
    }
}
