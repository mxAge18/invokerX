<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/8
 * Time: 13:49
 */

namespace app\controller\frontend;


use core\Controller;
use app\model\CommentModel;

class CommentController extends Controller
{
    public function add()
    {
        /*var_dump($_POST);die;*/
        $this->denyAccess();
        $userId = empty($_SESSION['user']['id']) ? $_SESSION['user']['id']:$_SESSION['publiUser']['id'];
        $articleId = $_GET['article_id'];
        $parentId = $_POST['inpRevID'];
        $content = $_POST['txaArticle'];
        $publishTime = time();

        if (CommentModel::create()->add(array(
            'user_id' => $userId,
            'article_id' => $articleId,
            'parent_id' => $parentId,
            'content' => $content,
            'publish_time' => $publishTime,
        ))) {
            $this->redirect("index.php?p=frontend&c=Article&a=detail&id={$articleId}","评论添加成功");
        } else {
            $this->redirect("index.php?p=frontend&c=Article&a=detail&id={$articleId}","评论添加失败");
        }
    }
}