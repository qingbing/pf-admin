<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;
use Admin\Components\Pub;
use Admin\Models\FormCategory;
use DbSupports\Builder\Criteria;
use Helper\HttpException;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-11
 * Version      :   1.0
 */
class FormCateController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws HttpException
     * @throws \Helper\Exception
     */
    protected function beforeAction($action)
    {
        if (!Pub::getUser()->getIsSuper()) {
            $this->throwHttpException(403, '对不起，您无权操作该模块');
        }
        return true;
    }

    /**
     * 默认action ： 表单配置列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $criteria = new Criteria();
        $criteria->addWhere('`is_open`=:is_open AND `is_enable`=:is_enable AND `is_setting`=:is_setting')
            ->addParam(':is_open', 1)
            ->addParam(':is_enable', 1)
            ->addParam(':is_setting', 0)
            ->setOrder('`sort_order` ASC');
        if (isset($fixer['keyword']) && '' !== $fixer['keyword']) {
            $criteria->addWhereLike('`name`', $fixer['keyword']);
        }

        // 模型分页查询
        $pager = (new FormCategory())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('表单配置列表');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 查看表单类型信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看表单类型信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 获取操作表单
     * @return \Abstracts\DbModel|FormCategory|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = FormCategory::model()->findByPk($this->getActionParam('key'));
        /* @var FormCategory $model */
        if (null === $model) {
            $this->throwHttpException(404, '表单不存在');
        }
        if (!$model->is_open) {
            $this->throwHttpException(403, '对不起，您无权操作该内容');
        }
        return $model;
    }
}