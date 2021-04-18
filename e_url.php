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

		// Overview of all recipes
		$config['index'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/?$',
			'sef'			=> '{alias}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php',
		);

		// Individual recipe
		$config['id'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/id/(.*)$',
			'sef'			=> '{alias}/id/{id}/{sef}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?id=$1',
		);
		
		// All recipes in a specific category
		$config['category'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/category/(.*)$',
			'sef'			=> '{alias}/category/{id}/{sef}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?category=$1',
		);

		// Overview of all recipes split by category
		$config['categories'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/categories(.*)$',
			'sef'			=> '{alias}/categories/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?category=0',
		);

		// Individual tag
		$config['tag'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/tag/(.*)$',
			'sef'			=> '{alias}/tag/{tag}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?tag=$1',
		);

		// Tagcloud
		$config['tags'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/tags(.*)$',
			'sef'			=> '{alias}/tags/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?tag=0',
		);

		// Recently added recipes
		$config['recent'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^{alias}/recent(.*)$',
			'sef'			=> '{alias}/recent/',
			'redirect'		=> '{e_PLUGIN}cookbook/recent.php',
		);

		return $config;
	}
}