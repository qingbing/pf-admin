<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;
use Admin\Components\Pub;
use Admin\Models\HeaderCategory;
use DbSupports\Builder\Criteria;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 */
class HeaderCateController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var string nav标记 */
    public $navFlag = 'setting';

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
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
     * 默认action:表头配置列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $criteria = new Criteria();
        $criteria->setOrder('`sort_order` ASC');
        $criteria->addWhere('`is_open`=:is_open')
            ->addParam(':is_open', 1);
        if (isset($fixer['keyword']) && '' !== $fixer['keyword']) {
            $criteria->addWhereLike('name', $fixer['keyword']);
        }

        // 模型分页查询
        $pager = (new HeaderCategory())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('表头配置列表');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 查看表头类型信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看表头类型信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 获取操作表头
     * @return \Abstracts\DbModel|HeaderCategory|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = HeaderCategory::model()->findByPk($this->getActionParam('key'));
        /* @var HeaderCategory $model */
        if (null === $model) {
            $this->throwHttpException(404, '表头不存在');
        }
        if (!$model->is_open) {
            $this->throwHttpException(403, '对不起，您无权操作该内容');
        }
        return $model;
    }
}