
-- --------------------------------------------------------

--
-- 表的结构 `pub_notice`
--

CREATE TABLE IF NOT EXISTS `pub_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `subject` varchar(100) NOT NULL COMMENT '主题',
  `keywords` varchar(100) DEFAULT NULL COMMENT 'seo的keywords',
  `description` varchar(255) DEFAULT NULL COMMENT 'seo的description',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `content` text COMMENT '内容',
  `x_flag` varchar(20) DEFAULT NULL COMMENT '编辑器标志',

  `read_times` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `is_publish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布',
  `publish_time` datetime NOT NULL COMMENT '发布时间',
  `expire_time` datetime NOT NULL DEFAULT '2100-01-01 23:59:59' COMMENT '有效时间',

  `create_time` datetime NOT NULL COMMENT '创建时间',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '更新IP',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `subject` (`subject`),
  KEY `sort_order` (`sort_order`),
  KEY `read_times` (`read_times`),
  KEY `is_publish` (`is_publish`),
  KEY `publish_time` (`publish_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='公告管理表';
