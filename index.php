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
if(isset($_GET['p']) && $_GET['p'] == 'id' && $_GET['id'])
{	
	$id = (int)$_GET['id']; 
	$cookbook_class->setRecipeMeta($id); 
	$title = $cookbook_class->getTitle($id);
}

$caption = empty($title) ? LAN_CB_NAME : $title; 
define('e_PAGETITLE', $caption); 


// Include JQuery / Ajax code
e107::js('cookbook','js/cookbook.js', 'jquery', 5);


require_once(HEADERF);

// NEXTPREV - SET "FROM" to 1 IF NOT SET
// TODO CLEAN THIS UP
$overview_format = e107::getPlugPref('cookbook', 'overview_format', 'overview_grid'); 
if($overview_format == "overview_grid")
{
	$parm = array();
	$from = empty($_GET['from']) ? 1 : (int) $_GET['from'];
	
	$parm['from'] = $from; 
}

// Individual recipe
if(isset($_GET['p']) && $_GET['p'] == 'id' && $_GET['id'])
{
	e107::route('cookbook/recipe'); 
	$rid 	= (int)$_GET['id']; // Filter user input 
	$text 	= $cookbook_class->renderRecipe($rid); 

	e107::getRender()->tablerender(LAN_CB_RECIPE.$cookbook_class->caption, $text, "recipe-item");
}
// Individual category
elseif(isset($_GET['p']) && $_GET['p'] == 'category' && isset($_GET['category']))
{
	e107::route('cookbook/category'); 
	$category = (int) $_GET['category']; 
	$text = $cookbook_class->renderCategory($category, $parm);
	
	e107::getRender()->tablerender($cookbook_class->caption, $text);
}
// Category overview
elseif(isset($_GET['p']) && $_GET['p'] == 'categories')
{
	e107::route('cookbook/categories'); 
	$text = $cookbook_class->renderCategories();
	
	e107::getRender()->tablerender(LAN_CB_CATEGORY_OVERVIEW, $text);
}
// Individual keyword
elseif(isset($_GET['p']) && $_GET['p'] == 'keyword' && $_GET['keyword'])
{
	e107::route('cookbook/keyword'); 
	$keyword 	= e107::getParser()->filter($_GET['keyword']);
	$keyword 	= preg_split("#/#", $keyword); 
	$text 		= $cookbook_class->renderKeyword($keyword[0], $parm);
		
	e107::getRender()->tablerender(LAN_KEYWORDS." - ".$keyword[0], $text);
}
// Keyword overview (tagcloud)
elseif(isset($_GET['p']) && $_GET['p'] == 'keywords')
{
	e107::route('cookbook/keywords'); 
	$text = $cookbook_class->renderKeywordOverview();

	e107::getRender()->tablerender(LAN_CB_KEYWORD_OVERVIEW, $text);
}
// Latest recipes
elseif(isset($_GET['p']) && $_GET['p'] == 'latest')
{
	e107::route('cookbook/latest'); 
	$text = $cookbook_class->renderLatestRecipes($parm);

	e107::getRender()->tablerender(LAN_CB_RECIPE_LATEST, $text);
}
// Bookmarks
elseif(isset($_GET['p']) && $_GET['p'] == 'bookmarks')
{
	e107::route('cookbook/bookmarks'); 
	$text = $cookbook_class->renderBookmarks($parm);

	e107::getRender()->tablerender(LAN_CB_BOOKMARKS, $text);
}
// Recipe overview (home)
else
{
	e107::route('cookbook/index'); 
	$text = $cookbook_class->renderRecipeOverview($parm);

	e107::getRender()->tablerender(LAN_CB_RECIPE_OVERVIEW, $text);
}


require_once(FOOTERF);
exit; 