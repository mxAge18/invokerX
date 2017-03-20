<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/7
 * Time: 20:25
 */

namespace app\controller\frontend;


use app\model\ArticleModel;
use app\model\CategoryModel;
use app\model\CommentModel;
use core\Controller;
use vendor\Pager;

class ArticleController extends Controller
{
    public function getList()
    {
        //使用:
        /*
        $pager = new Pager(总的记录数, 每页记录数, 当前页数, 'php脚本index.php', array(参数
            'a' => 'index',
            'c' => 'product',
        ));

        $pagerHtml = $pager->showPage();
        */
        //$page 当前页面
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        //每页记录数
        $pageSize = 5;
        //实例化Pager类
        $count = \app\model\ArticleModel::create()->count();
        $pager = new Pager($count, $pageSize, $page, 'index.php', array(
            'p' => 'frontend',
            'c' => 'Article',
            'a' => 'getList',
        ));
        $pageButtons = $pager->showPage();

        $where = '2 > 1';
        if ($_GET) {
            if (isset($_GET['c_id'])) {
                $where .= " AND category_id = '{$_GET['c_id']}'";
            }
        }
        if ($_POST) {
            if ($_POST['search']) {
                $where .= " AND title LIKE '%{$_POST['search']}%'";
            }
        }
        $start = ($page - 1) * $pageSize;
        $articles = ArticleModel::create()->getAllWithJoin($where, 'id DESC',$start, $pageSize);
        $categories = CategoryModel::create()->limitlessLevelCategory(
            CategoryModel::create()->findALL()
        );
        if (!isset($_SESSION['loginFlag'])) {
            $_SESSION['loginFlag'] = "";
        }
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = "";
        }
        if (!isset($_SESSION['publicUser'])) {
            $_SESSION['publicUser'] = "";
        }
        //var_dump($categories);die;
        $this->s->assign(array(
            'articles' => $articles,
            'categories' => $categories,
            'pageButtons' => $pageButtons,
        ));
        $this->s->display('frontend/article/getList.html');
    }



    public function detail()
    {
        $id = $_GET['id'];
        //访问一次，阅读数加1，在model定义该方法，controller里调用
        ArticleModel::create()->increaseReadNumber($id);
        $article = ArticleModel::create()->getOneWithJoin($id);
        $categories = CategoryModel::create()->limitlessLevelCategory(
            CategoryModel::create()->findALL());
        $comments = CommentModel::create()->limitlessLevel(
            CommentModel::create()->getAllWithJoinUserByArticleId($id)
        );
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = "";
        }
        if (!isset($_SESSION['publicUser'])) {
            $_SESSION['publicUser'] = "";
        }
        //var_dump($article);die;
        $this->s->assign(array(
            'article' => $article,
            'categories' => $categories,
            'comments' => $comments,
        ));
        $this->s->display('frontend/article/detail.html');
    }

    public function praise()
    {
        $this->denyAccess();
        $id = $_GET['id'];
        if (!isset($_SESSION["praise_$id"]) || $_SESSION["praise_$id"] != true) {
            ArticleModel::create()->increasePraiseNumber($id);
            $_SESSION["praise_$id"] = true;
            $this->redirect("index.php?p=frontend&c=Article&a=detail&id={$id}","点赞成功");
        } else {
            $this->redirect("index.php?p=frontend&c=Article&a=detail&id={$id}","不能重复点赞");
        }
        
    }

    //获取个人文章方法
    public function listArticle()
    {
        $this->denyAccess();
        $where = "author_id = '{$_SESSION['publicUser']['id']}'";
        if ($_POST) {
            if ($_POST['category']) {
                $where .= " AND category_id = '{$_POST['category']}'";
            }
            if ($_POST['status']) {
                $where .= " AND status = '{$_POST['status']}'";
            }
            if (isset($_POST['istop'])) {
                $where .= " AND top = '{$_POST['istop']}'";
            }
            if ($_POST['search']) {
                $where .= " AND title LIKE '%{$_POST['search']}%'";
            }
        }
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $pageSize = 1;
        $pager = new Pager(ArticleModel::create()->count("author_id = '{$_SESSION['publicUser']['id']}'"), $pageSize, $page, 'index.php', array(
            'p' => 'frontend',
            'c' => 'Article',
            'a' => 'listArticle',
        ));
        $pageButtons = $pager->showPage();
        $start = ($page - 1) * $pageSize;
        $articles = ArticleModel::create()->getAllWithJoin($where, 'id ASC', $start, $pageSize);
        $categories = CategoryModel::create()
            ->limitlessLevelCategory(
                CategoryModel::create()->findAll()
            );
        $this->loadHtml('listArticle', array(
            'articles' => $articles,
            'categories' => $categories,
            'pageButtons' => $pageButtons,
        ));
    }

    //个人中心写文章公共方法
    public function add()
    {
        $this->denyAccess();
        if ($_POST) {
            //$this->denyAccess();
            $date = array(
                'title' =>$_POST['Title'],
                'content' => $_POST['Content'],
                'category_id' => $_POST['CateID'],
                'status' => $_POST['Status'],
                'published_date' => strtotime($_POST['PostTime']),
                'top' => isset($_POST['isTop']) ? $_POST['isTop'] : 2,
                'author_id' => $_SESSION['publicUser']['id'],
            );
            if (ArticleModel::create()->add($date)) {
                $this->redirect('index.php?p=backend&c=Article&a=getList','添加成功');
            } else {
                $this->redirect('index.php?p=backend&c=Article&a=add','添加失败');
            }
        } else {
            $categorys = CategoryModel::create()->limitlessLevelCategory(CategoryModel::create()->findAll());
            $this->loadHtml('add', array(
                'categorys' => $categorys,
            ));
        }
    }
}