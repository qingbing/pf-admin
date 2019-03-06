
CREATE TABLE IF NOT EXISTS `admin_operate_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `type` VARCHAR (20) DEFAULT NULL COMMENT '操作类型-用字符串描述',
  `keyword` VARCHAR (100) DEFAULT NULL COMMENT '关键字，用于后期筛选',
  `message` VARCHAR (150) DEFAULT NULL COMMENT '操作消息',
  `data` text DEFAULT NULL COMMENT '操作的具体内容',
  `is_success` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否执行成功',

  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `username` varchar(20) DEFAULT NULL COMMENT '用户名',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '登录IP',
  `db_time` datetime DEFAULT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`),
  KEY (`type`),
  KEY (`uid`),
  KEY (`db_time`),
  KEY (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='admin 后台管理员操作日志表';