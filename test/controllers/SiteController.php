<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-02-24
 * Version      :   1.0
 */

namespace Controllers;


use Render\Abstracts\Controller;
use Tools\FormSetting;

class SiteController extends Controller
{
    /**
     * 模块测试，直接转向到 admin 模块
     * @throws \Exception
     */
    public function actionIndex()
    {
        $this->redirect(['//admin']);
    }

    /**
     * 错误或异常处理
     * @throws \Helper\Exception
     */
    public function actionError()
    {
        var_dump($this->app->getErrorHandler());
    }

    /**
     * @throws \Helper\Exception
     */
    public function actionTest()
    {
        $model = FormSetting::cache('site_config');
        $model = FormSetting::cache('mail_config');
        var_dump($model->charset);
//        var_dump($model->field_email);
//        var_dump($model->field_date);
//        var_dump($model->attributeNames());
//        var_dump($model->attributeLabels());
//        var_dump($model->attributes);

        $this->layout = false;
        $this->render('test', [
            'model' => $model,
        ]);
    }
}