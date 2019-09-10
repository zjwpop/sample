CREATE TABLE `abc_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(64) NOT NULL DEFAULT '',
  `prefix` varchar(8) NOT NULL DEFAULT '' COMMENT '前缀，如nmc',
  `linker` varchar(32) NOT NULL DEFAULT '',
  `tel` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(64) NOT NULL DEFAULT '',
  `post_code` varchar(16) NOT NULL DEFAULT '',
  `lng` decimal(11,8)NOT NULL DEFAULT '0' COMMENT '经度',
  `lat` decimal(11,8) NOT NULL DEFAULT '0' COMMENT '纬度',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

CREATE TABLE `abc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `nick` varchar(32) NOT NULL DEFAULT '',
  `token` varchar(64) NOT NULL DEFAULT '',
  `auth_key` varchar(64) NOT NULL DEFAULT '',
  `avatar` varchar(64) NOT NULL DEFAULT '',
  `open_id` varchar(64) NOT NULL DEFAULT '',
  `mobile` varchar(16) NOT NULL DEFAULT '',
  `email` varchar(32) NOT NULL DEFAULT '',
  `status` smallint(2) NOT NULL DEFAULT '1',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '',
  `last_login_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100000 DEFAULT CHARSET=utf8;

INSERT INTO `abc_user` VALUES (1, 100, 'admin', '$2y$13$DRfDvNXpcokdKW5gln46h.ELR6IjMKf2h64Pz.7H.9MlHo0cZp9LS', 'abc', '123', '', '', '', '13912345678', 'abc@domain.com', 1, '', 0, 0);
INSERT INTO `abc_user` VALUES (100, 101, 'root', '$2y$13$DRfDvNXpcokdKW5gln46h.ELR6IjMKf2h64Pz.7H.9MlHo0cZp9LS', 'nmc', '456', '', '', '', '13912345678', 'nmc@domain.com', 1, '', 0, 0);


CREATE TABLE `abc_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `nick` varchar(32) NOT NULL DEFAULT '',
  `token` varchar(64) NOT NULL DEFAULT '',
  `auth_key` varchar(64) NOT NULL DEFAULT '',
  `avatar` varchar(64) NOT NULL DEFAULT '',
  `open_id` varchar(64) NOT NULL DEFAULT '',
  `mobile` varchar(16) NOT NULL DEFAULT '',
  `email` varchar(32) NOT NULL DEFAULT '',
  `status` smallint(2) NOT NULL DEFAULT '1',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '',
  `last_login_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000000 DEFAULT CHARSET=utf8;


INSERT INTO `abc_member` VALUES (100,  '13590423916', '$2y$13$DRfDvNXpcokdKW5gln46h.ELR6IjMKf2h64Pz.7H.9MlHo0cZp9LS', 'w', '567', '', '/upload/20180723_190139_888.jpg', '', '13590423916', '', 1, '', 0, 0);
