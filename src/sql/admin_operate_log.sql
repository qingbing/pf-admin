
CREATE TABLE IF NOT EXISTS `admin_operate_log` (
 `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
 `type` VARCHAR (32) NOT NULL DEFAULT '' COMMENT '操作类型-用字符串描述',
 `keyword` VARCHAR (100) NOT NULL DEFAULT '' COMMENT '关键字，用于后期筛选',
 `message` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '操作消息',
 `data` text COMMENT '操作的具体内容',
 `is_success` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否执行成功',
 `op_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '登录IP',
 `op_uid` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户ID',
 `op_username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
 `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
 PRIMARY KEY (`id`),
 KEY `idx_type`(`type`),
 KEY `idx_uid`(`op_uid`),
 KEY `idx_create_at`(`created_at`),
 KEY `idx_keyword`(`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='admin 后台管理员操作日志表';

