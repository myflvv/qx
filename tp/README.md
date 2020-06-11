项目基础结构 [ThinkPHP 5.1.19]
===============
克隆此项目并与开发项目同级  
修改根目录下think、public/index.php文件调用框架路径  
```/../../tp_framework/base.php``` 修改为```/../../tp_framework/base.php```

新增thinkphp/library/custom目录，存放自定义类
custom目录
~~~
├─common                通用方法类目录
│   ├─RedisLog.php      通用ELK日志静态存储方法
│   ├─BaseException.php      通用异常类
│   ├─JwtToken.php      jwt操作类
│   ├─Page.php      分页类
│   └─...   
├─lib                   扩展类目录
│   ├─RedisLib.php    redis队列、操作类 主要用于接口类传输及返回数据记录，非用户操作日志  
│   └─...
└─... 
~~~

在config目录下增加redis.php配置文件  
内容为：  
~~~
return [
    'expire'     => 0,				// 任务的过期时间
    'queue_log'    => 'api_es_log',		// 日志队列名称,用于ELK日志存储
    'host'       => getenv('REDIS_HOST'),	    // redis 主机ip
    'port'       => 6379,			// redis 端口
    'password'   => '',				// redis 密码
    'timeout'    => 0,				// redis连接的超时时间
];
~~~

##项目开发约定  
#### 模块  
模块名称使用模块名称+版本号的方式
例如：user_v1;  
项目中有前后台模块的:  
前台模块 例如：user_v1  
后台模块 例如：bg_user_v1  

#### 路由  
前台模块路由使用英文名称  例如：user  
后台模块路由使用bg作为前缀  例如：bg/user  

#### 数据库  
数据库为：cloud_platform  
建表规则：模块名称英文+功能 例如：user_log; 后台独立模块前面加admin例如：admin_user_log、admin_user 
注意表引擎myisam innodb 视情况而定，字段及表注释写清楚  

#### 注意事项  
函数、类、方法、复杂逻辑 都要写上注释，类写上@author 作者  
api接口接受及返回记录，使用RedisLog.php记录到ELK中  
通用配置例如：url地址、通用参数，统一写到config/app.php中，不要写在模块下的配置里  

=============================================  

环境变量使用getenv('name')获取，设置示例：
~~~
ES_HOST=10.10.112.195       
REDIS_HOST=10.10.112.195
CLOUD_PLATFORM_HOST=10.10.112.236
CLOUD_PLATFORM_DB=cloud_platform
CLOUD_PLATFORM_USER=root
CLOUD_PLATFORM_PASSWD=111222
~~~
