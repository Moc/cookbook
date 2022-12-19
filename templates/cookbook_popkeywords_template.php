<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Popular keywords menu template
*/

if (!defined('e107_INIT')) { exit; }

$COOKBOOK_POPKEYWORDS_TEMPLATE = array();
          
$COOKBOOK_POPKEYWORDS_TEMPLATE['default']['caption'] = '{COOKBOOK_POPKEYWORDSMENU_CAPTION}';
$COOKBOOK_POPKEYWORDS_TEMPLATE['default']['item']    = '<a href="{URL}" title="{KEYWORD}"><span class="btn btn-default my-1">{KEYWORD}</span></a>';

$COOKBOOK_POPKEYWORDS_TEMPLATE['default']['start']   = '<div class="cookbook_popkeywords_menu">';
$COOKBOOK_POPKEYWORDS_TEMPLATE['default']['body']    = "
<div class='row'>
    <div class='col-md-12'>
        {COOKBOOK_POPULAR_KEYWORDS: limit=5} 
    </div>
</div>
";
$COOKBOOK_POPKEYWORDS_TEMPLATE['default']['end']     = '</div>';