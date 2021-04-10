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

if (strpos(e_REQUEST_SELF, 'recepten') !== false || strpos(e_REQUEST_SELF, 'cookbook') !== false )
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
	e107::css('cookbook', 'plugins/datatables/css/dataTables.bootstrap.css');
	e107::css('cookbook', 'plugins/datatables/css/dataTables.responsive.css');

	// DataTables language files
	// $system_lan		= e_PLUGIN."cookbook/plugins/datatables/languages/".e_LANGUAGE.".json";
	// $default_lan 	= e_PLUGIN."cookbook/plugins/datatables/languages/English.json";
	// $dt_lan_file 	= (file_exists($system_lan) ? $system_lan : $default_lan);

	if(file_exists(e_PLUGIN."cookbook/plugins/datatables/languages/".e_LANGUAGE.".json"))
	{
		$dt_lan_file = e_PLUGIN_ABS."cookbook/plugins/datatables/languages/".e_LANGUAGE.".json";
	}
	else
	{
		$dt_lan_file = e_PLUGIN_ABS."cookbook/plugins/datatables/languages/English.json";
	}

	e107::js('cookbook', 'plugins/datatables/js/jquery.dataTables.min.js', 'jquery');
	e107::js('cookbook', 'plugins/datatables/js/dataTables.responsive.min.js', 'jquery');
	e107::js('cookbook', 'plugins/datatables/js/dataTables.bootstrap.js', 'jquery');
	e107::js('inline',
	"
		$(document).ready(function() {
		    $('table.recipes').dataTable( {
		    	order: [[5, 'desc']],
		    	responsive: {
		            details: {
		                type: 'column',
		                target: 0
		            }
		        },
		        columnDefs: [
		        	{className: 'control', orderable: false, targets: 0},
				   	{orderable: false, targets: 6},
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