<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Main frontend
*/

if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

// Make this page inaccessible when plugin is not installed.
if (!e107::isInstalled('cookbook'))
{
	e107::redirect();
	exit;
}

class cookbook_front
{
	protected $breadcrumb_array = array();
	
	function __construct()
	{
		// Add Cookbook home to breadcrumb (default)
		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_CB_NAME, 
			'url' 	=> e107::url('cookbook', 'index'),
		);

		// Initalize
		$this->init();
	}

	function init()
	{
		// Individual recipe
		if(isset($_GET['id']))
		{
			$rid = (int)$_GET['id']; // Filter user input 
			$this->renderRecipe($rid); // Trigger the method to render an individual recipe 
			return;
		}

		// Individual category
		if(isset($_GET['category']) && $_GET['category'] != 0)
		{
			$data = $_GET['category']; 
			$this->renderCategory($data); // Trigger the method to render an individual recipe 
			return;
		}

		// Category overview
		if(isset($_GET['category']) && $_GET['category'] == '0')
		{
			$this->renderCategories();
			return;
		}

		// Individual keyword
		if(isset($_GET['keyword']) && $_GET['keyword'] != '0')
		{
			$keyword = e107::getParser()->toDb($_GET['keyword']);
			$this->renderKeyword($keyword);
		}

		// Keyword overview (tagcloud)
		if(isset($_GET['keyword']) && $_GET['keyword'] == '0')
		{
			$this->renderKeywords();
			return;
		}

		// Recipe overview (home)
		$this->renderRecipeOverview();
		return;
	}

	// Renders an individual recipe
	private function renderRecipe($rid = '')
	{
		$text = '';

		// Retrieve all information of the individual recipe from the database
		if($data = e107::getDb()->retrieve("cookbook_recipes", "*", "r_id = '{$rid}'"))
		{
			// Set caption
			$caption 		= " - ".$data['r_name']; // TODO make this customizable

			// Add breadcrumb data
			$cUrlparms = array(
				"category_id"  => $data['r_category'],
				"category_sef" => $this->getCategoryName($data['r_category'], true),
			);

			$this->breadcrumb_array[] = array(
				'text' 	=> $this->getCategoryName($data['r_category']),
				'url' 	=> e107::url('cookbook', 'category', $cUrlparms),
			);

			$rUrlparms = array(
				"recipe_id"  => $rid,
				"recipe_sef" => $data['r_name_sef'],
			);

			$this->breadcrumb_array[] = array(
				'text' 	=> $data['r_name'], 
				'url' 	=> e107::url('cookbook', 'id', $rUrlparms),
			);

			// Load shortcode
			$sc = e107::getScBatch('cookbook', true);

			// Pass database info onto the shortcodes
			$sc->setVars($data);

			// Load template
			$LAYOUT = e107::getTemplate('cookbook', 'cookbook', 'recipe_layout');

			// Render recipe content
			$recipe_content = $this->loadRecipeContent($data);

			// Render recipe info
			$recipe_info = $this->loadRecipeInfo($data);

			// Replace template placheolders with recipe content and recipe information
			$LAYOUT = str_replace(
				['{---RECIPE-CONTENT---}', '{---RECIPE-INFO---}'],
				[$recipe_content, $recipe_info],
				$LAYOUT
			);

			$text .= e107::getParser()->parseTemplate($LAYOUT, true, $sc);
		}
		else
		{
			$text .= "<div class='alert alert-danger text-center'>".LAN_CB_RECIPENOTFOUND."</div>"; // TODO notify admin?
		}

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);
		
		// Render it
		e107::getRender()->tablerender(LAN_CB_RECIPE.$caption, $text, "recipe-item");
	}

	private function loadRecipeContent($data)
	{
		// Load shortcodes
		$sc = e107::getScBatch('cookbook', true);

		// Pass data
		$sc->setVars($data);

		// Set wrapper
		$sc->wrapper('cookbook/recipe_content');

		$RECIPE_CONTENT = e107::getTemplate('cookbook', 'cookbook', 'recipe_content');

		return e107::getParser()->parseTemplate($RECIPE_CONTENT, true, $sc);
	}

	private function loadRecipeInfo($data)
	{
		// Load shortcodes
		$sc = e107::getScBatch('cookbook', true);

		// Pass data
		$sc->setVars($data);

		// Set wrapper
		$sc->wrapper('cookbook/recipe_info');

		$RECIPE_INFO = e107::getTemplate('cookbook', 'cookbook', 'recipe_info');

		return e107::getParser()->parseTemplate($RECIPE_INFO, true, $sc);
	}

	private function renderCategory($data)
	{
		$sql 	= e107::getDb();
		$tp 	= e107::getParser();
		$text 	= '';

		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_CATEGORIES,
			'url' 	=> e107::url('cookbook', 'categories'),
		);

		// Split and do some lookups do figure out category id and name.
		$category_full 	= e107::getParser()->toDb($data);
		$category 		= explode('/', $category_full);
		$category_id 	= (int)$category[0];
		$category_name 	= e107::getDb()->retrieve('cookbook_categories', 'c_name', 'c_id = '.$category_id.'');
		
		if($category_name)
		{
			$caption = LAN_CATEGORY." - ".$category_name;

			// Retrieve all recipe entries within this category
			$recipes = e107::getDb()->retrieve('cookbook_recipes', '*', 'r_category = '.$category_id.'', true);

			$cUrlparms = array(
				"category_id"  => $category_id,
				"category_sef" => $this->getCategoryName($category_id, true),
			);

			$this->breadcrumb_array[] = array(
				'text' 	=> $this->getCategoryName($category_id),
				'url' 	=> e107::url('cookbook', 'category', $cUrlparms),
			);

			// Load shortcode
			$sc = e107::getScBatch('cookbook', true);

			// Check if there are recipes in this category
			if($recipes)
			{
			 	$text .= $tp->parseTemplate($template['overview']['start'], true, $sc);

				foreach($recipes as $recipe)
				{
					// Pass query values onto the shortcodes
					$sc->setVars($recipe);
					$text .= $tp->parseTemplate($template['overview']['items'], true, $sc);
				}

				$text .= $tp->parseTemplate($template['overview']['end'], true, $sc);
			}
			// No recipes in this category yet
			else
			{
				$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPESINCAT."</div>";
			}
		}
		else
		{
			$caption = LAN_CB_NAME." - ".LAN_ERROR;
			$text .= "Category not found"; // TODO LAN
		}

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		// Let's render and show it all!
		e107::getRender()->tablerender($caption, $text);
	}

	private function renderCategories()
	{
		$sql 	= e107::getDb();
		$tp 	= e107::getParser();
		$text 	= '';

		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_CATEGORIES,
			'url' 	=> e107::url('cookbook', 'categories'),
		);

		// Retrieve all categories
		if($categories = $sql->retrieve('cookbook_categories', '*', '', TRUE))
		{
			// Loop through categories and display recipes for each category
			foreach($categories as $category)
			{
				$text .= "<h3>".$category['c_name']."</h3>";

				// Retrieve all recipe entries for this category
				$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_category = '.$category["c_id"].'', TRUE);

				// Check if there are recipes in this category
				if($recipes)
				{
					// Load shortcode
					$sc = e107::getScBatch('cookbook', true);

				 	$text .= $tp->parseTemplate($template['overview']['start'], true, $sc);

					foreach($recipes as $recipe)
					{
						// Pass query values onto the shortcodes
						$sc->setVars($recipe);
						$text .= $tp->parseTemplate($template['overview']['items'], true, $sc);
					}

					$text .= $tp->parseTemplate($template['overview']['end'], true, $sc);
				}
				// No recipes for this category, display info message
				else
				{
					$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPESINCAT."</div>";
				}
			}
		}
		else
		{
			$text .= "<div class='alert alert-info text-center'>".LAN_CB_NOCATEGORIESYET."</div>"; // TODO LAN
		}
		

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		// Let's render and show it all!
		e107::getRender()->tablerender(LAN_CB_CATEGORY_OVERVIEW, $text);
	}

	public function renderKeyword($keyword)
	{
		$sql 	= e107::getDb();
		$tp 	= e107::getParser();
		$text 	= '';

		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		// Retrieve all recipe entries with this keyword
		$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_keywords LIKE "%'.$keyword.'%"', TRUE);

		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_KEYWORDS,
			'url' 	=> e107::url('cookbook', 'keywords'),
		);

		$kUrlparms = array(
			"keyword"  => $keyword,
		);

		$this->breadcrumb_array[] = array(
			'text' 	=> $keyword,
			'url' 	=> e107::url('cookbook', 'keyword', $kUrlparms),
		);

		// Check if there are recipes with this keyword
		if($recipes)
		{
			$sc = e107::getScBatch('cookbook', true);

		 	$text .= $tp->parseTemplate($template['overview']['start'], true, $sc);

			foreach($recipes as $recipe)
			{
				// Pass query values onto the shortcodes
				$sc->setVars($recipe);
				$text .= $tp->parseTemplate($template['overview']['items'], true, $sc);
			}

			$text .= $tp->parseTemplate($template['overview']['end'], true, $sc);
		}
		// No recipes with this keyword
		else
		{
			$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPES."</div>";
		}

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		// Let's render and show it all!
		e107::getRender()->tablerender(LAN_KEYWORDS." - ".$keyword, $text);
	}

	public function renderKeywords()
	{
		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		$sc = e107::getScBatch('cookbook', true);

		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_KEYWORDS,
			'url' 	=> e107::url('cookbook', 'keywords'),
		);

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		$text = e107::getParser()->parseTemplate($template['keyword_overview'], true, $sc);
		
		e107::getRender()->tablerender(LAN_CB_KEYWORD_OVERVIEW, $text);
	}

	public function renderRecipeOverview()
	{
		$sql 	= e107::getDb();
		$tp 	= e107::getParser();
		$text 	= '';

		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		// Retrieve all recipe entries
		$recipes = $sql->retrieve('cookbook_recipes', '*', '', TRUE);

		// Check if there are recipes 
		if($recipes)
		{
			$sc = e107::getScBatch('cookbook', true);

		 	$text .= $tp->parseTemplate($template['overview']['start'], true, $sc);

			foreach($recipes as $recipe)
			{
				// Pass query values onto the shortcodes
				$sc->setVars($recipe);
				$text .= $tp->parseTemplate($template['overview']['items'], true, $sc);
			}

			$text .= $tp->parseTemplate($template['overview']['end'], true, $sc);
		}
		// No recipes yet
		else
		{
			$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPES."</div>";
		}

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		// Let's render and show it all!
		e107::getRender()->tablerender(LAN_CB_RECIPE_OVERVIEW, $text);
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

// Load the LAN files
e107::lan('cookbook', false, true);

e107::title(LAN_CB_NAME);
e107::canonical('cookbook');
e107::route('cookbook/index');  

require_once(HEADERF);

new cookbook_front;

require_once(FOOTERF);
exit; 