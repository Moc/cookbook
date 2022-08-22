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

require_once(e_PLUGIN."cookbook/cookbook_class.php");
$cookbook_class = new cookbook; 

// Check if AJAX calls were made
if(e_AJAX_REQUEST)
{	
	// Check if 'bookmark' button was pressed
	if(varset($_POST['action']) == 'bookmark')
	{
		$cookbook_class->bookmarkRecipe(); 
	}
}

// Load the LAN files
e107::lan('cookbook', false, true);

e107::title(LAN_CB_NAME);
//e107::canonical('cookbook');


// Individual recipe - Set caption and metatags
if(isset($_GET['id']))
{
	$id 		= (int)$_GET['id']; 
	$title 		= $cookbook_class->getTitle($id);
	$recipedata = $cookbook_class->getRecipeData($id); 

	$description = e107::getParser()->toText($recipedata['r_summary']); 
	$description = str_replace("\n", ' ', $description);
	$description = e107::getParser()->truncate($description, 150);
	
	e107::meta('og:title', $title);
	e107::meta('og:url', e_SELF);
	e107::meta('og:description', $description);
	e107::meta('description', $description);
	e107::meta('twitter:url', e_SELF);

	$default_img 	= "{e_PLUGIN}cookbook/images/default_image.webp";
	$img 			= (!empty($recipedata['r_thumbnail']) ? $recipedata['r_thumbnail'] : $default_img);
	$mimg 			= $tp->thumbUrl($img, array('w' => 1200), false, true);

  	e107::meta('og:image', $mimg);
}

$caption = empty($title) ? LAN_CB_NAME : $title; 
define('e_PAGETITLE', $caption); 


// Include JQuery / Ajax code
e107::js('cookbook','js/cookbook.js', 'jquery', 5);


require_once(HEADERF);

// Individual recipe
if(isset($_GET['id']))
{
	e107::route('cookbook/recipe'); 
	$rid 	= (int)$_GET['id']; // Filter user input 
	$text 	= $cookbook_class->renderRecipe($rid); 

	e107::getRender()->tablerender(LAN_CB_RECIPE.$cookbook_class->caption, $text, "recipe-item");
}
// Individual category
elseif(isset($_GET['category']) && $_GET['category'] != 0)
{
	e107::route('cookbook/category'); 
	$categoryid = (int) $_GET['category']; 
	$text = $cookbook_class->renderCategory($categoryid);
	
	e107::getRender()->tablerender($cookbook_class->caption, $text);
}
// Category overview
elseif(isset($_GET['category']) && $_GET['category'] == '0')
{
	e107::route('cookbook/categories'); 
	$text = $cookbook_class->renderCategories();
	
	e107::getRender()->tablerender(LAN_CB_CATEGORY_OVERVIEW, $text);
}
// Individual keyword
elseif(isset($_GET['keyword']) && $_GET['keyword'] != '0')
{
	e107::route('cookbook/keyword'); 
	$keyword 	= e107::getParser()->toDb($_GET['keyword']);
	$text 		= $cookbook_class->renderKeyword($keyword);
		
	e107::getRender()->tablerender(LAN_KEYWORDS." - ".$keyword, $text);
}
// Keyword overview (tagcloud)
elseif(isset($_GET['keyword']) && $_GET['keyword'] == '0')
{
	e107::route('cookbook/keywords'); 
	$text = $cookbook_class->renderKeywordOverview();
	e107::getRender()->tablerender(LAN_CB_KEYWORD_OVERVIEW, $text);
	
}
// Latest recipes
elseif(isset($_GET['p']) && $_GET['p'] == 'latest')
{
	e107::route('cookbook/latest'); 
	$text = $cookbook_class->renderLatestRecipes();
	e107::getRender()->tablerender(LAN_CB_RECIPE_LATEST, $text);
}
// Recipe overview (home)
else
{
	e107::route('cookbook/index'); 
	$text = $cookbook_class->renderRecipeOverview();

	e107::getRender()->tablerender(LAN_CB_RECIPE_OVERVIEW, $text);
}


require_once(FOOTERF);
exit; 