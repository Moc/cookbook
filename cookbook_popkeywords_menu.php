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

if(!class_exists('cookbook_popkeywords_menu'))
{
    class cookbook_popkeywords_menu
    {

        public $template = array();

        function __construct()
        {
            $this->template = e107::getTemplate('cookbook', 'cookbook_popkeywords', 'default');
        }

        public function render($parm = null)
        {
            $text = '';
            $sql  = e107::getDb();

            // Number of recipes to display 
            $limit = 10;
            
            if(isset($parm['limit']))
            {
                $limit = (int) $parm['limit'];
            }

            // Load shortcodes
            $sc = e107::getScBatch('cookbook', TRUE);

            $text .= e107::getParser()->parseTemplate($this->template['item'], true, $sc);

            return $text;
        }
    }
}

$class = new cookbook_popkeywords_menu;

if(!isset($parm))
{
    $parm = null;
}

$text = $class->render($parm);


// Set default caption
$caption = LAN_CB_POPKEYWORDS;

// Allow for custom caption through shortcode parm 
if (!empty($parm))
{
    if(isset($parm['caption'][e_LANGUAGE]))
    {
        $caption = empty($parm['caption'][e_LANGUAGE]) ? LAN_CB_POPKEYWORDS : $parm['caption'][e_LANGUAGE];
    }
}

// Pass caption to shortcode in template 
$var        = array('COOKBOOK_POPKEYWORDSMENU_CAPTION' => $caption);
$caption    = e107::getParser()->simpleParse($class->template['caption'], $var);

// Load start and end from template
$start  = $class->template['start'];
$end    = $class->template['end'];

e107::getRender()->tablerender($caption, $start . $text . $end, 'cookbook_popkeywordsmenu');