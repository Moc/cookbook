<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Bookmarks
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

// Load the LAN files
e107::lan('cookbook', false, true);

require_once(HEADERF);

$text = '';

if(!USERID)
{
	$url = e107::url('cookbook', 'index');
	e107::redirect($url);
	exit;
}

$breadcrumb_array = array(
	array(
		'text' 	=> LAN_CB_NAME, 
		'url' 	=> e107::url('cookbook', 'index'),
	),
	array(
		'text' 	=> LAN_CB_BOOKMARKS, 
		'url' 	=> e107::url('cookbook', 'bookmarks'),
	),
);
// Retrieve bookmarks from database 
$bookmarks = e107::getDb()->retrieve('cookbook_bookmarks', '*', 'user_id = '.USERID.' ORDER BY bookmark_datestamp DESC', true);

// Check if there are bookmarks for this user
if($bookmarks)
{
	$recipes = array(); 

	foreach($bookmarks as $bookmark)
	{
		$r_id 		= $bookmark[ 'recipe_id']; 
		$recipes[] 	= e107::getDb()->retrieve('cookbook_recipes', '*', 'r_id = '.$r_id);
	}

	$text = $cookbook_class->renderOverviewTable($recipes);
}
else
{
	$text .= "<div class='alert alert-info text-center'>".LAN_CB_NOBOOKMARKS."</div>";
}	



// Send breadcrumb information
e107::breadcrumb($breadcrumb_array);

// Render
e107::getRender()->tablerender(LAN_CB_BOOKMARKS, $text);

require_once(FOOTERF);
exit;