-- 评论表

-- 主键
-- 评论的用户 user_id num not null no default
-- 评论的文章 article_id num not null no default
-- 父评论的id parent_id num not null default 0
-- 评论的内容 content varchar not null no default
-- 评论发布时间 publish_time num not null no default
CREATE TABLE `comment` (
  `id` INT PRIMARY KEY auto_increment,
  `user_id` INT NOT NULL,
  `article_id` INT NOT NULL,
  `parent_id` INT NOT NULL DEFAULT 0,
  `content` varchar(500),
  `publish_time` INT NOT NULL
  ) ENGINE=innodb DEFAULT CHARSET utf8;
)


# SELECT `comment`.*, `user`.`username`, `article`.`title`, a.`content` AS parent_content
#   FROM `comment`
#   LEFT JOIN `user` ON `comment`.`user_id`=`user`.`id`
#   LEFT JOIN `article` ON `comment`.`article_id`=`article`.`id`
#   LEFT JOIN `comment` AS a ON `comment`.`parent_id`=a.`id`;

INSERT INTO `comment` VALUES
  (NULL, 1, 1, 0, '么么哒', 1464936963),
  (NULL, 3, 2, 1, '么么哒2', 1464936963),
  (NULL, 2, 3, 0, '么么哒3', 1464936963),
  (NULL, 1, 1, 0, '么么哒4', 1464936963),
  (NULL, 2, 1, 0, '么么哒5', 1464936963),
  (NULL, 1, 1, 0, '么么哒6', 1464936963);