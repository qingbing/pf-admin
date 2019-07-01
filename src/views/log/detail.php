<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Log;
use Helper\Format;
use Tools\Labels;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var array $log
 */
// 操作日志类型
$logTypes = Log::type();
?>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>ID</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo $log['id']; ?></dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>日志类型</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo Format::dataValue($log['type'], $logTypes); ?></dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>关键字</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo $log['keyword']; ?></dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>消息</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo $log['message']; ?></dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>数据内容</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static">
        <pre><?php var_export(json_decode($log['data'], true)); ?></pre>
    </dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>是否成功</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo Labels::YesNo($log['is_success']); ?></dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>操作UID</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo $log['op_uid']; ?></dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>操作用户</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo $log['op_username']; ?></dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>操作IP</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo $log['op_ip']; ?></dd>
</dl>
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>操作时间</label>:</dt>
    <dd class="col-md-9 col-sm-9 col-lg-9 form-control-static"><?php echo $log['created_at']; ?></dd>
</dl>

<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>