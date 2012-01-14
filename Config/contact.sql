--
-- MySQL 5.1.49
-- Sat, 14 Jan 2012 09:34:30 +0000
--

CREATE TABLE `messages` (
   `id` int(11) not null auto_increment,
   `created` datetime,
   `recipients` varchar(255),
   `success` tinyint(1),
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=79;

CREATE TABLE `message_details` (
   `id` int(11) not null auto_increment,
   `message_id` int(11),
   `field` varchar(255),
   `value` varchar(1000),
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=324;
