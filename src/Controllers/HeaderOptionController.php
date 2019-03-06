<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;
use Admin\Components\Log;
use Admin\Components\Pub;
use Admin\Models\HeaderCategory;
use Admin\Models\HeaderOption;
use DbSupports\Builder\Criteria;
use Helper\HttpException;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 */
class HeaderOptionController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_TABLE_HEADER;

    /**
     * @var HeaderCategory
     */
    protected $category;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws \Exception
     */
    protected function beforeAction($action)
    {
        if (!Pub::getUser()->getIsSuper()) {
            throw new HttpException('对不起，您无权操作该模块', 403);
        }
        $category = HeaderCategory::model()->findByPk($this->getActionParam('key'));
        /* @var HeaderCategory $category */
        if (null === $category) {
            throw new HttpException('表头不存在', 404);
        }
        if (!$category->is_open) {
            throw new HttpException('对不起，您无权操作该内容', 403);
        }
        $this->category = $category;
        return true;
    }

    /**
     * 默认action：表头选项列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $models = $this->findAll();
        // 设置页面标题
        $this->setPageTitle("表头选项列表：{$this->category->name}({$this->category->key})");
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'models' => $models,
            'category' => $this->category,
        ]);
    }

    /**
     * 编辑表头选项
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        $fixer = $this->getActionParams();
        unset($fixer['key']);
        unset($fixer['id']);
        $model->setAttributes($fixer);
        $this->logMessage = '修改表头选项';
        $this->logKeyword = "{$model->key}:{$model->code}";
        if ($model->save()) {
            $this->logData = $this->getActionParams();
            $this->success('编辑表头选项成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 表头选项顺序调整
     * @throws \Exception
     */
    public function actionUpDown()
    {
        // 参数获取
        $fixer = $this->getActionParams();
        $models = $this->findAll();
        $current = $switch = null;
        $passCurrent = false;
        foreach ($models as $model) {
            if ($passCurrent) {
                $switch = $model;
                break;
            }
            if ($model->id == $fixer['id']) {
                $current = $model;
                $passCurrent = true;
                if ('up' === $fixer['sort_order']) {
                    break;
                }
            }
            $switch = $model;
        }

        $current_sort_order = $current->sort_order;
        $current->sort_order = $switch->sort_order;
        $switch->sort_order = $current_sort_order;

        // 日志记录
        $this->logMessage = '表头选项顺序调整';
        $this->logKeyword = "{$current->key}:{$current->code}";
        $this->logData = [
            'current' => $current->getAttributes(),
            'switch' => $switch->getAttributes(),
        ];
        if ($current->save() && $switch->save()) {
            $this->success('表头选项顺序调整成功');
        } else {
            $this->failure('表头选项顺序调整失败');
        }
    }

    /**
     * 获取操作表头选项
     * @return \Abstracts\DbModel|HeaderOption|null
     * @throws \Exception
     * @throws HttpException
     */
    protected function getModel()
    {
        $model = HeaderOption::model()->findByPk($this->getActionParam('id'));
        /* @var HeaderOption $model */
        if (null === $model) {
            throw new HttpException('表头选项不存在', 404);
        }
        if ($model->key != $this->category->key) {
            throw new HttpException('对不起，您操作的内容参数不匹配', 403);
        }
        return $model;
    }

    /**
     * 获取表头下所有的选项
     * @return \Abstracts\DbModel[]|HeaderOption[]|null
     * @throws \Exception
     */
    protected function findAll()
    {
        // 获取数据
        $criteria = new Criteria();
        $criteria->addWhere('`key`=:key')
            ->addParam(':key', $this->category->key)
            ->setOrder('`sort_order` ASC');
        return HeaderOption::model()->findAll($criteria);
    }
}