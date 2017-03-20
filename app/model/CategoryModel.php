<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/1/15
 * Time: 22:54
 */

namespace app\model;

use core\Model;

class CategoryModel extends  Model
{
    protected $table = 'category';

    public function limitlessLevelCategory($categorys, $level = 0, $parentId = 0)
    {
        static $limitlessLevelCategorys = array();
        // 从$categorys数组找出所有的顶级分类的分类
        foreach ($categorys as $category) {
            if ($category['parent_id'] == $parentId) {
                $category['level'] = $level;
                $limitlessLevelCategorys[] = $category;
                // 无限级分类核心代码
                // 找儿子
                $this->limitlessLevelCategory($categorys, $level + 1, $category['id']);
            }
        }
        return $limitlessLevelCategorys;
    }

    //连接查询查询出所有的分类
    public function getAllWithJoin()
    {
        $sql = "SELECT category.*, count(article.id) AS count
                  FROM category
                  LEFT JOIN article ON category.id=article.category_id
                  GROUP BY category.id";
        return $this->getAll($sql);
    }
}