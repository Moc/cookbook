<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Admin language file
*/

define("LAN_CB_MANAGE_RECIPES",  	"Recepten overzicht");
define("LAN_CB_CREATE_RECIPE",  	"Voeg een recept toe");

define("LAN_CB_THUMBNAIL_LOCAL", "Lokaal");
define("LAN_CB_THUMBNAIL_REMOTE", "Extern");
define("LAN_CB_THUMBNAIL_REMOTE_PLACEHOLDER", "bijv.. http://een-website.nl/afbeelding.jpg");
define("LAN_CB_THUMBNAIL_REMOTE_TITLE", "Dit zal een lokale afbeelding die ingesteld is overschrijven.");

// HELP
define("LAN_CB_HELP_ACTIVETIME",    "Actieve bereidingstijd in minuten.");
define("LAN_CB_HELP_TOTALTIME",     "Totale bereidingstijd in minuten.");
define("LAN_CB_HELP_PERSONS", 		"Aantal personen");
define("LAN_CB_HELP_KEYWORDS", 		"Keywords die bij dit recept passen");
define("LAN_CB_HELP_AUTHORRATING",  "Beoordeling van het recept door de auteur. Tussen de 1 en 3 sterren.");
define("LAN_CB_HELP_DIFFICULTY",	"De moeilijkheidsgraad van een recept: makkelijk, gemiddeld, complex.");
define("LAN_CB_HELP_SUMMARY",       "Samenvatten van het recept.");

// PREFS
    // TABS
define("LAN_CB_PREF_TAB_DISPLAY", "Weergave opties"); 
define("LAN_CB_PREF_TAB_POSTING", "Post opties"); 
define("LAN_CB_PREF_TAB_RECIPE", "Recept opties"); 

    //0 - Display options
define("LAN_CB_PREF_OVERVIEWFORMAT",        "Overzicht weergave"); 
define("LAN_CB_PREF_OVERVIEWFORMAT_HELP",   "Gebruik 'Grid view' of 'DataTables'"); 

define("LAN_CB_PREF_OVERVIEWFORMAT_GRID",        "Grid weergave"); 
define("LAN_CB_PREF_OVERVIEWFORMAT_DATATABLES",  "DataTables weergave");

define("LAN_CB_PREF_GRIDVIEW_ITEMSPP",      "Grid weergave: items per pagina"); 
define("LAN_CB_PREF_GRIDVIEW_ITEMSPP_HELP", "Aantal recepten die getoond worden per pagina (wanneer 'Grid weergave' gebruikt wordt)");

define("LAN_CB_PREF_GRIDVIEW_SORTORDER",      "Grid weergave: soorteervolgorde"); 
define("LAN_CB_PREF_GRIDVIEW_SORTORDER_HELP", "Toon recepten oplopend (oudste recepten eerst) of aflopend (nieuwste recepten eerst)");

define("LAN_CB_PREF_GRIDVIEW_SORTORDER_ASC", "Oudste recepten eerst"); 
define("LAN_CB_PREF_GRIDVIEW_SORTORDER_DESC", "Nieuwste recepten eerst"); 

define("LAN_CB_PREF_LATEST_ITEMSPP",        "Recente recepten: items per pagina");
define("LAN_CB_PREF_LATEST_ITEMSPP_HELP",   "Definieert het aantal recepten dat op de 'meest recente recepten' pagina wordt getoond");

define("LAN_CB_PREF_DATEFORMAT",        "Datumnotitie"); 
define("LAN_CB_PREF_DATEFORMAT_HELP",   "Gebruik de datumnotitie zoals ingesteld bij Beheerscherm > Voorkeuren > Datumweergave");
define("LAN_CB_PREF_DATEFORMAT_LONG",   "Lange datumnotatie");
define("LAN_CB_PREF_DATEFORMAT_SHORT",   "Korte datumnotatie");
define("LAN_CB_PREF_DATEFORMAT_RELATIVE", "Relatieve datumnotatie");

    //1 - Posting options
define("LAN_CB_PREF_COMMENTS",      "Commentaar op recepten");
define("LAN_CB_PREF_COMMENTS_HELP", "Gebruikers kunnen commentaar posten bij recepten");

    //2 - Recipe options:
define("LAN_CB_PREF_AUTHORRATING",      "Auteur beoordeling");
define("LAN_CB_PREF_AUTHORRATING_HELP", "Recept auteurs kunnen hun eigen recepten beoordelen");

define("LAN_CB_PREF_USERRATING",      "Gebruikersbeoordeling");
define("LAN_CB_PREF_USERRATING_HELP", "Gebruikers kunnen recepten beoordelen");

define("LAN_CB_PREF_USERRATINGCLASS",      "Gebruikersbeoordeling klasse");
define("LAN_CB_PREF_USERRATINGCLASS_HELP", "Deze groep gebruikers kunnen recepten beoordelen");

define("LAN_CB_PREF_DIFFICULTYLEVEL",      "Gebruik moeilijkheidsgraad");
define("LAN_CB_PREF_DIFFICULTYLEVEL_HELP", "Recepten kunnen drie moeilijksheidsgraden hebben: eenvoudig, gemiddeld, moeilijk");

define("LAN_CB_PREF_SHOWRELATED",      "Gerelateerde recepten");
define("LAN_CB_PREF_SHOWRELATED_HELP", "Laat recepten gerelateerd aan het huidige recept zien");

define("LAN_CB_PREF_ACTIVETIME",      "Gebruik actieve tijd");
define("LAN_CB_PREF_ACTIVETIME_HELP", "Recepten kunnen naast de totale tijd, ook de benodigde actieve tijd specificeren.");

define("LAN_CB_PREF_SHOWPRINT",      "Print optie");
define("LAN_CB_PREF_SHOWPRINT_HELP", "Gebruikers hebben de mogelijkheid om een print-vriendelijke versie van het recept te printen");

define("LAN_CB_PREF_SHOWBOOKMARK",      "Bladwijzer optie");
define("LAN_CB_PREF_SHOWBOOKMARK_HELP", "Gebruikers kunnen een bladwijzer maken van een recept");

define("LAN_CB_PREF_SHOWSHARING",      "Deel opties");
define("LAN_CB_PREF_SHOWSHARING_HELP", "Gebruikers krijgen de optie om een recept te delen vai verschillende (social) media");