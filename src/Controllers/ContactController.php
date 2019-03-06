<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 */
class ContactController extends Controller
{
    /**
     * 默认action
     * @throws \Helper\Exception
     */
    public function actionIndex()
    {
        // 设置页面标题
        $this->setClip('title', '联系我们');
        // 渲染页面
        $this->render('index', []);
    }
}