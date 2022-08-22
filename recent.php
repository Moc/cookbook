<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Recently added recipes
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

// Load the LAN files
e107::lan('cookbook', false, true);

require_once(HEADERF);
$sql = e107::getDb();
$tp  = e107::getParser();

// Load shortcodes
$sc = e107::getScBatch('cookbook', TRUE);

// Load template
$key = e107::getPlugPref('cookbook', 'overview_format', 'overview_grid'); 
$template = e107::getTemplate('cookbook', null, $key);
$template = array_change_key_case($template);

$text = '';

// Retrieve the 10 most recently added recipes 
$recipes = e107::getDb()->retrieve('cookbook_recipes', '*', 'ORDER BY r_datestamp DESC LIMIT 0,10', true);

// Check if there are recipes in this category
if($recipes)
{
 	$text .= $tp->parseTemplate($template['start'], true, $sc);

	foreach($recipes as $recipe)
	{
		// Pass query values onto the shortcodes
		$sc->setVars($recipe);
		$text .= $tp->parseTemplate($template['items'], true, $sc);
	}

	$text .= $tp->parseTemplate($template['end'], true, $sc);
}
	
e107::getRender()->tablerender(LAN_CB_RECIPE_RECENT, $text);

require_once(FOOTERF);
exit;