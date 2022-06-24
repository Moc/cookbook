<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Header file to include javascript and css
*/

if (!defined('e107_INIT')) { exit; }

if(defset('e_CURRENT_PLUGIN') == "cookbook" && e107::isInstalled('cookbook')) 
{
    $cookbook_page = true;
}

// Code is only needed on frontend cookbook pages
if(USER_AREA && $cookbook_page)
{
	// Raty plugin
	e107::js('cookbook', 'plugins/raty/jquery.raty.js', 'jquery');

	// Tagcloud plugin
	e107::css('cookbook', 'plugins/tagcloud/jqcloud.css');
	e107::js('cookbook', 'plugins/tagcloud/jqcloud-1.0.4.min.js', 'jquery');

	// Datatables plugin
	if(defined('BOOTSTRAP') && BOOTSTRAP === 3)
	{
		e107::css('cookbook', 'plugins/datatables/css/datatables-bs3.min.css');
		e107::js('cookbook', 'plugins/datatables/js/datatables-bs3.min.js');
	}
	elseif(defined('BOOTSTRAP') && BOOTSTRAP === 4)
	{
		e107::css('cookbook', 'plugins/datatables/css/datatables-bs4.min.css');
		e107::js('cookbook', 'plugins/datatables/js/datatables-bs4.min.js');
	}
	else
	{
		e107::css('cookbook', 'plugins/datatables/css/datatables.min.css');
		e107::js('cookbook', 'plugins/datatables/js/datatables.min.js');
	}

	// DataTables language files
	$system_lan		= e_PLUGIN."cookbook/plugins/datatables/languages/".e_LANGUAGE.".json";
	$default_lan 	= e_PLUGIN_ABS."cookbook/plugins/datatables/languages/English.json";
	$dt_lan_file 	= (file_exists($system_lan) ? $system_lan : $default_lan);

	$order = "order: [[4, 'desc']],";

	if(defset('e_ROUTE') === "cookbook/recent")
	{
		$order = "order: [],";
	}
	

	e107::js('inline',
	"
		$(document).ready(function() {
		    $('table.recipes').dataTable( {
		    	".$order."
		        columnDefs: [
		        	{orderable: false, targets: 0},
				   	{orderable: false, targets: 5},
				],
				language: {
        			url: '".$dt_lan_file."'
   				}
		    });
		});
	");

	// General CSS styling
	e107::css('cookbook', 'cookbook_style.css');
}