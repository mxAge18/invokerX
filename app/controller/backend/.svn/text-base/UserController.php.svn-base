<?php

namespace app\controller\backend;


use core\Model;
use app\model\UserModel;
use vendor\Captcha;
class UserController extends \core\Controller
{
    public function add()
    {
        $this->denyAccess();
        $userModel = UserModel::create();
        if(!empty($_POST)) {
            $data = array(
              'username' => $_POST['Username'],
                'nickname' => $_POST['Nickname'],
                'email' => $_POST['Email'],
                'last_login_at' => time(),
                'password' => md5($_POST['Password']),
                'role_id' => '1',
            );
            if ($userModel->add($data)) {
                $this->redirect('index.php?p=backend&c=User&a=getList','success');
            } else {
                $this->redirect('index.php?p=backend&c=User&a=add','failed');
            }
        } else {
            $this->loadHtml('useradd');
        }
    }

    public function delete()
    {
        $this->denyAccess();
        $userModel = UserModel::create();
        $id = $_GET['id'];
        if($userModel->deleteById($id)) {
            $this->redirect('index.php?p=backend&c=User&a=getList','删除成功');
        } else {
            $this->redirect('index.php?p=backend&c=User&a=getList','删除失败，3秒回列表页');
        }
    }


    public function getList()
    {
        $this->denyAccessOfAdmin();
        $userModel = UserModel::create();
        $users = $userModel->findAll();
        $data = array(
            'users' => $users,
        );
        $this->loadHtml('userlist', $data);
    }

    public function update()
    {
        $this->denyAccessOfAdmin();
        $userModel = UserModel::create();
        $id = $_GET['id'];
        if(!empty($_POST)) {
            $data = array(
                'username' => $_POST['Username'],
                'nickname' => $_POST['Nickname'],
                'email' => str_replace('</script>', '', str_replace('<script>', '', $_POST['Email'])),
            );
            if($userModel->updateById($id,$data)) {
                $this->redirect('index.php?p=backend&c=User&a=getList','修改成功');
            } else {
                $this->redirect('index.php?p=backend&c=User&a=update&id='.$id,'修改失败');
            }
        } else {
            $user = $userModel->findOneById($id);
            $this->loadHtml('useredit',array(
                'user' => $user,
            ));
        }
    }
    public function login()
    {
        if($_POST) {
            //验证码验证
            if($_POST['edtCaptcha'] != $_SESSION['capthchaCode']) {
                $this->redirect('index.php?p=backend&c=User&a=login','验证码错误');
                exit(0);
            }
            $userModel = UserModel::create();
            $_POST['username'] = addslashes($_POST['username']);
            $user = $userModel->findOneBy("password='{$_POST['password']}' AND username='{$_POST['username']}'");
            if(!empty($user)) {
                //success 进入后台首页
                $_SESSION['loginFlag'] = true;
                $_SESSION['user'] = $user;
                $_SESSION['loginTime'] = time();
                $this->redirect('index.php?p=backend&c=Index&a=index','登录成功');
            } else {
                // failed 返回登录页面
                $_SESSION['loginFlag'] = false;
                $this->redirect('index.php?p=backend&c=User&a=login','登录失败');
            }
        }
        $this->loadHtml('login');
    }
    public function logout()
    {
        $_SESSION['loginFlag'] = false;
        $_SESSION['user'] = "";
        $this->redirect('index.php?p=frontend&c=Article&a=getList','退出成功');
    }
    public function captcha()
    {
        $c = new \vendor\Captcha();
        $c->generateCode();
        $_SESSION['capthchaCode'] = $c->getCode();
    }
}