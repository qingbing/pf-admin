
-- --------------------------------------------------------

--
-- 表的结构 `pub_helper_center`
--

CREATE TABLE IF NOT EXISTS `pub_helper_center` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级ID',
  `label` varchar(30) NOT NULL DEFAULT '' COMMENT '显示标签',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '引用代码',
  `subject` varchar(100) NOT NULL COMMENT '主题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo的keywords',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo的description',
  `sort_order` tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',

  `is_enable` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否启用',
  `is_category` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否分类',

  `content` text COMMENT '内容',
  `x_flag` varchar(20) NOT NULL DEFAULT '' COMMENT '编辑器标志',

  `op_uid` BIGINT(20) UNSIGNED NOT NULL COMMENT '用户ID',
  `op_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '更新IP',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_parentId` (`parent_id`),
  KEY `idx_code` (`code`),
  KEY `idx_label` (`label`),
  KEY `idx_subject` (`subject`),
  KEY `idx_isEnable` (`is_enable`),
  KEY `idx_isCategory` (`is_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='帮助中心';
