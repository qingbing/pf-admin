<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Components;


use Abstracts\OperateLog;

class Log extends OperateLog
{
    /* @var string 数据表名 */
    protected $tableName = 'admin_operate_log';

    /**
     * 必要的初始化操作
     * @throws \Helper\Exception
     */
    public function init()
    {
        parent::init();
        $this->user = Pub::getUser();
    }

    const OPERATE_TYPE_LOGIN = 'login';
    const OPERATE_TYPE_PERSONAL = 'personal';
    const OPERATE_TYPE_MATE = 'mate';
    const OPERATE_TYPE_TABLE_HEADER = 'table-header';
    const OPERATE_TYPE_FORM_SETTING = 'form-setting';
    const OPERATE_TYPE_REPLACE_SETTING = 'replace-setting';
    const OPERATE_TYPE_NAV = 'nav';
    const OPERATE_TYPE_BLOCK = 'block';
    const OPERATE_TYPE_STATIC_CONTENT = 'static-content';
    const OPERATE_TYPE_NOTICE = 'notice';
    const OPERATE_TYPE_HELPER_CENTER = 'helper-center';

    // todo doing
    // todo
    const OPERATE_TYPE_ACCESS = 'access';


    private static $_types = [
        self::OPERATE_TYPE_LOGIN => '登录日志',
        self::OPERATE_TYPE_PERSONAL => '个人日志',
        self::OPERATE_TYPE_MATE => '管理员管理',
        self::OPERATE_TYPE_TABLE_HEADER => '表头设置',
        self::OPERATE_TYPE_FORM_SETTING => '表单配置',
        self::OPERATE_TYPE_REPLACE_SETTING => '替换模板',
        self::OPERATE_TYPE_NAV => '导航管理',
        self::OPERATE_TYPE_BLOCK => '区块管理',
        self::OPERATE_TYPE_STATIC_CONTENT => '静态内容',
        self::OPERATE_TYPE_NOTICE => '公告管理',
        self::OPERATE_TYPE_HELPER_CENTER => '帮助中心',

        self::OPERATE_TYPE_ACCESS => '权限控制',
    ];

    /**
     * 添加一种日志类型
     * @param $flag
     * @param $label
     */
    static public function addType($flag, $label)
    {
        self::$_types[$flag] = $label;
    }

    /**
     * 是或否
     * @param bool|false $withAll
     * @return array
     */
    static public function type($withAll = false)
    {
        if (!$withAll) {
            return self::$_types;
        }
        return array_merge([
            '' => '全部',
        ], self::$_types);
    }
}