<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
*/

// Load Cookbook class
require_once(e_PLUGIN."cookbook/cookbook_class.php");
$cbClass = new Cookbook();


class cookbook_print
{
    function render($rid)
    {
        $tp     = e107::getParser(); 
        $sql    = e107::getDb();
        $text   = '';
        $rid    = intval($rid);

        // Load the LAN files
        e107::lan('cookbook', false, true);

        // Load template and shortcodes
        $sc = e107::getScBatch('cookbook', true);
        $template = e107::getTemplate('cookbook');
        $template = array_change_key_case($template);

        if($recipe = $sql->retrieve("cookbook_recipes", "*", "r_id = '{$rid}'"))
        {
            // Pass database info onto the shortcodes
            $sc->setVars($recipe);

            $text = e107::getParser()->parseTemplate($template['print_recipe_layout'], true, $sc);
        }
        else
        {
            $text = e107::getParser()->parseTemplate("{LAN=LAN_CB_RECIPENOTFOUND}", true);
        }

        return $text;
    }
}