<?php

namespace app\controller\backend;


class IndexController extends \core\Controller
{
    public function index()
    {
       $this->denyAccessOfAdmin();
       $this->loadHtml('index');
    }

}