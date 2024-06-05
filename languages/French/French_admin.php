<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Admin language file
*/

define("LAN_CB_MANAGE_RECIPES",     "Aperçu des recettes");
define("LAN_CB_CREATE_RECIPE",      "Ajouter une recette");


// HELP
define("LAN_CB_HELP_TIME",          "Temps de préparation de la recette (en minutes).");
define("LAN_CB_HELP_PERSONS",       "Nombre de personnes pour lesquelles la recette est destinée.");
define("LAN_CB_HELP_KEYWORDS",      "Mots-clé applicables à la recette");
define("LAN_CB_HELP_AUTHORRATING",  "Note de l'auteur. Entre 1 et 3 étoiles.");
define("LAN_CB_HELP_DIFFICULTY",    "Niveau de difficulté de la recette: facile, moyen, difficile");
define("LAN_CB_HELP_SUMMARY",       "Résumé de la recette");

// PREFS
    // TABS
define("LAN_CB_PREF_TAB_DISPLAY", "Options d'affichage");
define("LAN_CB_PREF_TAB_POSTING", "Options de messages");
define("LAN_CB_PREF_TAB_RECIPE", "Options des recettes");

    //0 - Display options
define("LAN_CB_PREF_OVERVIEWFORMAT",        "Format de l'aperçu");
define("LAN_CB_PREF_OVERVIEWFORMAT_HELP",   "Utiliser la 'vue en mode grille' ou la 'vue en mode table'");

define("LAN_CB_PREF_OVERVIEWFORMAT_GRID",        "Aperçu en grille");
define("LAN_CB_PREF_OVERVIEWFORMAT_DATATABLES",  "Aperçu en table");

define("LAN_CB_PREF_GRIDVIEW_ITEMSPP",      "Aperçu en grille: recettes par page");
define("LAN_CB_PREF_GRIDVIEW_ITEMSPP_HELP", "Nombre de recettes visualisées par page (en mode Grille)");

define("LAN_CB_PREF_GRIDVIEW_SORTORDER",      "Aperçu en grille: Ordre de tri");
define("LAN_CB_PREF_GRIDVIEW_SORTORDER_HELP", "Trier les recettes par ordre croissant (les plus anciens en premier) ou décroissant (les plus récentes en premier)");

define("LAN_CB_PREF_GRIDVIEW_SORTORDER_ASC", "Les anciennes recettes en premier");
define("LAN_CB_PREF_GRIDVIEW_SORTORDER_DESC", "Les nouvelles recettes en premier");

define("LAN_CB_PREF_LATEST_ITEMSPP",        "Dernières recettes: Élements par page");
define("LAN_CB_PREF_LATEST_ITEMSPP_HELP",   "Définir combien de recettes sont affichés dans la page des 'Dernières recettes'");

define("LAN_CB_PREF_DATEFORMAT",        "Format de la date");
define("LAN_CB_PREF_DATEFORMAT_HELP",   "Utiliser le format défini dans la zone d'Administration > Préférences > Options d'affichage des dates");

    //1 - Posting options
define("LAN_CB_PREF_COMMENTS",      "Commentaires sur les recettes");
define("LAN_CB_PREF_COMMENTS_HELP", "Quand activé, les utilisateurs peuvent poster des commentaires sur les recettes");

    //2 - Recipe options:
define("LAN_CB_PREF_AUTHORRATING",      "Note de l'auteur");
define("LAN_CB_PREF_AUTHORRATING_HELP", "Quand activé, les auteurs peuvent noter leurs propres recettes");

define("LAN_CB_PREF_USERRATING",      "Note des utilisateur");
define("LAN_CB_PREF_USERRATING_HELP", "Quand activé, les utilisateurs peuvent noter les recettes");

define("LAN_CB_PREF_USERRATINGCLASS",      "Groupe d'utilisateur pour noter");
define("LAN_CB_PREF_USERRATINGCLASS_HELP", "Groupe d'utilsateur autorisé à noter les recettes");

define("LAN_CB_PREF_DIFFICULTYLEVEL",      "Utiliser les niveaux de difficulté");
define("LAN_CB_PREF_DIFFICULTYLEVEL_HELP", "Quand activé, les recettes peuvent avoir 3 niveaux de difficulté: facile, moyen, difficile");

define("LAN_CB_PREF_SHOWRELATED",      "Voir les recettes similaires");
define("LAN_CB_PREF_SHOWRELATED_HELP", "Quand activé, d'autres recettes, similaires à la recette visualisé, sont affichées");

define("LAN_CB_PREF_SHOWPRINT",      "Option imprimer");
define("LAN_CB_PREF_SHOWPRINT_HELP", "Quand activé, les utilisateurs auront la possibilité d'imprimer une version simplifié de la recette");

define("LAN_CB_PREF_SHOWBOOKMARK",      "Option signets");
define("LAN_CB_PREF_SHOWBOOKMARK_HELP", "Quand activé, les utilisateurs auront la possibilté de sauvegarder les recettes dans les signets");

define("LAN_CB_PREF_SHOWSHARING",      "Option de partage");
define("LAN_CB_PREF_SHOWSHARING_HELP", "Quand activé, les utilisateurs auront la possibilité de partager une recette sur plusieurs réseaux sociaux");
