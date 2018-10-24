alter table pig_user add `name` varchar(20) not null comment '姓名';
alter table pig_user add `tel` varchar(20) not null comment '手机号';
alter table pig_user add `email` varchar(60) not null comment '邮箱';
alter table pig_permission add `show` enum(yes,no) not null default 'yes' comment '是否显示';