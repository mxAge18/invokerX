<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/1/15
 * Time: 16:27
 */

namespace app\controller\backend;


use core\Controller;
use app\model\CategoryModel;

class CategoryController extends Controller
{

    public function add()
    {
        $this->denyAccessOfAdmin();
        if($_POST) {
            //分类数据插入mysql
            $data = array(
                'name' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'sort' => $_POST['Order'],
                'parent_id' => $_POST['ParentID'],
            );
            if(CategoryModel::create()->add($data)) {
                $this->redirect('index.php?p=backend&c=Category&a=getList','创建成功');
            } else {
                $this->redirect('index.php?p=backend&c=Category&a=add','创建失败');
            }
        } else {
            //返回添加表单
            $categorys = CategoryModel::create()->limitlessLevelCategory(CategoryModel::create()->findAll());
            $this->loadHtml('add', array(
                'categorys' => $categorys,
            ));
        }
    }

    /*public function getList()
    {
        $this->denyAccess();
        $categorys = CategoryModel::create()
            ->limitlessLevelCategory(
                CategoryModel::create()->getAllWithJoin()
            );
        $this->loadHtml('getList',array(
            'categorys' => $categorys,
        ));
    }*/
    public function getList()
    {
        $this->denyAccessOfAdmin();
        // 查询出所有的分类
        $categorys = CategoryModel::create()
            ->limitlessLevelCategory(
                CategoryModel::create()->getAllWithJoin()
            );
        // 在html里显示
        $this->loadHtml('getList', array(
            'categorys' => $categorys,
        ));
    }

    public function update()
    {
        $this->denyAccessOfAdmin();
        $id = $_GET['id'];
        if ($_POST) {
            $data = array(
                'name' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'sort' => $_POST['Order'],
                'parent_id' => $_POST['ParentID'],
            );
            if (CategoryModel::create()->updateById($id, $data)) {
                $this->redirect('index.php?p=backend&c=Category&a=getList','修改成功');
            } else {
                $this->redirect('index.php?p=backend&c=Category&a=update&id={$id}','修改成功');
            }
        } else {
            $categorys =CategoryModel::create()->limitlessLevelCategory(CategoryModel::create()->findAll('2 > 1','sort DESC'));
            $category =CategoryModel::create()->findOneById($id);
            $this->loadHtml('update',array(
                'category' => $category,
                'categorys' => $categorys,
            ));
        }
    }

    public function delete()
    {
        $this->denyAccessOfAdmin();
        $id = $_GET['id'];
        if (CategoryModel::create()->count("parent_id='{$id}'") > 0 ) {
            return $this->redirect('index.php?p=backend&c=Category&a=getList','禁止删除');
            //exit(0);
        }
        if (CategoryModel::create()->deleteById($id)) {
            $this->redirect('index.php?p=backend&c=Category&a=getList','成功');
        } else {
            $this->redirect('index.php?p=backend&c=Category&a=getList','删除失败');
        }
    }
}