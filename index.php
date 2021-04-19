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

// Load Cookbook class
require_once(e_PLUGIN."cookbook/cookbook_class.php");
$cbClass = new Cookbook();

// Load the LAN files
e107::lan('cookbook', false, true);

require_once(HEADERF);
$sql = e107::getDb();
$tp  = e107::getParser();

// Load template and shortcodes
$sc = e107::getScBatch('cookbook', true);
$template = e107::getTemplate('cookbook');
$template = array_change_key_case($template); // temporary fix until proper solution is found
$text = '';

/*
	Use $_GET to determine which view we are on, either:
	1. ID = indivual recipe (id = id)
	2. Category = specific category (category = id)
	3. Keyword (keyword = id)
	4. Keyword overview (keyword = 0)
	5. Category overview = all recipes split by category (category = 0)
	6. Recipe overview = index (no $_GET specified)
*/

$breadcrumb_array = array(); 

// Add Cookbook home to breadcrumb (default)
$breadcrumb_array[] = array(
	'text' 	=> LAN_CB_NAME, 
	'url' 	=> e107::url('cookbook', 'index'),
);

// Individual recipe
if(isset($_GET['id']))
{
	// Filter recipe id
	$rid = (int)$_GET['id'];

	// Retrieve all information of the individual recipe from the database
	if($recipe = $sql->retrieve("cookbook_recipes", "*", "r_id = '{$rid}'"))
	{
		// Set caption
		$caption 		= " - ".$recipe['r_name']; 

		// Pass database info onto the shortcodes
		$sc->setVars($recipe);

		// Display using template
		$text .= $tp->parseTemplate($template['recipe_item'], true, $sc);

		// Add breadcrumb data
		$cUrlparms = array(
			"category_id"  => $recipe['r_category'],
			"category_sef" => $cbClass->getCategoryName($recipe['r_category'], true),
		);

		$breadcrumb_array[] = array(
			'text' 	=> $cbClass->getCategoryName($recipe['r_category']),
			'url' 	=> e107::url('cookbook', 'category', $cUrlparms),
		);

		$rUrlparms = array(
			"recipe_id"  => $rid,
			"recipe_sef" => $recipe['r_name_sef'],
		);

		$breadcrumb_array[] = array(
			'text' 	=> $recipe['r_name'], 
			'url' 	=> e107::url('cookbook', 'id', $rUrlparms),
		);

	}
	// Recipe ID not found
	else
	{
		$text .= "<div class='alert alert-danger text-center'>".LAN_CB_RECIPENOTFOUND."</div>";
		// TODO notify admin?
	}
	
	// Send breadcrumb information
	e107::breadcrumb($breadcrumb_array);

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CB_RECIPE.$caption, $text);
}

// Individual category
elseif(isset($_GET['category']) && $_GET['category'] != 0)
{
	// Split and do some lookups do figure out category id and name.
	$category_full 	= e107::getParser()->toDb($_GET['category']);
	$category 		= explode('/', $category_full);
	$category_id 	= $category[0];
	$category_name 	= $sql->retrieve('cookbook_categories', 'c_name', 'c_id = '.$category_id.'');

	// Retrieve all recipe entries within this category
	$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_category = '.$category_id.'', true);

	$breadcrumb_array[] = array(
		'text' 	=> LAN_CATEGORIES,
		'url' 	=> e107::url('cookbook', 'categories'),
	);

	$cUrlparms = array(
		"category_id"  => $category_id,
		"category_sef" => $cbClass->getCategoryName($category_id, true),
	);

	$breadcrumb_array[] = array(
		'text' 	=> $cbClass->getCategoryName($category_id),
		'url' 	=> e107::url('cookbook', 'category', $cUrlparms),
	);

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
	// No recipes yet
	else
	{
		$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPESINCAT."</div>";
	}

	// Send breadcrumb information
	e107::breadcrumb($breadcrumb_array);

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CATEGORY." - ".$category_name, $text);
}

// Keyword
elseif(isset($_GET['keyword']) && $_GET['keyword'] != '0')
{
	$keyword = e107::getParser()->toDb($_GET['keyword']);

	// Retrieve all recipe entries with this keyword
	$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_keywords LIKE "%'.$keyword.'%"', TRUE);

	$breadcrumb_array[] = array(
		'text' 	=> LAN_KEYWORDS,
		'url' 	=> e107::url('cookbook', 'keywords'),
	);

	$breadcrumb_array[] = array(
		'text' 	=> $keyword,
		'url' 	=> e107::url('cookbook', 'keywords'),
	);

	// Check if there are recipes with this keyword
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
	// No recipes with this keyword
	else
	{
		$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPES."</div>";
	}

	// Send breadcrumb information
	e107::breadcrumb($breadcrumb_array);

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_KEYWORDS." - ".$keyword, $text);
}

// Keyword overview (tagcloud)
elseif(isset($_GET['keyword']) && $_GET['keyword'] == '0')
{
	$breadcrumb_array[] = array(
		'text' 	=> LAN_KEYWORDS,
		'url' 	=> e107::url('cookbook', 'keywords'),
	);

	// Send breadcrumb information
	e107::breadcrumb($breadcrumb_array);

	$text .= $tp->parseTemplate($template['keyword_overview'], true, $sc);
	e107::getRender()->tablerender(LAN_CB_KEYWORD_OVERVIEW, $text);
}

// Category overview
elseif(isset($_GET['category']) && $_GET['category'] == '0')
{
	// Retrieve all categories
	$categories = $sql->retrieve('cookbook_categories', '*', '', TRUE);

	// Loop through categories and display recipes for each category
	foreach($categories as $category)
	{
		$text .= "<h3>".$category['c_name']."</h3>";

		// Retrieve all recipe entries for this category
		$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_category = '.$category["c_id"].'', TRUE);

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
		// No recipes for this category, display info message
		else
		{
			$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPESINCAT."</div>";
		}
	}

	// Send breadcrumb information
	e107::breadcrumb($breadcrumb_array);

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CB_CATEGORY_OVERVIEW, $text);
}

// Recipe overview
else
{
	// Retrieve all recipe entries
	$recipes = $sql->retrieve('cookbook_recipes', '*', '', TRUE);

	// Check if there are recipes 
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
	// No recipes yet
	else
	{
		$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPES."</div>";
	}

	// Send breadcrumb information
	e107::breadcrumb($breadcrumb_array);

	// Let's render and show it all!
	e107::getRender()->tablerender(LAN_CB_RECIPE_OVERVIEW, $text);
}
require_once(FOOTERF);
exit;