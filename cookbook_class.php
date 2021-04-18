<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Shortcodes used in templates
*/



if (!defined('e107_INIT')) { exit; }

class Cookbook
{
	protected $plugprefs = array();

	public function __construct()
	{
		$this->plugprefs = e107::getPlugPref('cookbook');
	}

	public function getCategoryName($id = '', $sef = false)
	{
		$cid = e107::getParser()->toDb($id);

		if($cdata  = e107::getDb()->retrieve('cookbook_categories', 'c_name, c_name_sef', 'c_id = '.$cid.''))
		{
			if($sef == false)
			{
				return $cdata["c_name"]; 
			}
			else
			{
				return $cdata["c_name_sef"];
			}
		}	
	
		return false; 
	}
}