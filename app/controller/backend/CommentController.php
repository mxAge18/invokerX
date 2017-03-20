<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/1/26
 * Time: 10:53
 */

namespace app\controller\backend;


use app\model\CommentModel;
use core\Controller;

class CommentController extends Controller
{
    public function getList()
    {
        $this->denyAccessOfAdmin();
        $comments = CommentModel::create()->getAllWithJoin();
        $this->loadHtml('getList', array(
            'comments' => $comments,
        ));
    }

    public function delete()
    {
        $this->denyAccessOfAdmin();
        $id = $_GET['id'];
        if(CommentModel::create()->deleteById()) {
            return $this->redirect('index.php?p=backend&c=Comment&a=getList', '删除成功');
        } else {
            return $this->redirect('index.php?p=backend&c=Comment&a=getList', '删除失败');
        }
    }
}