广西民族大学教务系统代理
========================

[http://xsh.gxun.edu.cn/ams/](http://xsh.gxun.edu.cn/ams/)

生成sqlite数据库文件
----

> 可以参考`data/Makefile`
>
> 或者直接运行下面命令`amsProxy.db`生成文件

```shell
cd data
make
```

配置nginx
----

请参考Yii官方文档
http://www.yiiframework.com/doc/guide/1.1/en/quickstart.apache-nginx-config

启动文件 `public/index.php`

配制config.php
----

params 的配制

### baseUrl
学校的url

### schoolcode
青果用于验证请求真实性.  
每个学校的`schoolcode`都不一样.  

**可以通过查看学校ams页面源代码, 查看自己学校的`schoolcode`是多少.**

### superAdmin
超级管理员, 用于添加和删除一般管理员.
