<?php
namespace core;

class Application
{
    public static $config;
    public static function run()
    {
        //开启session
        self::_startSession();
        //初始化字符集
        self::_initialCharset();

        //设定php的错误显示和错误级别
        self::_setPhpErrorDisplayAndErrorReport();

        //定义目录常量
        self::_defineDirConst();

        //配置文件的载入
        self::_loadConfigFile();

        //解析url参数（路由参数）
        self::_parseUrlParams();

        //注册自动加载
        self::_registerAutoload();

        //分发路由
        self::_dispatchRoute();
    }

    //开启session
    protected static function _startSession()
    {
        session_start();
    }

    public static function _loadConfigFile()
    {
        require CONFIG_PATH . DS . 'config.php';
        self::$config = $config;
    }

    //初始化字符集
    protected static function _initialCharset()
    {
        header('Content-Type: text/html;charset=utf-8');
    }

    //设置php的错误显示和错误级别 error_reproting display_errors
    protected static function _setPhpErrorDisplayAndErrorReport()
    {
        //修改php配置，只在当前请求中有效
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
    }

    //定义常用的目录常量
    protected static function _defineDirConst()
    {
        //定义目录分隔符
        define('DS', DIRECTORY_SEPARATOR);
        //定义项目根目录
        define('ROOT_PATH', dirname(__DIR__));
        //应用目录（app）
        define('APP_PATH', ROOT_PATH . DS . 'app');
        //视图目录
        define('VIEW_PATH', APP_PATH . DS . 'view');
        //配置文件目录
        define('CONFIG_PATH' ,APP_PATH . DS . 'config');
    }

    //解析url参数的参数
    protected static function _parseUrlParams()
    {
        //p a c
        $p = isset($_GET['p']) ? $_GET['p'] : self::$config['defaultPlatform'];
        $a = isset($_GET['a']) ? $_GET['a'] : self::$config['defaultAction'];
        $c = isset($_GET['c']) ? $_GET['c'] : self::$config['defaultController'];
        define('PLATFORM', $p);
        define('ACTION', $a);
        define('CONTROLLER', $c);
    }

    //注册自动加载
    protected static function _registerAutoload()
    {
        spl_autoload_register(function($className) {
            $fileName = ROOT_PATH . DS . str_replace('\\', '/', $className) . '.php';
            if (is_file($fileName)) {
                require $fileName;
            }
        });
    }

    //分发路由的函数
    protected static function _dispatchRoute()
    {
        $a = ACTION;
        $c = '\\app\\controller\\' .PLATFORM . "\\" . CONTROLLER . 'Controller';
        $ctrl = new $c();
        $ctrl->$a();
    }
}