

-- --------------------------------------------------------

--
-- 表的结构 `pub_notice`
--

CREATE TABLE IF NOT EXISTS `pub_notice` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `subject` varchar(100) NOT NULL COMMENT '主题',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'seo的keywords',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo的description',
  `sort_order` tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `content` text COMMENT '内容',
  `x_flag` varchar(20) NOT NULL DEFAULT '' COMMENT '编辑器标志',

  `read_times` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `is_publish` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否发布',
  `publish_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发布时间',
  `expire_at` datetime NOT NULL DEFAULT '2100-01-01 23:59:59' COMMENT '有效时间',

  `op_uid` BIGINT(20) UNSIGNED NOT NULL COMMENT '用户ID',
  `op_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '更新IP',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_subject` (`subject`),
  KEY `idx_sortOrder` (`sort_order`),
  KEY `idx_readTimes` (`read_times`),
  KEY `idx_isPublish` (`is_publish`),
  KEY `idx_publishAt` (`publish_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='公告管理表';