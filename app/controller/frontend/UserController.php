<?php

namespace app\controller\frontend;

use app\model\FrontModel;
use vendor\Captcha;
use core\Model;

class UserController extends \core\Controller
{
    public function register()
    {
        $frontModel = FrontModel::create();
        if(!empty($_POST)) {
            $data = array (
                'username' => $_POST['Uname'],
                'nickname' => $_POST['Nickname'],
                'email' => $_POST['Email'],
                'last_login_at' => time(),
                'password' => md5($_POST['Password']),
                'role_id' => '1',
            );
            if ($frontModel->add($data)) {
                $this->redirect('index.php?p=frontend&c=User&a=login','success');
            } else {
                $this->redirect('index.php?p=frontend&c=User&a=register','failed');
            }
        } else {
            $this->loadHtml('register');
        }
    }

    //普通用户登录方法
    public function login()
    {
        //判断是否提交
        if ($_POST) {
            //判断验证码是否正确
            if ($_POST['edtCaptcha'] != $_SESSION['capthchaCode']) {
                $this->redirect('index.php?p=frontend&c=User&a=login','验证码错误');
                exit(0);
            }
            //实例化前台用户模型
            $frontModel = FrontModel::create();
            //post数据与数据库数据比对
            $_POST['username'] = addslashes($_POST['username']);
            $user = $frontModel->findOneBy("password='{$_POST['password']}' AND username='{$_POST['username']}'");
            if (!empty($user)) {
                //成功，进入前台个人中心
                $_SESSION['loginFlag'] = true;
                $_SESSION['publicUser'] = $user;
                $_SESSION['loginTime'] = time();
                $this->redirect('index.php?p=frontend&c=Index&a=index', '登录成功');
            } else {
                // failed 返回登录页面
                $_SESSION['loginFlag'] = false;
                $this->redirect('index.php?p=frontend&c=User&a=login', '登录失败');
            }
        } else {
            $this->loadHtml('login');
        }
    }

    //普通用户退出
    public function logout()
    {
        $_SESSION['loginFlag'] =false;
        unset($_SESSION['publicUser']);
        $this->redirect('index.php?p=backend&c=User&a=login','退出成功');
    }

    public function captcha()
    {
        $c = new Captcha();
        $c->generateCode();
        $_SESSION['capthchaCode'] = $c->getCode();
    }
}
?>
