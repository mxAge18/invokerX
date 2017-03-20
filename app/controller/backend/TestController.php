<?php

namespace app\controller\backend;

use app\model\TestModel;

class TestController extends \core\Controller
{
    public function show()
    {
        $o = new \app\model\TestModel();
        $o->run();
        echo "感觉今天萌萌哒";
        $this->redirect('http://www.baidu.com');
    }
}