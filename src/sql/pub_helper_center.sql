
-- --------------------------------------------------------

--
-- 表的结构 `pub_helper_center`
--

CREATE TABLE IF NOT EXISTS `pub_helper_center` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `label` varchar(30) DEFAULT NULL COMMENT '显示标签',
  `code` varchar(30) DEFAULT NULL COMMENT '引用代码',
  `subject` varchar(100) NOT NULL COMMENT '主题',
  `keywords` varchar(255) DEFAULT NULL COMMENT 'seo的keywords',
  `description` varchar(255) DEFAULT NULL COMMENT 'seo的description',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',

  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `is_category` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否分类',

  `content` text COMMENT '内容',
  `x_flag` varchar(20) DEFAULT NULL COMMENT '编辑器标志',

  `create_time` datetime NOT NULL COMMENT '创建时间',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '更新IP',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `code` (`code`),
  KEY `label` (`label`),
  KEY `subject` (`subject`),
  KEY `is_enable` (`is_enable`),
  KEY `is_category` (`is_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='帮助中心';
