alter table pig_permission add show_order int(11) not null default 1 comment '排序';

ALTER TABLE `pig_cwh` ADD `category` enum('1','2') NOT NULL DEFAULT '1' COMMENT '场分类（生产厂、繁殖场）';
-- 2018-10-27
ALTER TABLE `pig_unit` ADD `dytype` SMALLINT(10) NOT NULL COMMENT '1保育单元2育肥单元3怀孕单元4分娩单元' AFTER `cid`;

INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Piggery', 'add', '猪圈修改', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Piggery', 'del', '猪圈修改', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Piggery', 'edit', '猪圈修改', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Piggery', 'lst', '猪圈修改', 'no');

-- 创建数据库
CREATE TABLE `pig_pigpen` (
 `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '圈/耳标id',
 `jname` varchar(50) NOT NULL COMMENT '圈/耳标名称',
 `jnumber` varchar(20) NOT NULL COMMENT '圈/耳标编号',
 `dyid` smallint(6) NOT NULL COMMENT '关联单元id',
 `addtime` varchar(30) NOT NULL COMMENT '添加时间',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `pig_pigpen` ADD PRIMARY KEY (`id`);
ALTER TABLE `pig_pigpen` MODIFY `id` smallint(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '圈/耳标id';
