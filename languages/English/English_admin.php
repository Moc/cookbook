<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Admin language file
*/

define("LAN_CB_MANAGE_RECIPES",  	"Recipe overview");
define("LAN_CB_CREATE_RECIPE",  	"Add a recipe");


// HELP 
define("LAN_CB_HELP_TIME", 			"Preparation time of the recipe (in minutes).");
define("LAN_CB_HELP_PERSONS", 		"Amount of people that the recipe is for.");
define("LAN_CB_HELP_KEYWORDS", 		"Keywords that are applicable to the recipe.");
define("LAN_CB_HELP_AUTHORRATING",  "Author rating of the recipe. Between 1 and 3 stars.");
define("LAN_CB_HELP_DIFFICULTY",	"The difficulty level of a recipe: easy, moderate, hard");
define("LAN_CB_HELP_SUMMARY",       "Summary of the recipe.");

// PREFS
    // TABS
define("LAN_CB_PREF_TAB_DISPLAY", "Display options"); 
define("LAN_CB_PREF_TAB_POSTING", "Posting options"); 
define("LAN_CB_PREF_TAB_RECIPE", "Recipe options"); 

    //0 - Display options
define("LAN_CB_PREF_OVERVIEWFORMAT",        "Overview format"); 
define("LAN_CB_PREF_OVERVIEWFORMAT_HELP",   "Use 'Grid view' or 'DataTables'"); 

define("LAN_CB_PREF_OVERVIEWFORMAT_GRID",        "Grid overview"); 
define("LAN_CB_PREF_OVERVIEWFORMAT_DATATABLES",  "DataTable overview");

define("LAN_CB_PREF_GRIDVIEW_ITEMSPP",      "Grid overview: items per page"); 
define("LAN_CB_PREF_GRIDVIEW_ITEMSPP_HELP", "Number of recipes that are shown per page (when using Grid view)");

define("LAN_CB_PREF_GRIDVIEW_SORTORDER",      "Grid overview: Sorting order"); 
define("LAN_CB_PREF_GRIDVIEW_SORTORDER_HELP", "Order recipes ascending (oldest recipes first) or descending (newest recipes first)");

define("LAN_CB_PREF_GRIDVIEW_SORTORDER_ASC", "Oldest recipes first"); 
define("LAN_CB_PREF_GRIDVIEW_SORTORDER_DESC", "Newest recipes first"); 

define("LAN_CB_PREF_LATEST_ITEMSPP",        "Latest recipes: items per page");
define("LAN_CB_PREF_LATEST_ITEMSPP_HELP",   "Defines how many recipes are shown on the 'latest recipes' page");

define("LAN_CB_PREF_DATEFORMAT",        "Date format"); 
define("LAN_CB_PREF_DATEFORMAT_HELP",   "Uses the format defined in Admin Area > Preferences > Date Display options");

    //1 - Posting options
define("LAN_CB_PREF_COMMENTS",      "Comments on recipes");
define("LAN_CB_PREF_COMMENTS_HELP", "When enabled, users can comment on recipes");

    //2 - Recipe options:
define("LAN_CB_PREF_AUTHORRATING",      "Author rating");
define("LAN_CB_PREF_AUTHORRATING_HELP", "When enabled, recipe authors can rate their own recipes");

define("LAN_CB_PREF_USERRATING",      "User rating");
define("LAN_CB_PREF_USERRATING_HELP", "When enabled, users can rate recipes");

define("LAN_CB_PREF_USERRATINGCLASS",      "User rating class");
define("LAN_CB_PREF_USERRATINGCLASS_HELP", "Userclass that is allowed to rate recipes");

define("LAN_CB_PREF_DIFFICULTYLEVEL",      "Use difficulty levels");
define("LAN_CB_PREF_DIFFICULTYLEVEL_HELP", "When enabled, recipes can have three difficulty levels: easy, moderate, hard");

define("LAN_CB_PREF_SHOWRELATED",      "Show related recipes");
define("LAN_CB_PREF_SHOWRELATED_HELP", "When enabled, other recipes related to the recipe that is being viewed are shown");

define("LAN_CB_PREF_SHOWPRINT",      "Show print option");
define("LAN_CB_PREF_SHOWPRINT_HELP", "When enabled, users will have the option to print a print-friendly version of the recipe");

define("LAN_CB_PREF_SHOWBOOKMARK",      "Show bookmark option");
define("LAN_CB_PREF_SHOWBOOKMARK_HELP", "When enabled, users will have the option to bookmark specific recipes");

define("LAN_CB_PREF_SHOWSHARING",      "Show sharing options");
define("LAN_CB_PREF_SHOWSHARING_HELP", "When enabled, users will have the option to share a recipe on several (social) media");