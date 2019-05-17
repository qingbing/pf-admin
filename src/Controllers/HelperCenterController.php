<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Admin\Components\Controller;
use Admin\Components\Log;
use Admin\Components\Pub;
use Admin\Models\HelperCenter;
use DbSupports\Builder\Criteria;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-15
 * Version      :   1.0
 */
class HelperCenterController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_HELPER_CENTER;
    /* @var int 帮助中心 ParentID */
    protected $parentId;
    /* @var HelperCenter 父帮助中心 */
    protected $parent;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws \Exception
     */
    protected function beforeAction($action)
    {
        // 只有超管有权限
        if (!Pub::getUser()->getIsSuper()) {
            $this->throwHttpException(403, '对不起，您无权操作该内容');
        }
        $this->parentId = $this->getActionParam('parentId', 0);
        if (0 != $this->parentId) {
            $this->parent = HelperCenter::model()->findByPk($this->parentId);
            if (null === $this->parent) {
                $this->throwHttpException(404, '不存在的父级帮助中心');
            } else if (1 != $this->parent->is_category) {
                // 不是分类导航，不能添加操作子项
                $this->throwHttpException(403, '帮助中心操作越权');
            }
        }
        return true;
    }

    /**
     * 默认action
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $models = $this->findAll();
        // 设置页面标题
        if (0 == $this->parentId) {
            $this->setPageTitle('帮助中心');
        } else {
            $this->setPageTitle("帮助中心({$this->parent->subject})");
        }
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'parentId' => $this->parentId,
            'models' => $models,
        ]);
    }

    /**
     * 添加帮助中心
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new HelperCenter();
        // 表单提交处理
        if (isset($_POST['HelperCenter'])) {
            $model->setAttributes($_POST['HelperCenter']);
            $model->parent_id = $this->parentId;
            $this->logMessage = '添加帮助中心主题';
            if ($model->save()) {
                $this->logKeyword = $model->id;
                $this->logData = $model->getAttributes();
                $this->success('添加帮助中心主题成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        // 设置页面标题
        if (0 == $this->parentId) {
            $this->setPageTitle('添加帮助中心主题');
        } else {
            $this->setPageTitle("添加帮助中心主题({$this->parent->subject})");
        }
        // 渲染页面
        $this->render('add', [
            'parentId' => $this->parentId,
            'model' => $model,
        ]);
    }

    /**
     * 编辑帮助中心主题
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        $fixer = $this->getActionParams();
        unset($fixer['parentId']);
        unset($fixer['id']);
        $model->setAttributes($fixer);
        $this->logMessage = '修改表头选项';
        $this->logKeyword = $model->id;
        if ($model->save()) {
            $this->logData = $this->getActionParams();
            $this->success('编辑表头选项成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 编辑帮助中心主题
     * @throws \Exception
     */
    public function actionEditDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['HelperCenter'])) {
            $model->setAttributes($_POST['HelperCenter']);
            $this->logMessage = '编辑帮助中心主题';
            $this->logKeyword = $model->subject;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑帮助中心主题成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑帮助中心主题');
        // 渲染页面
        $this->render('edit_detail', [
            'model' => $model,
        ]);
    }

    /**
     * 查看区块类型信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看帮助中心主题信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 删除帮助中心
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除帮助中心';
        $this->logKeyword = $model->subject;
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除帮助中心成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 帮助中心顺序调整
     * @throws \Exception
     */
    public function actionUpDown()
    {
        // 参数获取
        $fixer = $this->getActionParams();
        $res = $this->findAll();
        $models = [];
        foreach ($res as $re) {
            array_push($models, $re);
        }
        $current = $switch = null;
        while (true) {
            $model = current($models);
            if (!$model) {
                break;
            }
            if ($model->id == $fixer['id']) {
                $current = $model;
                if ('up' === $fixer['sort_order']) {
                    $switch = prev($models);
                } else {
                    $switch = next($models);
                }
                break;
            }
            next($models);
        }
        reset($models);
        if (!$switch) {
            $this->failure('没有可以交换顺序的数据');
        }

        $current_sort_order = $current->sort_order;
        $current->sort_order = $switch->sort_order;
        $switch->sort_order = $current_sort_order;

        // 日志记录
        $this->logMessage = '帮助中心顺序调整';
        $this->logKeyword = "{$current->id} - {$switch->id}";
        $this->logData = [
            'current' => $current->getAttributes(),
            'switch' => $switch->getAttributes(),
        ];
        if ($current->save() && $switch->save()) {
            $this->success('帮助中心顺序调整成功');
        } else {
            $this->failure('帮助中心顺序调整失败');
        }
    }

    /**
     * 刷新排序
     * @throws \Exception
     */
    public function actionRefreshSortOrder()
    {
        // 获取数据
        $models = $this->findAll();
        $i = 0;
        $this->logMessage = '帮助中心顺序刷新';
        $this->logKeyword = "{$this->parent->id}";
        $transaction = \PF::app()->getDb()->beginTransaction();
        foreach ($models as $model) {
            $model->sort_order = ++$i;
            if (!$model->save()) {
                $transaction->rollback();
                $this->failure('', $model->getErrors());
            }
        }
        $transaction->commit();
        $this->success('帮助中心顺序刷新成功');
    }

    /**
     * 获取操作模型
     * @return \Abstracts\DbModel|HelperCenter|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = HelperCenter::model()->findByPk($this->getActionParam('id'));
        /* @var HelperCenter $model */
        if (null === $model) {
            $this->throwHttpException(404, '帮助中心主题不存在');
        }
        return $model;
    }


    /**
     * 查找分类下的子主题
     * @return \Abstracts\DbModel[]|HelperCenter[]|null
     * @throws \Exception
     */
    protected function findAll()
    {
        $criteria = new Criteria();
        $criteria->setWhere('`parent_id`=:parent_id')
            ->addParam(':parent_id', $this->parentId)
            ->setOrder('`sort_order` ASC');
        return HelperCenter::model()->findAll($criteria);
    }

    /**
     * 验证帮助中心代码的唯一性
     * @throws \Exception
     */
    public function actionUniqueCode()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        if (empty($fixer['param'])) {
            $this->success("引用代码\"{$fixer['param']}\"可用");
        }
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`code`=:code')
            ->addParam(':code', $fixer['param']);
        if (isset($fixer['id']) && $fixer['id']) {
            $criteria->addWhere('`id`!=:id')
                ->addParam(':id', $fixer['id']);
        }
        $count = HelperCenter::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("引用代码\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("引用代码\"{$fixer['param']}\"可用");
        }
    }
}