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

		$config['index'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^recepten/?$',
			'sef'			=> 'recepten',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php',
		);

		$config['id'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^recepten/id/(.*)$',
			'sef'			=> 'recepten/id/{id}/{name}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?id=$1',
		);

		$config['category'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^recepten/categorie/(.*)$',
			'sef'			=> 'recepten/categorie/{id}/{name}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?category=$1',
		);

		$config['categories'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^recepten/categorieen(.*)$',
			'sef'			=> 'recepten/categorieen/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?category=0',
		);

		$config['tag'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^recepten/tag/(.*)$',
			'sef'			=> 'recepten/tag/{tag}',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?tag=$1',
		);

		$config['tags'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^recepten/tags(.*)$',
			'sef'			=> 'recepten/tags/',
			'redirect'		=> '{e_PLUGIN}cookbook/index.php?tag=0',
		);

		$config['recent'] = array(
			'alias'         => 'cookbook',
			'regex'			=> '^recepten/recent(.*)$',
			'sef'			=> 'recepten/recent/',
			'redirect'		=> '{e_PLUGIN}cookbook/recent.php',
		);

		return $config;
	}
}