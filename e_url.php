<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Friendly URL configuration
*/

if (!defined('e107_INIT')) { exit; }

class cookbook_url
{
	function config()
	{
		$config = array();

		// Individual recipe
		$config['id'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/id/(.*)$',
			'sef'			=> '{alias}/id/{r_id}/{r_name_sef}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?p=id&id=$1',
		);

		// All recipes in a specific category
		$config['category'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/category/(.*)$',
			'sef'			=> '{alias}/category/{c_id}/{c_name_sef}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?p=category&category=$1',
		);

		// Overview of all recipes split by category
		$config['categories'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/categories(.*)$',
			'sef'			=> '{alias}/categories/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?p=categories',
		);

		// Individual keyword
		$config['keyword'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/keyword/(.*)$',
			'sef'			=> '{alias}/keyword/{keyword}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?p=keyword&keyword=$1',
		);

		// Overview of all keywords (tagcloud)
		$config['keywords'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/keywords(.*)$',
			'sef'			=> '{alias}/keywords/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?p=keywords',
		);

		// Recently added recipes
		$config['latest'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/latest(.*)$',
			'sef'			=> '{alias}/latest/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?p=latest',
		);

		// Recently added recipes
		$config['bookmarks'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/bookmarks(.*)$',
			'sef'			=> '{alias}/bookmarks/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?p=bookmarks',
		);

		// Overview of all recipes
		$config['index'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/?(.*)$',
			'sef'			=> '{alias}/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php',
		);

		return $config;
	}
}