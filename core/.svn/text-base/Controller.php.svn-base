<?php

namespace core;

use vendor\Smarty;

//核心控制器
class Controller
{
    protected $s;

    protected function initSmarty()
    {
        $s = new Smarty();

        // Smarty设置左右定界符
        $s->left_delimiter = '<{';
        $s->right_delimiter = '}>';
        // templates目录改为view，默认模板目录修改
        $s->setTemplateDir(VIEW_PATH);
        // 自定义编译文件目录,将文件放在临时目录里
        // sys_get_temp_dir();
        $s->setCompileDir(sys_get_temp_dir() . DS . 'view_c');
        // 自定义缓存
        $s->setCacheDir(sys_get_temp_dir() . DS . 'cache');
        // 自定义配置
        $s->setConfigDir(CONFIG_PATH);
        $this->s = $s;
    }

    public function __construct()
    {
        $this->initSmarty();

    }

    protected function denyAccessOfAdmin()
    {
        if (isset($_SESSION['loginFlag']) && ($_SESSION['loginFlag'] == true) && isset($_SESSION['user'])) {

        } else {
            $this->redirect('index.php?p=backend&c=User&a=login','请登录你的管理员账号！');
            exit(0);
        }
    }
    protected function denyAccess()
    {
        if (isset($_SESSION['loginFlag']) && ($_SESSION['loginFlag'] == true) && (isset($_SESSION['publicUser']) | isset($_SESSION['user']))) {

        } else {
            $this->redirect('index.php?p=frontend&c=User&a=login','请登录你的个人账号！');
            exit(0);
        }
    }


    protected function loadHtml($name, $data = array())
    {
        /*$data = array(
            'users' => $users,
        );*/
        foreach($data as $variableName => $variableValue) {
            $$variableName = $variableValue;
        }
        require VIEW_PATH . DS . PLATFORM . DS . strtolower(CONTROLLER) . DS . $name . '.html';
    }
    public function redirect($url, $msg='', $waitSeconds = 3)
    {
        echo $msg;
        header("Refresh:" . $waitSeconds . "; url=" . $url);
        exit();
    }
}
