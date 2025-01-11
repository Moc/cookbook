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

		'main/div0' 		=> array('divider' => true),

		'cat/list'			=> array('caption'=> LAN_CATEGORIES, 'perm' => 'P'),
		'cat/create'		=> array('caption'=> LAN_CREATE_CATEGORY, 'perm' => 'P'),

		'main/div1' 		=> array('divider' => true),

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
	protected $eventName		= 'cookbook_categories'; // remove comment to enable event triggers in admin.
	protected $table			= 'cookbook_categories';
	protected $pid				= 'c_id';
	protected $perPage			= 10;
	protected $batchDelete		= true;
	protected $batchExport      = true;
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
			'readParms'		=> array(), 
			'writeParms'	=> array(), 
			'class' 		=> 'left', 
			'thclass' 		=> 'left',  
		),
		'c_thumbnail' 		=> array( 
			'title' 		=> LAN_IMAGE, 	
			'type' 			=> 'method', 
			'data' 			=> 'str', 
			'width' 		=> '100px', 
			'help' 			=> '', 
			'readParms' 	=> 'thumb=100x100', 
			'writeParms' 	=> 'media=cookbook_image_2', 
			'class' 		=> 'left', 
			'thclass' 		=> 'left',  
		),
		/*'c_thumbnail' => array( 
	  		'title' 		=> LAN_IMAGE, 			
	  		'type' 			=> 'image', 
	  		'data'			=> 'str',
	  		'width' 		=> '110px',	
	  		'readParms'		=> array('thumb' => '80x80'), 
	  		'writeParms'	=> array('media' => 'cookbook'),
	  	),*/
		'c_name' => array(
			'title' 		=> LAN_NAME, 	
			'type' 			=> 'text', 
			'data' 			=> 'str', 
			'width' 		=> 'auto', 
			'inline' 		=> true, 
			'validate'		=> true,
			'help' 			=> 'Name of the category', 
			'readParms' 	=> array(), 
			'writeParms'	=> array(), 
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

	protected $fieldpref = array('c_id', 'c_thumbnail', 'c_name');


	public function init()
	{
		// Set drop-down values (if any).
	}

	// ------- Customize Create --------

	public function beforeCreate($new_data, $old_data)
	{
		// Automatically generate and set SEF of category name
		$new_data['c_name_sef'] = empty($new_data['c_name_sef']) ?  eHelper::title2sef($new_data['c_name']) : eHelper::secureSef($new_data['c_name_sef']);

		// Check if remote URL for recipe category thumbnail is set. If yes, override the c_thumbnail field. 
		if(!empty($new_data['c_thumbnail_remote']))
		{
			$new_data['c_thumbnail'] = $new_data['c_thumbnail_remote'];
		}


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

		// Check if remote URL for recipe category thumbnail is set. If yes, override the c_thumbnail field. 
		if(!empty($new_data['c_thumbnail_remote']))
		{
			$new_data['c_thumbnail'] = $new_data['c_thumbnail_remote'];
		}

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

	function c_thumbnail($curVal, $mode)
	{
		switch($mode)
		{
			// List Page
			case 'read': 
				return e107::getParser()->toImage($curVal);
				//break;

			// Edit Page
			case 'write': 

				if(strpos($curVal,'http') === 0)
				{
					$val1 = null;
					$val2 = $curVal;
				}
				else
				{
					$val1 = $curVal;
					$val2 = null;
				}

				$tab1 = $this->imagepicker('c_thumbnail', $val1, null, "media=cookbook_image_2");


				$tab2 = "<p>".$this->text('c_thumbnail_remote', $val2, 255, array('size' => 'xxlarge', 'placeholder' => LAN_CB_THUMBNAIL_REMOTE_PLACEHOLDER, 'title' => LAN_CB_THUMBNAIL_REMOTE_TITLE))."</p>";

				if(!empty($val2))
				{
					$tab2 .= e107::getParser()->toImage($val2);
				}

				$tabText = array(
					'local'  => array('caption' => LAN_CB_THUMBNAIL_LOCAL, 'text' => $tab1),
					'remote' => array('caption' => LAN_CB_THUMBNAIL_REMOTE, 'text' => $tab2),
				);

				return $this->tabs($tabText);
				//break;

			case 'filter':
			case 'batch':
				return "";
				//break;
		}

		return;
	}

}


class cookbook_recipes_ui extends e_admin_ui
{

	protected $pluginTitle		= LAN_CB_NAME;
	protected $pluginName		= 'cookbook';
	protected $eventName		= 'cookbook_recipes'; // remove comment to enable event triggers in admin.
	protected $table			= 'cookbook_recipes';
	protected $pid				= 'r_id';
	protected $perPage			= 20;
	protected $batchDelete		= true;
	protected $batchExport      = true;
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
			'readParms' 	=> array('link' => true, 'target' => 'blank', 'url' => 'id'),
			'writeParms' 	=> array(), 
			'class' 		=> 'left', 
			'thclass' 		=> 'left',  
		),
		'r_thumbnail' 		=> array( 
			'title' 		=> LAN_IMAGE, 	
			'type' 			=> 'method', 
			'data' 			=> 'str', 
			'width' 		=> '100px', 
			'help' 			=> '', 
			'readParms' 	=> 'thumb=100x100', 
			'writeParms' 	=> 'media=cookbook_image', 
			'class' 		=> 'left', 
			'thclass' 		=> 'left',  
		),
	  	/*'r_thumbnail' => array( 
	  		'title' 		=> LAN_IMAGE, 			
	  		'type' 			=> 'image', 
	  		'data'			=> 'str',
	  		'width' 		=> '110px',	
	  		'readParms'		=> array('thumb' => '80x80'), 
	  		'writeParms'	=> array('media' => 'cookbook'),
	  	),*/
	  	'r_name' => array( 
	  		'title' 		=> LAN_TITLE, 			
	  		'type' 			=> 'text', 		
	  		'data' 			=> 'str', 
	  		'width' 		=> 'auto',
	  		'validate'		=> true, 
	  		'inline' 		=> true, 
	  		'help' 			=> '', 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(), 
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
	  		'readParms'	 	=> array(), 
	  		'writeParms' 	=> array(), 
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
	  	'r_keywords' => array( 
	  		'title' 		=> LAN_KEYWORDS, 		
	  		'type' 			=> 'tags', 		
	  		'data' 			=> 'str', 
	  		'width' 		=> 'auto', 
	  		'help' 			=> LAN_CB_HELP_KEYWORDS, 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(), 
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
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(), 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_activetime' =>   array(
	  		'title' 		=> LAN_CB_ACTIVETIME, 	
	  		'type' 			=> 'hidden', 	
	  		'data' 			=> 'int', 
	  		'width' 		=> 'auto', 
	  		'inline' 		=> true, 
	  		'help' 			=> LAN_CB_HELP_ACTIVETIME, 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(),
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_totaltime' =>   array(
	  		'title' 		=> LAN_CB_TOTALTIME, 	
	  		'type' 			=> 'number', 	
	  		'data' 			=> 'int', 
	  		'width' 		=> 'auto', 
	  		'inline' 		=> true, 
	  		'help' 			=> LAN_CB_HELP_TOTALTIME, 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(),
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_authorrating' => array( 
	  		'title' 		=> LAN_CB_AUTHORRATING, 		
	  		'type' 			=> 'hidden', 	
	  		'data' 			=> 'int', 
	  		'width' 		=> 'auto', 
	  		'inline' 		=> true, 
	  		'help' 			=> LAN_CB_HELP_AUTHORRATING, 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array('default' => 1, 'min' => 1, 'max' => 3), 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_difficulty' => array( 
	  		'title' 		=> LAN_CB_DIFFICULTY, 		
	  		'type' 			=> 'hidden', 	
	  		'data' 			=> 'int', 
	  		'width' 		=> 'auto', 
	  		'inline' 		=> true, 
	  		'help' 			=> LAN_CB_HELP_DIFFICULTY, 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(),
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_summary' => array( 
	  		'title' 		=> LAN_SUMMARY,	
	  		'type' 			=> 'bbarea', 	
	  		'data' 			=> 'str', 
	  		'width'			=> 'auto', 
	  		'help' 			=> LAN_CB_HELP_SUMMARY,  
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array('size' => 'small'), 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),
	  	'r_ingredients' => array( 
	  		'title' 		=> LAN_CB_INGREDIENTS,	
	  		'type' 			=> 'bbarea', 	
	  		'data' 			=> 'str', 
	  		'width'			=> 'auto', 
	  		'validate'		=> true,
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
	  		'validate'		=> true, 
	  		'help' 			=> '', 
	  		'readParms' 	=> array(), 
	  		'writeParms' 	=> array(), 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left', 
	  	),
	  	/*'r_instructionsnew' => array( 
	  		'title' 		=> "New instructions", 
	  		'type' 			=> 'hidden', 
	  		'data' 			=> 'json', 
	  		'width' 		=> 'auto', 
	  		'help' 			=> 'test', 
	  		'readParms' 	=> '', 
	  		'writeParms' 	=> '', 
	  		'class' 		=> 'left', 
	  		'thclass' 		=> 'left',  
	  	),*/
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

	protected $fieldpref = array('r_id', 'r_thumbnail', 'r_name', 'r_category', 'r_persons', 'r_time');

	// Preferences
	protected $preftabs = array(LAN_CB_PREF_TAB_DISPLAY, LAN_CB_PREF_TAB_POSTING, LAN_CB_PREF_TAB_RECIPE);

	protected $prefs = array(

		//0 - Display options
		'overview_format'	=> array(
			'title'	=> LAN_CB_PREF_OVERVIEWFORMAT,
			'type'	=> 'dropdown',
			'data' 	=> 'str',
			'help'	=> LAN_CB_PREF_OVERVIEWFORMAT_HELP,
			'tab'	=> 0,
		),
		'gridview_itemspp'	=> array(
			'title'	=> LAN_CB_PREF_GRIDVIEW_ITEMSPP,
			'type'	=> 'hidden',
			'data' 	=> 'int',
			'help'	=> LAN_CB_PREF_GRIDVIEW_ITEMSPP_HELP,
			'tab'	=> 0,
		),
		'gridview_sortorder' => array(
			'title'	=> LAN_CB_PREF_GRIDVIEW_SORTORDER,
			'type'	=> 'hidden',
			'data' 	=> 'str',
			'help'	=> LAN_CB_PREF_GRIDVIEW_SORTORDER_HELP,
			'tab'	=> 0,
		),
		'latest_itemspp' => array(
			'title'	=> LAN_CB_PREF_LATEST_ITEMSPP,
			'type'	=> 'number',
			'data' 	=> 'int',
			'help'	=> LAN_CB_PREF_LATEST_ITEMSPP_HELP,
			'tab'	=> 0,
		),
		'date_format' => array(
			'title'	=> LAN_CB_PREF_DATEFORMAT,
			'type'	=> 'dropdown',
			'data'	=> 'str',
			'help'	=> LAN_CB_PREF_DATEFORMAT_HELP,
			'tab'	=> 0,
		),
		'devmode' => array(
			'title'	=> "Developer mode (temporary)",
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> "Enables some functionalities that are work in progress. Will be removed soon.",
			'tab'	=> 0,
		),

		//1 - Posting options
		/*'submission_userclass'	=> array(
			'title'	=> 'Submission userclass',
			'type'	=> 'userclass',
			'data' 	=> 'str',
			'help'	=> 'Userclass that is allowed to submit new recipes',
			'tab'	=> 1,
		),*/
		'comments_enabled' => array(
			'title'	=> LAN_CB_PREF_COMMENTS,
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> LAN_CB_PREF_COMMENTS_HELP, // Comments class? - can only be on/off and 'anonymous' in core? See Admin Area > Comments Manager > Preferences // TODO; see if we can override this. 
			'tab'	=> 1,
		),
	
		// 2 - Recipe options:
		'recipe_authorrating' => array(
			'title'	=> LAN_CB_PREF_AUTHORRATING,
			'type'	=> 'boolean',
			'data' 	=> 'str',
			'help'	=> LAN_CB_PREF_AUTHORRATING_HELP,
			'tab'	=> 2,
		),
		'recipe_userrating' => array(
			'title'	=> LAN_CB_PREF_USERRATING,
			'type'	=> 'boolean',
			'data' 	=> 'str',
			'help'	=> LAN_CB_PREF_USERRATING_HELP,
			'tab'	=> 2,
		),
		'recipe_userratingclass' => array(
			'title'	=> LAN_CB_PREF_USERRATINGCLASS,
			'type'	=> 'userclass',
			'data' 	=> 'int',
			'help'	=> LAN_CB_PREF_USERRATINGCLASS_HELP,
			'tab'	=> 2,
		),
		'recipe_activetime' => array(
			'title'	=> LAN_CB_PREF_ACTIVETIME,
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> LAN_CB_PREF_ACTIVETIME_HELP,
			'tab'	=> 2,
		),
		'recipe_difficulty' => array(
			'title'	=> LAN_CB_PREF_DIFFICULTYLEVEL,
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> LAN_CB_PREF_DIFFICULTYLEVEL_HELP,
			'tab'	=> 2,
		),
		'recipe_showrelated' => array(
			'title'	=> LAN_CB_PREF_SHOWRELATED,
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> LAN_CB_PREF_SHOWRELATED_HELP,
			'tab'	=> 2,
		),
		'recipe_showprint' => array(
			'title'	=> LAN_CB_PREF_SHOWPRINT,
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> LAN_CB_PREF_SHOWPRINT_HELP,
			'tab'	=> 2,
		),
		'recipe_showbookmark' => array(
			'title'	=> LAN_CB_PREF_SHOWBOOKMARK,
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> LAN_CB_PREF_SHOWBOOKMARK_HELP,
			'tab'	=> 2,
		),
		'recipe_showsharing' => array(
			'title'	=> LAN_CB_PREF_SHOWSHARING,
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> LAN_CB_PREF_SHOWSHARING_HELP,
			'tab'	=> 2,
		),
		'recipe_ingredientcheckboxes' => array(
			'title'	=> LAN_CB_PREF_INGREDIENT_CHECKBOXES,
			'type'	=> 'boolean',
			'data'	=> 'int',
			'help'	=> LAN_CB_PREF_INGREDIENT_CHECKBOXES_HELP,
			'tab'	=> 2,
		),
	);

	protected $category = array();

	public function init()
	{
		$sql = e107::getDb();
		$pref = e107::pref('cookbook');


		// Link recipes with categories
		if($sql->select('cookbook_categories'))
		{
			while ($row = $sql->fetch())
			{
				$this->category[$row['c_id']] = $row['c_name'];
			}
		}

		$this->fields['r_category']['writeParms'] = $this->category;

		// Developer mode - enables some work-in-progress functionality
		/*if($pref['devmode'])
		{
			// Change type from 'hidden' to 'number'
			$this->fields['r_instructionsnew']['type'] = 'method';
		}*/


		// Author rating
		if($pref['recipe_authorrating'])
		{
			// Change type from 'hidden' to 'number'
			$this->fields['r_authorrating']['type'] = 'number';
		}

		// Active time
		if($pref['recipe_activetime'])
		{
			// Change type from 'hidden' to 'number'
			$this->fields['r_activetime']['type'] = 'number';
		}

		// Recipe difficulty 
		if($pref['recipe_difficulty'])
		{
			// Change type from 'hidden' to 'number'
			$this->fields['r_difficulty']['type'] = 'dropdown';

			$this->fields['r_difficulty']['writeParms'] = array(
				"1" 	=> LAN_CB_COMPLEX_EASY, 
				"2" 	=> LAN_CB_COMPLEX_MODERATE, 
				"3" 	=> LAN_CB_COMPLEX_HARD, 
			); 
		}


		// Preferences 
			// Date format: choose between 'long|short|relative', as defined in Preferences > Date Display options
			$this->prefs['date_format']['writeParms'] = array(
				"long" 		=> LAN_CB_PREF_DATEFORMAT_LONG, 
				"short" 	=> LAN_CB_PREF_DATEFORMAT_SHORT, 
				"relative" 	=> LAN_CB_PREF_DATEFORMAT_RELATIVE 
			); 

			// Overview format: allow to choose between a Grid overview or Datatables
			$this->prefs['overview_format']['writeParms'] = array(
				"overview_grid"			=> LAN_CB_PREF_OVERVIEWFORMAT_GRID,
				"overview_datatable" 	=> LAN_CB_PREF_OVERVIEWFORMAT_DATATABLES,
			); 

			// Grid overview: items per page
			if($pref['overview_format'] == "overview_grid")
			{
				// Change type from 'hidden' to 'number'
				$this->prefs['gridview_itemspp']['type'] = 'number';

				// Change type from 'hidden' to 'dropdown'
				$this->prefs['gridview_sortorder']['type'] = 'dropdown';

				// Set sorting order options
				$this->prefs['gridview_sortorder']['writeParms'] = array(
					"asc" 	=> LAN_CB_PREF_GRIDVIEW_SORTORDER_ASC,
					"desc" 	=> LAN_CB_PREF_GRIDVIEW_SORTORDER_DESC,
				); 
			}

	}

	// Make some adjustments before storing the new data in the database
	public function beforeCreate($new_data, $old_data)
	{
		// Process image thumbnails
		//$new_data['r_thumbnail'] = $this->processThumbs($new_data['r_thumbnail']);

		// Check if remote URL for recipe thumbnail is set. If yes, override the r_thumbnail field. 
		if(!empty($new_data['r_thumbnail_remote']))
		{
			$new_data['r_thumbnail'] = $new_data['r_thumbnail_remote'];
		}

		// Default recipe date is the creation date
		if(empty($new_data['r_datestamp']))
		{
			$new_data['r_datestamp'] = time();
		}

		// Default author rating set to 1 when an invalid value is detected
		if($new_data['r_authorrating'] >= 1 && $val <= 3)
		{
			$new_data['r_authorrating'] = 1;
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
		e107::getCache()->clear('cookbook_recipe_keywords');
	}

	// Make some adjustments before storing the updated data into the database
	public function beforeUpdate($new_data, $old_data, $id)
	{
		// Process image thumnails
		//$new_data['r_thumbnail'] = $this->processThumbs($new_data['r_thumbnail']);

		// Check if remote URL for recipe thumbnail is set. If yes, override the r_thumbnail field. 
		if(!empty($new_data['r_thumbnail_remote']))
		{
			$new_data['r_thumbnail'] = $new_data['r_thumbnail_remote'];
		}

		// Default recipe date is the creation date
		if(empty($new_data['r_datestamp']))
		{
			$new_data['r_datestamp'] = time();
		}

		// Default author rating set to 1 when an invalid value is detected
		if($new_data['r_authorrating'] >= 1 && $val <= 3)
		{
			$new_data['r_authorrating'] = 1;
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
		e107::getCache()->clear('cookbook_recipe_keywords');
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
		// do something
	}

	// For future use: multiple-images
	/*private function processThumbs($postedImage)
	{
		if(is_array($postedImage))
		{
			return implode(",", array_filter($postedImage));
		}
		else
		{
			return $postedImage;
		}
	}*/

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
	function r_thumbnail($curVal, $mode)
	{
		switch($mode)
		{
			// List Page
			case 'read': 
				return e107::getParser()->toImage($curVal);
				//break;

			// Edit Page
			case 'write': 

				if(strpos($curVal,'http') === 0)
				{
					$val1 = null;
					$val2 = $curVal;
				}
				else
				{
					$val1 = $curVal;
					$val2 = null;
				}

				$tab1 = $this->imagepicker('r_thumbnail', $val1, null, "media=cookbook_image");


				$tab2 = "<p>".$this->text('r_thumbnail_remote', $val2, 255, array('size' => 'xxlarge', 'placeholder' => LAN_CB_THUMBNAIL_REMOTE_PLACEHOLDER, 'title' => LAN_CB_THUMBNAIL_REMOTE_TITLE))."</p>";

				if(!empty($val2))
				{
					$tab2 .= e107::getParser()->toImage($val2);
				}

				$tabText = array(
					'local'  => array('caption' => LAN_CB_THUMBNAIL_LOCAL, 'text' => $tab1),
					'remote' => array('caption' => LAN_CB_THUMBNAIL_REMOTE, 'text' => $tab2),
				);

				return $this->tabs($tabText);
				//break;

			case 'filter':
			case 'batch':
				return "";
				//break;
		}

		return;
	}



	// Custom Method/Function 
	/*
	function r_instructionsnew($curVal, $mode)
	{
		$value = array();

		if(!empty($curVal))
		{
			$value = e107::unserialize($curVal);
		}

		 		
		switch($mode)
		{
			case 'read': // List Page

				if(empty($value))
				{
					return null;
				}

				$text = '';

				foreach($value as $row)
				{
					$text .= "<p>".e107::getParser()->toText($row['text'])." </p>";
				}
				
				return $text;

			break;
			
			case 'write': // Edit Page

				$amt = range(0,5); // TODO make this JS, allow to add new lines

				$text = "<table class='table table-condensed table-bordered' style='margin:0;'>
				<colgroup>
					<col style='width:5%' />
					<col />
					<col />
					<col />
				</colgroup>
				<tr>
					<th>#</th>
					<th class='text-center'>Instructions</th>
					<th>Time</th>
					<th>Image</th>
				</tr>";
				
				$count = 0; 

				foreach($amt as $v)
				{
					$count++; 

					$name = 'r_instructionsnew['.$v.']';
					$val = varset($value[$v], array());

					$text .= "<tr>
								<td>Step ".$count."</td>
								<td>".$this->bbarea($name.'[text]', varset($val['text']), '', '_common', 'small')."</td>
								<td>".$this->number($name.'[time]', varset($val['time']))."</td>
								<td>".$this->imagepicker($name.'[image]', varset($val['image']), '', 'media=cookbook_recipes')."</td>
							</tr>";

				}

				$text .= "</table>";


				return $text;
			break;
			
			case 'filter':
			case 'batch':
				return array();
			break;
		}
	}
	*/

	


	/*
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

			/*return $text;
		}
	}*/
}

new cookbook_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

e107::js('cookbook', 'plugins/iconpicker/js/bootstrap-iconpicker-iconset-all.min.js');
e107::js('cookbook', 'plugins/iconpicker/js/bootstrap-iconpicker.min.js');

require_once(e_ADMIN."footer.php");
exit;