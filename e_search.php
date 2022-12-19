<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
*/

if (!defined('e107_INIT')) { exit; }


class cookbook_search extends e_search 
{
		function config()
	{	
		$search = array(
			'name'			=> LAN_CB_NAME,
			'table'			=> 'cookbook_recipes',

			'advanced' 		=> array(
								'date'	=> array('type'	=> 'date', 'text' => LAN_DATE_POSTED),
								'author'=> array('type'	=> 'author', 'text' => LAN_SEARCH_61)
							),
							
			'return_fields'	=> array(
				'r_id',
				'r_author', 
				'r_name',
				'r_name_sef', 
				'r_summary', 
				'r_datestamp'
			),
			
			'search_fields'	=> array(
				'r_name' 			=> '1', 
				'r_summary' 		=> '0.8', 
				'r_ingredients' 	=> '0.6', 
				'r_instructions'	=> '1'
			), 
			
			'order'			=> array('r_datestamp' => 'DESC'),
			'refpage'		=> e107::url('cookbook', 'index'), 
		);

		return $search;
	}

	/* Compile Database data for output */
	function compile($row)
	{
		$tp = e107::getParser();

		$username = e107::user($row['r_author']);
		$username = $username['user_name'];

		$res = array();	

		$res['link'] 		= e107::url('cookbook', 'id', $row);
		//$res['pre_title'] 	= LAN_SEARCH_7;
		$res['title'] 		= $row['r_name'];
		$res['summary'] 	= $row['r_summary'];
		$res['detail'] 		= LAN_SEARCH_15." ".$username." | ".LAN_SEARCH_66.": ".$tp->toDate($row['r_datestamp'], "long");

		return $res;		
	}

	/**
	 * Advanced Where
	 * @param $parm - data returned from $_GET (ie. advanced fields included. in this case 'date' and 'author' )
	 */
	function where($parm=null)
	{
		$tp = e107::getParser();

		$user_name 	= $tp->toDB($parm['author']);
		$user_id 	= e107::getDb()->retrieve("user", "user_id", "user_name = '".$username);
			
		$qry = "";
		
		if (vartrue($parm['time']) && is_numeric($parm['time'])) 
		{
			$qry .= " r_datestamp ".($parm['on'] == 'new' ? '>=' : '<=')." '".(time() - $parm['time'])."' AND";
		}

		if(vartrue($parm['author'])) 
		{
			$qry .= " r_author = ".$user_id;
		}
		
		return $qry;
	}
}