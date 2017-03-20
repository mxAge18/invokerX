<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/3/3
 * Time: 11:48
 */

namespace app\controller\frontend;


use core\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->denyAccess();
        $this->loadHtml('index');
    }

    public function header()
    {
        $this->denyAccess();
        $this->loadHtml('header');
    }
    public function menu()
    {
        $this->denyAccess();
        $this->loadHtml( 'menu');
    }
    public function content()
    {
        $this->denyAccess();
        $this->loadHtml( 'content');
    }
}