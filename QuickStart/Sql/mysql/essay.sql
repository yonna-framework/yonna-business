create table `essay_category`
(
    `id`       bigint unsigned auto_increment not null comment 'id',
    `upper_id` bigint unsigned                not null default 0 comment 'essay_category_id',
    `name`     char(255)                      not null default '' comment '分类名称',
    `level`    bigint unsigned                not null default 1 comment '分类等级',
    `status`   tinyint                        not null default 1 comment '状态[-1审核驳回,1待审核,2审核通过]',
    `ordering` int                            not null default 0 comment '排序[降序]',
    primary key (`id`),
    unique key (`upper_id`, `name`),
    index (`level`),
    index (`status`)
) engine = innodb comment '文章分类';

create table `essay`
(
    `id`          bigint unsigned auto_increment not null comment 'id',
    `user_id`     bigint unsigned                not null default 0 comment 'user_id',
    `category_id` bigint unsigned                not null default 0 comment 'essay_category_id',
    `status`      tinyint                        not null default 1 comment '状态[-1无效,1有效]',
    `likes`       bigint unsigned                not null default 0 comment '点赞量',
    `views`       bigint unsigned                not null default 0 comment '浏览量',
    `content`     text                           not null comment '文章内容',
    `ordering`    int                            not null default 0 comment '排序[降序]',
    primary key (`id`),
    index (`user_id`, `category_id`, `status`)
) engine = innodb comment '文章';