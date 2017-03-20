<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/1/17
 * Time: 20:51
 */

namespace app\controller\backend;


use app\model\ArticleModel;
use app\model\CategoryModel;
use core\Controller;
use vendor\Pager;
class ArticleController extends Controller
{
    public function add()
    {
        if ($_POST) {
            $this->denyAccessOfAdmin();
            $date = array(
                'title' =>$_POST['Title'],
                'content' => $_POST['Content'],
                'category_id' => $_POST['CateID'],
                'status' => $_POST['Status'],
                'published_date' => strtotime($_POST['PostTime']),
                'top' => isset($_POST['isTop']) ? $_POST['isTop'] : 2,
                'author_id' => $_SESSION['user']['id'],
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

    public function delete()
    {
            $this->denyAccessOfAdmin();
            $articleModel = ArticleModel::create();
            $id = $_GET['id'];
        if($articleModel->deleteById($id)) {
            $this->redirect('index.php?p=backend&c=Article&a=getList','删除成功');
        } else {
            $this->redirect('index.php?p=backend&c=Article&a=getList','删除失败，3秒回列表页');
        }
    }

    public function getList()
    {
        $this->denyAccessOfAdmin();
        $where = '2 > 1';
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
        $pageSize = 10;
        $pager = new Pager(ArticleModel::create()->count(), $pageSize, $page, 'index.php', array(
            'p' => 'backend',
            'c' => 'Article',
            'a' => 'getList',
        ));
        $pageButtons = $pager->showPage();
        $start = ($page - 1) * $pageSize;
        $articles = ArticleModel::create()->getAllWithJoin($where, 'id ASC', $start, $pageSize);
        $categories = CategoryModel::create()
            ->limitlessLevelCategory(
                CategoryModel::create()->findAll()
            );
        $this->loadHtml('getList', array(
            'articles' => $articles,
            'categories' => $categories,
            'pageButtons' => $pageButtons,
        ));
    }
    public function editArticle()
    {
        $where = '2 > 1';
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
        $pageSize = 10;
        $pager = new Pager(ArticleModel::create()->count(), $pageSize, $page, 'index.php', array(
            'p' => 'backend',
            'c' => 'Article',
            'a' => 'editArticle',
        ));
        $pageButtons = $pager->showPage();
        $start = ($page - 1) * $pageSize;
        $articles = ArticleModel::create()->getAllWithJoin($where, 'id ASC', $start, $pageSize);
        $categories = CategoryModel::create()
            ->limitlessLevelCategory(
                CategoryModel::create()->findAll()
            );
        $this->loadHtml('editArticle', array(
            'articles' => $articles,
            'categories' => $categories,
            'pageButtons' => $pageButtons,
        ));
    }
}