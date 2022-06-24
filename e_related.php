<?php
/*
 * Cookbook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Related configuration module
*/

if (!defined('e107_INIT')) { exit; }

class cookbook_related 
{
	function compile($tags, $parm = array()) 
	{
		$sql = e107::getDb();
		$items = array();
			
		$tag_regexp = "'(^|,)(".str_replace(",", "|", $tags).")(,|$)'";
		
		$query = "SELECT * FROM `#cookbook_recipes` WHERE r_id != ".$parm['current']." AND r_keywords REGEXP ".$tag_regexp."  ORDER BY r_datestamp DESC LIMIT ".$parm['limit'];
			
		if($sql->gen($query))
		{	

			$default_img = "{e_PLUGIN}cookbook/images/default_image.webp";

			while($row = $sql->fetch())
			{
				$img = (!empty($row['r_thumbnail']) ? $row['r_thumbnail'] : $default_img);

				$items[] = array(
					'title'			=> varset($row['r_name']),
					'url'			=> e107::url('cookbook', 'id', $row), 
					'summary'		=> "summary?", // varset($row['blank_summary']),
					'image'			=> $img, //varset($row['r_thumbnail']),
				);
			}

			return $items;
	    }
	}
}