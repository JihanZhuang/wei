App
===

创建并运行一个MVC应用

案例
----

### 创建一个MVC应用

[演示:创建一个MVC应用](../../../demos/new-app)

### 提示"controller "xxx" (class "yyy") not found"的解决的方法

1. 检查类"yyy"是否存在
2. 检查类是否设置了自动加载

链接: [设置类自动加载](wei.md#设置类自动加载)

### 提示"action method "xxx" not found in controller "xxx" (class "xxx")"的解决方法

1. 检查控制器类是否存在与action名称一样的方法
2. 检查方法名称是否为`public`
3. **检查方法名称和action名称的大小写是否一致**
4. 检查方法名称是否不以下划线"_"开头

如下控制器,假设访问 http://example.com/index/index 即调用`Controller\Index`类的`index`方法.

```php
namespace Controller;

class Index extends \Wei\Base
{
    public function __construct()
    {

    }

    public function index()
    {

    }

    public function aboutUs()
    {

    }

    protected function initSomething()
    {

    }
}
```

访问以下路径均会提示action不存在.

地址                  | 原因
----------------------|------
/index/notFound       | 方法`notFound`不存在
/index/initSomething  | 方法`initSomething`不是"public"
/index/aboutus        | 方法名称大小写错误,地址应改为"/index/aboutUs"
/index/__construct    | 方法`__construct`以下划线开头,不允许访问


调用方式
--------

### 选项

名称                | 类型    | 默认值        | 说明
--------------------|---------|---------------|------
controllerFormat    | string  | Controller\%s | 控制器的类名格式,%s会被替换为类名
defaultController   | string  | index         | 默认的控制器名称
defaultAction       | string  | index         | 默认的行为名称

### 方法

#### app($options)
根据提供的选项,创建一个MVC应用,执行相应的行为方法,并输出视图数据

#### app->getController()
获取当前应用的控制器名称

#### app->setController($controller)
设置当前应用的控制器名称

#### app->getAction()
获取当前应用的行为名称

#### app->setAction($action)
设置当前应用的行为名称

#### app->getControllerClass($controller)
获取指定控制器的完整类名(不检查类名是否存在)

#### app->getDefaultTemplate()
获取当前控制器和行为对应的视图文件路径

#### app->preventPreviousDispatch()
中断当前的应用逻辑

#### app->forward($action, $controller = null)
中断当前的应用逻辑,并跳转到指定的控制器和行为

