<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Latest recipes menu template
*/

if (!defined('e107_INIT')) { exit; }

$COOKBOOK_LATESTMENU_TEMPLATE = array();
          
$COOKBOOK_LATESTMENU_TEMPLATE['default']['caption'] = '{COOKBOOK_LATESTMENU_CAPTION}';
$COOKBOOK_LATESTMENU_TEMPLATE['default']['start']   = '<div class="cookbook_latest_menu">';
$COOKBOOK_LATESTMENU_TEMPLATE['default']['item']    = "
<div class='row'>
    <div class='col-md-4 my-2'>
        {SETIMAGE: w=200}{COOKBOOK_RECIPE_THUMB}
    </div>

    <div class='col-md-8 my-2'>
        {COOKBOOK_RECIPE_NAME}
    </div>
</div>
";
$COOKBOOK_LATESTMENU_TEMPLATE['default']['end']     = '</div>';



$COOKBOOK_LATESTMENU_TEMPLATE['image-title']['caption'] = '{COOKBOOK_LATESTMENU_CAPTION}';
$COOKBOOK_LATESTMENU_TEMPLATE['image-title']['start']   = '
<div class="cookbook_latest_menu m-4">';

$COOKBOOK_LATESTMENU_TEMPLATE['image-title']['item']    = '
 <div class="cookbook_latest_menu-item d-flex align-items-center my-2">
  <div class="cookbook_latest_menu-item-image w-50">
    {SETIMAGE: w=100}{COOKBOOK_RECIPE_THUMB}
  </div>
  <div class="cookbook_latest_menu-item-name flex-grow-2 ms-3">
    {COOKBOOK_RECIPE_NAME}
  </div>
</div>';

$COOKBOOK_LATESTMENU_TEMPLATE['image-title']['end']     = ' </div>';


//$COOKBOOK_LATESTMENU_TEMPLATE['default'] = $COOKBOOK_LATESTMENU_TEMPLATE['image-title'];