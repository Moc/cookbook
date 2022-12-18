<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2015 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Configuration for menu options through Admin Area > Menu manager
 *
*/

if (!defined('e107_INIT')) { exit; }

class cookbook_menu
{
	function __construct()
	{
		//	e107::lan('banner','admin', 'true');
	}

	/**
	 * Configuration Fields.
	 * @return array
	 */
	public function config($menu='')
	{
		$fields = array();
		//print_a($menu);

		if($menu == "cookbook_latest")
		{
			$fields['caption'] 	= array(
				'title' 		=> LAN_CAPTION, 
				'type' 			=> 'text', 
				'multilan' 		=> true, 
				'writeParms' 	=> array('size' => 'xxlarge')
			);

			$fields['limit'] = array(
				'title' 		=> LAN_LIMIT, 
				'type' 			=> 'number', 
				'writeParms' 	=> array('default' => 10)
			);
		}

		if($menu == "cookbook_categories")
		{
			$fields['caption'] 	= array(
				'title' 	 => LAN_CAPTION, 
				'type' 		 => 'text', 
				'multilan' 	 => true, 
				'writeParms' => array('size' => 'xxlarge')
			);
		}

		if($menu == "cookbook_popkeywords")
		{
			$fields['caption'] 	= array(
				'title' 		=> LAN_CAPTION, 
				'type' 			=> 'text', 
				'multilan' 		=> true, 
				'writeParms' 	=> array('size' => 'xxlarge')
			);

			$fields['limit'] = array(
				'title' 		=> LAN_LIMIT, 
				'type' 			=> 'number', 
				'writeParms' 	=> array('default' => 10)
			);
		}
		
        return $fields;
	}
}


class cookbook_menu_form extends e_form
{

}