-- 修改字段
UPDATE `pig_permission` SET `name` = '场列表' WHERE `pig_permission`.`id` = 1;


-- 数据添加
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Cwh', 'add', '场添加', 'yes');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Cwh', 'edit', '场删除', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dywh', 'lst', '单元维护', 'yes')SELECT * FROM `pig_permission` WHERE 1;
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dywh', 'add', '单元组添加', 'no')SELECT * FROM `pig_permission` WHERE 1;
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dywh', 'edit', '单元组修改', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Dywh', 'del', '单元组删除', 'no');


-- 建表
CREATE TABLE `yzc`.`pig_dyfz` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '单元分组id' , `fzname` VARCHAR(100) NOT NULL COMMENT '单元分组名称' , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '单元分组';