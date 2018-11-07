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

-- 2018-10-28
ALTER TABLE `pig_pigpen` ADD `bypc` SMALLINT(100) NULL DEFAULT NULL COMMENT '批次' AFTER `addtime`, ADD `byzrtime` VARCHAR(30) NULL DEFAULT NULL COMMENT '转入时间' AFTER `bypc`, ADD `byzrnumber` SMALLINT(100) NULL DEFAULT NULL COMMENT '转入数量' AFTER `byzrtime`, ADD `byzrjz` VARCHAR(10) NULL DEFAULT NULL COMMENT '转入均重' AFTER `byzrnumber`, ADD `byzzrl` VARCHAR(10) NULL DEFAULT NULL COMMENT '转猪日龄' AFTER `byzrjz`, ADD `byzctime` VARCHAR(30) NULL DEFAULT NULL COMMENT '转出时间' AFTER `byzzrl`, ADD `byzcnumber` SMALLINT(100) NULL DEFAULT NULL COMMENT '转出数量' AFTER `byzctime`, ADD `bydqjz` VARCHAR(30) NULL DEFAULT NULL COMMENT '当前均重 ' AFTER `byzcnumber`, ADD `byswsl` SMALLINT(100) NULL DEFAULT NULL COMMENT '死亡数量 ' AFTER `bydqjz`, ADD `bydqrl` SMALLINT(100) NULL DEFAULT NULL COMMENT '当前日龄' AFTER `byswsl`, ADD `bylrb` SMALLINT(100) NULL DEFAULT NULL COMMENT '料肉比' AFTER `bydqrl`;

-- 2018-10-30
CREATE TABLE `yzc`.`pig_drugs` ( `id` TINYINT(30) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '药品id' , `leiqun` VARCHAR(20) NOT NULL COMMENT '类群' , `typenum` ENUM('1','2','3','4','5') NOT NULL COMMENT '类型序号(对照图片)' , `yname` VARCHAR(30) NOT NULL COMMENT '药品名称' , `yrl` TINYINT NOT NULL COMMENT '日龄' , `zsml` FLOAT NOT NULL COMMENT '注射剂量（ml）' , `zstf` FLOAT NOT NULL COMMENT '注射剂量（头份）' , `ymcj` VARCHAR(30) NOT NULL COMMENT '疫苗厂家' , `zsbw` VARCHAR(30) NOT NULL COMMENT '注射部位' , `bz` VARCHAR(200) NOT NULL COMMENT '备注' , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '药品表';
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '怀孕', '1', '伪狂犬弱毒苗', '30', '2.0', '1', '武汉科前', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '怀孕', '1', '口蹄疫灭活苗', '85', '2.0', '1', '中牧兰州', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '怀孕', '1', '伪狂犬灭活疫苗', '90', '2.0', '1', '武汉科前', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '泌乳母猪', '2', '猪瘟-丹毒-肺疫三联苗', '12', '2.0', '1', '广东永顺', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '泌乳母猪', '2', '乙脑活疫苗', '16', '2.0', '1', '武汉科前', '颈肌注射', '一胎');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '泌乳母猪', '2', '细小疫苗', '17', '2.0', '1', '武汉科前', '颈肌注射', '一胎');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '哺乳仔猪', '3', '伪狂犬弱毒苗', '0', '2.0', '1', '武汉科前', '滴鼻', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '哺乳仔猪', '3', '支原体灭活疫苗', '12', '2.0', '1', '海博菜', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '哺乳仔猪', '3', '猪链球菌灭活苗', '12', '2.0', '1', '武汉科前', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '哺乳仔猪', '3', '圆环', '15', '1.0', '0.5', '扬州优邦', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '保育', '4', '蓝耳苗', '21', '2.0', '1', '吉林特研', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '保育', '4', '猪瘟活疫苗', '28', '2.0', '1', '广东永顺', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '保育', '4', '猪瘟活疫苗', '58', '2.0', '1', '广东永顺', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '保育', '4', '口蹄疫灭活苗', '62', '1.0', '1', '中牧兰州', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '保育', '4', '伪狂犬弱毒苗', '66', '2.0', '1', '武汉科前', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '保育', '4', '圆环', '70', '1.0', '1', '扬州优邦', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '育肥', '5', '伪狂犬弱毒苗', '90', '2.0', '1', '武汉科前', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '育肥', '5', '圆环', '95', '1.0', '1', '扬州优邦', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '育肥', '5', '口蹄疫灭活苗', '100', '2.0', '1', '中牧兰州', '颈肌注射', '');
INSERT INTO `pig_drugs` (`id`, `leiqun`, `typenum`, `yname`, `yrl`, `zsml`, `zstf`, `ymcj`, `zsbw`, `bz`) VALUES (NULL, '育肥', '5', '口蹄疫灭活菌', '130', '2.0', '1', '中牧兰州', '颈肌注射', '');

CREATE TABLE `yzc`.`pig_dwmy` ( `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '免疫id' , `mytype` TINYINT NOT NULL COMMENT '免疫类型' , `time` VARCHAR(30) NOT NULL COMMENT '用药时间' , `type` TINYINT NOT NULL COMMENT '用药类型' , `yyl` VARCHAR(10) NOT NULL COMMENT '用药量' , `yyzl` VARCHAR(10) NOT NULL COMMENT '用药总量' , `dyid` SMALLINT NOT NULL COMMENT '单元id' , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '动物免疫';


CREATE TABLE `yzc`.`pig_dwzl` ( `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '动物治疗ID' , `ebh` VARCHAR(20) NOT NULL COMMENT '耳标号' , `number` SMALLINT NOT NULL COMMENT '治疗数量' , `bz` VARCHAR(50) NOT NULL COMMENT '治疗病症' , `type` VARCHAR(50) NOT NULL COMMENT '用药类型' , `status` VARCHAR(10) NOT NULL COMMENT '治疗结果' , `yyl` FLOAT NOT NULL COMMENT '用药量' , `dyid` SMALLINT NOT NULL COMMENT '单元id' , `fenlei` ENUM('1','2') NOT NULL COMMENT '治疗母猪1治疗仔猪2' , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '动物治疗';

-- 2018-11-1
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Drugs', 'index', '免疫用药', 'yes');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Drugs', 'del', '免疫用药删除', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Drugs', 'edit', '免疫用药修改', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Zlzz', 'index', '治疗症状', 'yes');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Zlzz', 'del', '治疗症状删除', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Zlzz', 'edit', '治疗症状修改', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Yylx', 'index', '用药类型', 'yes');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Yylx', 'del', '用药类型删除', 'no');
INSERT INTO `pig_permission` (`id`, `per`, `controller`, `function`, `name`, `show`) VALUES (NULL, '1,2,3', 'Yylx', 'edit', '用药类型修改', 'no');