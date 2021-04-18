CREATE TABLE `cookbook_categories` (
  `c_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) NOT NULL,
  `c_name_sef` varchar(255) NOT NULL default '',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `cookbook_recipes` (
  `r_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `r_author` tinyint(3) unsigned NOT NULL,
  `r_thumbnail` text,
  `r_name` varchar(255) NOT NULL,
  `r_name_sef` varchar(255) NOT NULL default '',
  `r_datestamp` int(10) unsigned NOT NULL,
  `r_category` tinyint(3) unsigned NOT NULL,
  `r_tags` varchar(255) DEFAULT NULL,
  `r_persons` tinyint(3) DEFAULT NULL,
  `r_time` int(3) DEFAULT NULL,
  `r_authorrating` tinyint(3) DEFAULT NULL,
  `r_ingredients` text NOT NULL,
  `r_instructions` text NOT NULL,
  PRIMARY KEY (r_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
