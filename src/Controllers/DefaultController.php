<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Admin\Components\Controller;
use Admin\Components\Pub;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 */
class DefaultController extends Controller
{
    /* @var string nav标记 */
    public $navFlag = 'home';

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $this->redirect(['/Contact/index']);
    }

    /**
     * @throws \Exception
     */
    public function actionError()
    {
        $this->layout = '/layouts/html';
        if (APP_DEBUG) {
            var_dump(Pub::getApp()->getErrorHandler()->getError());
        } else if ($error = Pub::getApp()->getErrorHandler()->getError()) {
            if (Pub::getApp()->getRequest()->getIsAjaxRequest()) {
                echo $error['message'];
            } else {
                $this->render('error', [
                    'error' => $error,
                ]);
            }
        }
    }
}