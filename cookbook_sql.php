CREATE TABLE `cookbook_categories` (
  `c_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `c_thumbnail` text,
  `c_name` varchar(255) NOT NULL,
  `c_name_sef` varchar(255) NOT NULL default '',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;

CREATE TABLE `cookbook_recipes` (
  `r_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `r_author` tinyint(3) unsigned NOT NULL,
  `r_thumbnail` text,
  `r_name` varchar(255) NOT NULL,
  `r_name_sef` varchar(255) NOT NULL default '',
  `r_datestamp` int(10) unsigned NOT NULL,
  `r_category` tinyint(3) unsigned NOT NULL,
  `r_keywords` varchar(255) DEFAULT NULL,
  `r_persons` tinyint(3) DEFAULT NULL,
  `r_activetime` int(3) DEFAULT NULL,
  `r_totaltime` int(3) DEFAULT NULL,
  `r_authorrating` int(3) DEFAULT NULL,
  `r_difficulty` tinyint(3) DEFAULT NULL,
  `r_summary` text,
  `r_ingredients` text NOT NULL,
  `r_instructions` text NOT NULL,
  PRIMARY KEY (r_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;

CREATE TABLE `cookbook_bookmarks` (
  `bookmark_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(3) NOT NULL,
  `recipe_id` tinyint(3) NOT NULL,
  `bookmark_datestamp` int(10) NOT NULL,
  PRIMARY KEY (`bookmark_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;