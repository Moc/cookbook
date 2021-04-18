<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
*/

require_once('../../class2.php');

e107::lan('cookbook', true, true);

if (!getperms('P'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}

class cookbook_adminArea extends e_admin_dispatcher
{
	protected $modes = array(

		'cat' => array(
			'controller' 	=> 'cookbook_categories_ui',
			'path' 			=> null,
			'ui' 			=> 'cookbook_categories_form_ui',
			'uipath' 		=> null
		),

		'main'	=> array(
			'controller' 	=> 'cookbook_recipes_ui',
			'path' 			=> null,
			'ui' 			=> 'cookbook_recipes_form_ui',
			'uipath' 		=> null
		),
	);

	protected $adminMenu = array(

		'main/list'			=> array('caption'=> LAN_CB_MANAGE_RECIPES, 'perm' => 'P'),
		'main/create'		=> array('caption'=> LAN_CB_CREATE_RECIPE, 'perm' => 'P'),

		'cat/list'			=> array('caption'=> LAN_CATEGORIES, 'perm' => 'P'),
		'cat/create'		=> array('caption'=> LAN_CREATE_CATEGORY, 'perm' => 'P'),

		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P'),

		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'
	);

	protected $menuTitle = LAN_CB_NAME;

	function init()
 	{
		$pref = e107::pref('cookbook');

		$this->access = array(
			'main/prefs'    => varset($pref['admin_recipe_delete'],  e_UC_MAINADMIN),
			'main/create'   => varset($pref['admin_recipe_create'],   e_UC_ADMIN),
			'main/edit'     => varset($pref['admin_recipe_edit'],     e_UC_ADMIN),
			'main/delete'   => varset($pref['admin_recipe_delete'],   e_UC_ADMIN),
			'cat/create'    => varset($pref['admin_cat_create'],   e_UC_ADMIN),
			'cat/edit'      => varset($pref['admin_cat_edit'],     e_UC_ADMIN),
			'cat/delete'    => varset($pref['admin_cat_delete'],   e_UC_ADMIN),
		);
 	}
}



class cookbook_categories_ui extends e_admin_ui
{
	protected $pluginTitle		= LAN_CB_NAME;
	protected $pluginName		= 'cookbook';
//	protected $eventName		= 'cookbook-cookbook_categories'; // remove comment to enable event triggers in admin.
	protected $table			= 'cookbook_categories';
	protected $pid				= 'c_id';
	protected $perPage			= 10;
	protected $batchDelete		= true;
//	protected $batchCopy		= true;
//	protected $sortField		= 'somefield_order';
//	protected $orderStep		= 10;
//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.

//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= 'c_id ASC';

	protected $fields 		= array (  
		'checkboxes' => array(
			'title' 	=> '', 
			'type' 		=> null, 
			'data' 		=> null, 
			'width'		=> '5%', 
			'thclass' 	=> 'center', 
			'forced' 	=> '1', 
			'class' 	=> 'center', 
			'toggle' 	=> 'e-multiselect',  
		),
		'c_id' => array(
			'title'		 	=> LAN_ID, 
			'type' 			=> 'number', 	
			'data' 			=> 'int', 
			'width' 		=> '5%', 
			'help' 			=> '', 
			'readParms'		=> '', 
			'writeParms'	=> '', 
			'class' 		=> 'left', 
			'thclass' 		=> 'left',  
		),
		'c_name' => array(
			'title' 		=> LAN_NAME, 	
			'type' 			=> 'text', 
			'data' 			=> 'str', 
			'width' 		=> 'auto', 
			'inline' 		=> true, 
			'help' 			=> 'Name of the category', 
			'readParms' 	=> '', 
			'writeParms'	=> '', 
			'class' 		=> 'left', 
			'thclass' 		=> 'left',  
		),
		'c_name_sef' => array(	 
			'title' => LAN_SEFURL,	
			'type' 	=> 'hidden', 	
			'data'	=>'str'
		),
		'options' => array(
			'title' 	=> LAN_OPTIONS,
			'type' 		=> null, 
			'data' 		=> null, 
			'width' 	=> '10%', 
			'thclass' 	=> 'center last', 
			'class' 	=> 'center last', 
			'forced' 	=> '1',  
		),
	);

	protected $fieldpref = array('c_id', 'c_name');


	public function init()
	{
		// Set drop-down values (if any).
	}

	// ------- Customize Create --------

	public function beforeCreate($new_data, $old_data)
	{
		// Automatically generate and set SEF of category name
		$new_data['c_name_sef'] = empty($new_data['c_name_sef']) ?  eHelper::title2sef($new_data['c_name']) : eHelper::secureSef($new_data['c_name_sef']);

		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onCreateError($new_data, $old_data)
	{
		// do something
	}

	// ------- Customize Update --------

	public function beforeUpdate($new_data, $old_data, $id)
	{
		// Automatically update SEF
		$new_data['c_name_sef'] = eHelper::title2sef($new_data['c_name']);

		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
		// do something
	}
}


class cookbook_categories_form_ui extends e_admin_form_ui
{

}


class cookbook_recipes_ui extends e_admin_ui
{

	protected $pluginTitle		= LAN_CB_NAME;
	protected $pluginName		= 'cookbook';
//	protected $eventName		= 'cookbook-cookbook_recipes'; // remove comment to enable event triggers in admin.
	protected $table			= 'cookbook_recipes';
	protected $pid				= 'r_id';
	protected $perPage			= 20;
	protected $batchDelete		= true;
//	protected $batchCopy		= true;
//	protected $sortField		= 'somefield_order';
//	protected $orderStep		= 10;
//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.

//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= 'r_id ASC';

	protected $fields 	= array (  
		'checkboxes' =>  array(
			'title' 	=> '', 
			'type' 		=> null, 
			'data' 		=> null, 
			'width' 	=> '5%', 
			'thclass' 	=> 'center', 
			'forced' 	=> '1', 
			'class' 	=> 'center', 
			'toggle' 	=> 'e-multiselect',  
		),
		'r_id' => array(
			'title' 		=> LAN_ID, 
			'type' 			=> 'number',		
			'data' 			=> 'int', 
			'width' 		=> '5%', 
			'help' 			=> '', 
			'readParms' 	=> '', 
			'writeParms' 	=> '', 
			'class' 		=> 'left', 
			'thclass' 		=> 'left',  
		),
	  	'r_thumbnail' => array( 
	  		'title' 		=> LAN_IMAGE, 			
	  		'type' 			=> 'method', 	
	  		'width' 		=> '110px',	
	  		'thclass' 		=> 'center', 			
	  		'class' 		=> "center", 		
	  		'nosort' 		=> false, 
	  		'readParms' 	=> 'thumb=60&thumb_urlraw=0&thumb_aw=60',
	  		'readonly'		=> false
	  	),
	  	'r_name' => array( 
	  		'title' 		=> LAN_TITLE, 			
	  		'type' 			=> 'text', 		
	  		'data' 			=> 'str', 
	  		'width' 		=> 'auto', 
	  		'inline' 		=> true, 
	  		'help' 			=> '', 
	  		'readParms' 	=> '', 
	  		'writeParms' 	=> '', 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_name_sef' => array( 
	  		'title' => LAN_SEFURL,			
	  		'type' 	=> 'hidden', 	
	  		'data'	=> 'str'
	  	),
	  	'r_category' => array( 
	  		'title' 		=> LAN_CATEGORY, 		
	  		'type' 			=> 'dropdown', 	
	  		'data' 			=> 'int', 
	  		'width' 		=> 'auto', 
	  		'batch' 		=> true, 
	  		'filter' 		=> true, 
	  		'inline' 		=> true, 
	  		'help' 			=> '', 
	  		'readParms'	 	=> '', 
	  		'writeParms' 	=> '', 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_datestamp' => array( 
	  		'title' => LAN_DATESTAMP, 		
	  		'type' 	=> 'hidden', 	
	  		'data' 	=> 'int'
	  	),
	  	'r_author' => array( 
	  		'title' => LAN_AUTHOR, 			
	  		'type' 	=> 'hidden', 	
	  		'data' 	=> 'int'
	  	),
	  	'r_tags' => array( 
	  		'title' 		=> LAN_KEYWORDS, 		
	  		'type' 			=> 'tags', 		
	  		'data' 			=> 'str', 
	  		'width' 		=> 'auto', 
	  		'help' 			=> LAN_CB_HELP_TAGS, 
	  		'readParms' 	=> '', 
	  		'writeParms' 	=> '', 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_persons' =>  array(
	  		'title' 		=> LAN_CB_PERSONS,		
	  		'type' 			=> 'number', 	
	  		'data' 			=> 'int', 
	  		'width' 		=> 'auto', 
	  		'inline' 		=> true, 
	  		'help' 			=> LAN_CB_HELP_PERSONS, 
	  		'readParms' 	=> '', 
	  		'writeParms' 	=> '', 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_time' =>   array(
	  		'title' 		=> LAN_CB_TIME, 	
	  		'type' 			=> 'number', 	
	  		'data' 			=> 'int', 
	  		'width' 		=> 'auto', 
	  		'inline' 		=> true, 
	  		'help' 			=> LAN_CB_HELP_TIME, 
	  		'readParms' 	=> '', 
	  		'writeParms' 	=> '', 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_rating' => array( 
	  		'title' 		=> LAN_CB_RATING, 		
	  		'type' 			=> 'number', 	
	  		'data' 			=> 'int', 
	  		'width' 		=> 'auto', 
	  		'inline' 		=> true, 
	  		'help' 			=> LAN_CB_HELP_RATING, 
	  		'readParms' 	=> '', 
	  		'writeParms' 	=> '', 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_ingredients' => array( 
	  		'title' 		=> LAN_CB_INGREDIENTS,	
	  		'type' 			=> 'bbarea', 	
	  		'data' 			=> 'str', 
	  		'width'			=> 'auto', 
	  		'help' 			=> '', 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(), 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_instructions' => array( 
	  		'title' 		=> LAN_CB_INSTRUCTIONS,	
	  		'type' 			=> 'bbarea', 	
	  		'data' 			=> 'str', 
	  		'width' 		=> 'auto', 
	  		'help' 			=> '', 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(), 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left', 
	  	),
	  	'options' => array( 
	  		'title' 	=> LAN_OPTIONS, 		
	  		'type' 		=> null, 		
	  		'data' 		=> null, 
	  		'width' 	=> '10%', 
	  		'thclass' 	=> 'center last', 
	  		'class' 	=> 'center last', 
	  		'forced' 	=> '1',
	  	),
	);

	protected $fieldpref = array('r_id', 'r_thumbnail', 'r_name', 'r_category', 'r_persons', 'r_time', 'r_rating');


	protected $prefs = array(
		'submission_userclass'	=> array(
			'title'	=> 'Submission userclass',
			'type'	=>'userclass',
			'data' 	=> 'str',
			'help'	=>'Userclass that is allowed to submit new recipes'
		),
		'allow_sharing' => array(
			'title'	=> 'Allow sharing',
			'type'	=>'boolean',
			'data' 	=> 'str',
			'help'	=>'Enable the option to share recipes'
		),
		'date_format' => array(
			'title'	=> 'Date format',
			'type'	=> 'dropdown',
			'data'	=> 'str',
			'help'	=> 'Uses the format defined in Preferences > Date Display options'
		),
		'caching' => array(
			'title'	=> 'Caching',
			'type'	=> 'boolean',
			'data'	=> 'str',
			'help'	=> 'Choose whether to enable caching on this plugin (increases performance)'
		),
	);

	public function init()
	{
		$sql = e107::getDb();

		// Link recipes with categories
		if($sql->select('cookbook_categories'))
		{
			while ($row = $sql->fetch())
			{
				$this->category[$row['c_id']] = $row['c_name'];
			}
		}

		$this->fields['r_category']['writeParms'] = $this->category;

		// Default rating is 1
		$this->fields['r_rating']['writeParms'] = '1';

		// Preferences 
		$this->prefs['allow_sharing']['writeParms']['post'] 		= " <span class='label label-danger'>Not working yet</span>";
		$this->prefs['submission_userclass']['writeParms']['post'] 	= " <span class='label label-danger'>Not working yet</span>";

		// Choose between 'long|short|relative', as defined in Preferences > Date Display options
		$this->prefs['date_format']['writeParms'] = array(
			"long" 		=> "long", 
			"short" 	=> "short", 
			"relative" 	=> "relative"
		); 

	}

	// Make some adjustments before storing the new data in the database
	public function beforeCreate($new_data, $old_data)
	{
		// Process image thumbnails
		$new_data['r_thumbnail'] = $this->processThumbs($new_data['r_thumbnail']);

		// Default recipe date is the creation date
		if(empty($new_data['r_datestamp']))
		{
			$new_data['r_datestamp'] = time();
		}

		// Default recipe rating is 1
		if(!$new_data['r_rating'])
		{
			$new_data['r_rating'] = '1';
		}

		// Set recipe author
		if(empty($new_data['r_author']))
		{
			$new_data['r_author'] = USERID;
		}


		// Automatically generate and set SEF of recipe name
		$new_data['r_name_sef'] = empty($new_data['r_name_sef']) ? eHelper::title2sef($new_data['r_name']) : eHelper::secureSef($new_data['r_name_sef']);

		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
		e107::getCache()->clear('cookbook_recipe_tagcloud');
	}

	// Make some adjustments before storing the updated data into the database
	public function beforeUpdate($new_data, $old_data, $id)
	{
		// Process image thumnails
		$new_data['r_thumbnail'] = $this->processThumbs($new_data['r_thumbnail']);

		// Default recipe date is the creation date
		if(empty($new_data['r_datestamp']))
		{
			$new_data['r_datestamp'] = time();
		}

		// Default recipe rating is 1
		if(!$new_data['r_rating'])
		{
			$new_data['r_rating'] = '1';
		}

		// Automatically update SEF
		$new_data['r_name_sef'] = eHelper::title2sef($new_data['r_name']);

		// Set recipe author
		if(empty($new_data['r_author']))
		{
			$new_data['r_author'] = USERID;
		}


		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
		e107::getCache()->clear('cookbook_recipe_tagcloud');
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
		// do something
	}

	// For future use: multiple-images
	private function processThumbs($postedImage)
	{
		if(is_array($postedImage))
		{
			return implode(",", array_filter($postedImage));
		}
		else
		{
			return $postedImage;
		}
	}

	/*public function renderHelp()
	{
		return array(
			'caption'	=> "Help",
			'text'		=> "Work in progress",
		);
	}*.

	/*
	// optional - a custom page.
	public function customPage()
	{
		$text = 'Hello World!';
		return $text;

	}
	*/
}

class cookbook_recipes_form_ui extends e_admin_form_ui
{
	function r_thumbnail($curval,$mode)
	{
		if($mode == 'read')
		{
			if(!vartrue($curval)) return;

			if(strpos($curval, ",")!==false)
			{
				$tmp = explode(",",$curval);
				$curval = $tmp[0];
			}

			$vparm = array('thumb'=>'tag','w'=> 80);

			if($thumb = e107::getParser()->toVideo($curval,$vparm))
			{
				return $thumb;
			}

			if($curval[0] != "{")
			{
				$curval = "{e_PLUGIN}cookbook/recipe_images/".$curval;
			}

			$url = e107::getParser()->thumbUrl($curval,'aw=80');
			$link = e107::getParser()->replaceConstants($curval);

			return "<a class='e-dialog' href='{$link}'><img src='{$url}' alt='{$curval}' /></a>";
		}

		if($mode == 'write')
		{
			$tp = e107::getParser();
			$frm = e107::getForm();

			//	$text .= $frm->imagepicker('r_thumbnail[0]', $curval ,'','media=cookbook&video=1');
			$thumbTmp = explode(",",$curval);

			foreach($thumbTmp as $key=>$path)
			{
				if(!empty($path) && (strpos($path, ",") == false) && $path[0] != "{" && $tp->isVideo($path) === false )//BC compat
				{
					$thumbTmp[$key] = "{e_PLUGIN}cookbook/recipe_images/".$path;
				}
			}

			$text =  $frm->imagepicker('r_thumbnail[0]', varset($thumbTmp[0]),'','media=cookbook&video=1');
			/*$text .= $frm->imagepicker('r_thumbnail[1]', varset($thumbTmp[1]),'','media=cookbook&video=1');
			$text .= $frm->imagepicker('r_thumbnail[2]', varset($thumbTmp[2]),'','media=cookbook&video=1');
			$text .= $frm->imagepicker('r_thumbnail[3]', varset($thumbTmp[3]),'','media=cookbook&video=1');
			$text .= $frm->imagepicker('r_thumbnail[4]', varset($thumbTmp[4]),'','media=cookbook&video=1');*/

			return $text;
		}
	}
}

new cookbook_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;