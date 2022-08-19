<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Latest recipes menu
*/

if(!defined('e107_INIT'))
{
    require_once("../../class2.php");
}

if(!e107::isInstalled('cookbook'))
{
    return '';
}

// Load the LAN files
e107::lan('cookbook', false, true);

if(!class_exists('cookbook_latestmenu'))
{
    class cookbook_latestmenu
    {

        public $template = array();

        function __construct()
        {
            $this->template = e107::getTemplate('cookbook', 'cookbook_latestmenu', 'default');
        }

        public function render($parm = null)
        {
            $text = '';

            // Number of recipes to display 
            $limit = 10;
            
            if(isset($parm['limit']))
            {
                $limit = (int) $parm['limit'];
            }

            // Retrieve the most recently added recipes 
            if($recipes = e107::getDb()->retrieve('cookbook_recipes', '*', 'ORDER BY r_datestamp DESC LIMIT 0,'.$limit, true))
            {
                // Load shortcodes
                $sc = e107::getScBatch('cookbook', TRUE);

                foreach($recipes as $recipe)
                {
                    // Pass vars to shortcodes
                    $sc->setVars($recipe);
                    
                    // Return render item from template
                    $text .= e107::getParser()->parseTemplate($this->template['item'], false, $sc);
                }

                return $text; 
            }
            // Query invalid or no recipes
            else
            {
                $text = LAN_CB_NORECIPES;
                // TODO check for SQL error 
            }

            return $text;
        }
    }
}

$class = new cookbook_latestmenu;

if(!isset($parm))
{
    $parm = null;
}

$text = $class->render($parm);


// Set default caption
$caption = LAN_CB_RECIPE_RECENT;


// Allow for custom caption through shortcode parm 
if (!empty($parm))
{
    if(isset($parm['caption'][e_LANGUAGE]))
    {
        $caption = empty($parm['caption'][e_LANGUAGE]) ? LAN_CB_RECIPE_RECENT : $parm['caption'][e_LANGUAGE];
    }
}

// Pass caption to shortcode in template 
$var        = array('COOKBOOK_LATESTMENU_CAPTION' => $caption);
$caption    = e107::getParser()->simpleParse($class->template['caption'], $var);

// Load start and end from template
$start  = $class->template['start'];
$end    = $class->template['end'];

e107::getRender()->tablerender($caption, $start . $text . $end, 'cookbook_latestmenu');