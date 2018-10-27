-- 2018-10-24
-- 修改字段
UPDATE `pig_permission` SET `name` = '场列表' WHERE `pig_permission`.`id` = 1;
-- 数据添加
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Cwh', 'add', '场添加', 'yes');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Cwh', 'edit', '场删除', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dywh', 'lst', '单元维护', 'yes');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dywh', 'add', '单元组添加', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dywh', 'edit', '单元组修改', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dywh', 'del', '单元组删除', 'no');
-- 建表
CREATE TABLE `yzc`.`pig_dyfz` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '单元分组id' , `fzname` VARCHAR(100) NOT NULL COMMENT '单元分组名称' , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '单元分组';

-- 2018-10-25
-- 添加字段
ALTER TABLE `pig_dyfz` ADD `cid` TINYINT NOT NULL COMMENT '场id' AFTER `fzname`;
ALTER TABLE `pig_dyfz` ADD `addtime` VARCHAR(30) NOT NULL COMMENT '添加时间' AFTER `cid`;

-- 2018-10-26
-- 创建数据库
CREATE TABLE `yzc`.`pig_dtu` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'dtuid' , `dtuname` VARCHAR(50) NOT NULL COMMENT 'dtu别名' , `number` VARCHAR(20) NOT NULL COMMENT 'dtu编号' , `type` VARCHAR(30) NOT NULL COMMENT 'dtu类型' , `cid` TINYINT(50) NOT NULL COMMENT '场id' , `addtime` VARCHAR(30) NOT NULL COMMENT '添加时间' , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'dtu维护';
CREATE TABLE `pig_unit` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '单元id',
  `dyname` varchar(30) NOT NULL COMMENT '单元名称',
  `dyfzid` smallint(6) NOT NULL COMMENT '单元分组关联id',
  `dtuid` smallint(6) NOT NULL COMMENT 'dtu关联id',
  `controller` varchar(30) NOT NULL COMMENT '控制器编号',
  `warningtel` varchar(20) NOT NULL COMMENT '预警手机',
  `monitor` varchar(255) NOT NULL COMMENT '视频监控地址',
  `cid` smallint(6) NOT NULL COMMENT '场id',
  `addtime` varchar(30) NOT NULL COMMENT '添加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单元列表';
ALTER TABLE `pig_unit` ADD PRIMARY KEY (`id`);
ALTER TABLE `pig_unit` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '单元id';
-- 添加字段
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dtu', 'lst', 'DTU列表', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dtu', 'add', 'DTU添加', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dtu', 'del', 'DTU删除', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dtu', 'edit', 'DTU修改', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dylb', 'lst', '单元列表', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dylb', 'add', '单元添加', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dylb', 'del', '单元删除', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dylb', 'edit', '单元修改', 'no');

ALTER TABLE `pig_cwh` ADD `category` enum('1','2') NOT NULL DEFAULT '1' COMMENT '场分类（生产厂、繁殖场）';
-- 2018-10-27
ALTER TABLE `pig_unit` ADD `dytype` SMALLINT(10) NOT NULL COMMENT '1保育单元2育肥单元3怀孕单元4分娩单元' AFTER `cid`;