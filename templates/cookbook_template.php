<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Main template
*/

if (!defined('e107_INIT')) { exit; }

// OVERVIEW TABLE 
$COOKBOOK_TEMPLATE['overview']['start'] = '
<div align="left pull-left">
<table class="table table-bordered text-left recipes dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
		<tr>
		  	<th width="40%">{LAN=LAN_CB_RECIPE}</th>
		  	<th><i class="fa fa-cutlery"></i></th>
		  	<th><i class="fa fa-users"></i></th>
	  	 	<th><i class="fa fa-clock-o"></i></th>
	  	 	<th><i class="fa fa-star"></i></th>
	  	 	<th><i class="fa fa-tags"></i></th>
		</tr>
	</thead>
    <tbody>
';

$COOKBOOK_TEMPLATE['overview']['items'] = '
		<tr>
			<td>{COOKBOOK_RECIPE_NAME}</td>
	    	<td>{COOKBOOK_CATEGORY_NAME}</td>
	    	<td>{COOKBOOK_PERSONS}</td>
	    	<td>{COOKBOOK_TIME}</td>
	    	<td>{COOKBOOK_AUTHORRATING}</td>
	    	<td>{COOKBOOK_KEYWORDS: limit=5}</td>
    	</tr>
';

$COOKBOOK_TEMPLATE['overview']['end'] = '
	</tbody>
</table>
</div>
';


// INDVIDUAL RECIPE LAYOUT 
$COOKBOOK_TEMPLATE['recipe_layout'] = '
<div class="row">
	<div class="col-md-12">
		{---RECIPE-CONTENT---}
		{---RECIPE-INFO---}
	</div> <!-- col-md-12 -->
</div> <!-- row -->

<div class="row">
    <div class="col-md-12">
        {SETSTYLE=cookbook_comments}
        {COOKBOOK_COMMENTS}
        {SETSTYLE=default}
    </div>
</div>

<div class="row">
    <div class="col-md-12">  
        {SETSTYLE=cookbook_related}   
        {COOKBOOK_RELATED}
        {SETSTYLE=default}
    </div>
</div>
';

$COOKBOOK_TEMPLATE['recipe_content'] = '
<!-- Start content left  -->
<div class="col-md-8 recipe-box">
    <div class="recipe-box-title">{COOKBOOK_RECIPE_NAME=no_url}</div>
    <div class="recipe-box-content">
        <h3>{LAN=LAN_CB_INGREDIENTS}</h3>
        {SETIMAGE: w=180&h=180}
        <img class="img-thumbnail pull-right hidden-xs" alt="{COOKBOOK_RECIPE_NAME=sef}" src="{COOKBOOK_RECIPE_THUMB=url}">
        {COOKBOOK_INGREDIENTS}
        <div class="recipe-instructions">
            <h3>{LAN=LAN_CB_INSTRUCTIONS}</h3>
            {COOKBOOK_INSTRUCTIONS}
        </div>
    </div>
</div>
<!-- End content left-->
';

$COOKBOOK_WRAPPER['recipe_info']['COOKBOOK_AUTHORRATING: type=stars'] = '<li><i class="fa-li fa fa-trophy"></i><div id="rating">{---}</div></li>';

$COOKBOOK_TEMPLATE['recipe_info'] = '
<!-- Sidebar -->
<div class="col-md-4 recipe-sidebar">
    <h3>{LAN=LAN_CB_RECIPEINFO}</h3>
    <ul class="fa-ul">
        <li><i class="fa-li fa fa-cutlery"></i>{COOKBOOK_CATEGORY_NAME=no_url}</li>
        <li><i class="fa-li fa fa-users"></i> {COOKBOOK_PERSONS}</li>
        <li><i class="fa-li fa fa-clock-o"></i> {COOKBOOK_TIME}</li>
        <li><i class="fa-li fa fa-tags"></i>{COOKBOOK_KEYWORDS}</li>
        {COOKBOOK_AUTHORRATING: type=stars}
        <li><i class="fa-li fa fa-user"></i>{COOKBOOK_AUTHOR}</li>
        <li><i class="fa-li fa fa-calendar-alt"></i>{COOKBOOK_DATE}</li>
    </ul>

    <h3>{LAN=LAN_CB_ACTIONS}</h3>
    <ul class="fa-ul">
        {COOKBOOK_BOOKMARK}
        {COOKBOOK_EDIT}
        {COOKBOOK_PRINT}
    </ul>
</div>
<!-- End sidebar -->
';


// KEYWORD OVERVIEW (TAGCLOUD) (div #id should always be 'recipe_tagcloud')
$COOKBOOK_TEMPLATE['keyword_overview'] = '
{COOKBOOK_TAGCLOUD}
<div id="recipe_tagcloud" class="container-fluid" style="min-height: 350px;"></div>
';


$COOKBOOK_WRAPPER['print_recipe_layout'] = $COOKBOOK_WRAPPER['recipe_info']; 

// PRINT TEMPLATE FOR INDIVIDUAL RECIPE
$COOKBOOK_TEMPLATE['print_recipe_layout'] = '
<h1>{COOKBOOK_RECIPE_NAME=no_url}<h1>

<h2>{LAN=LAN_CB_INGREDIENTS}</h2>
<p>{COOKBOOK_INGREDIENTS}</p>
	            
<h2>{LAN=LAN_CB_INSTRUCTIONS}</h2>
{COOKBOOK_INSTRUCTIONS}
	           
<h3>{LAN=LAN_CB_RECIPEINFO}</h3>
<ul class="fa-ul">
	<li><i class="fa-li fa fa-cutlery"></i>{COOKBOOK_CATEGORY_NAME=no_url}</li>
	<li><i class="fa-li fa fa-users"></i> {COOKBOOK_PERSONS}</li>
	<li><i class="fa-li fa fa-clock-o"></i> {COOKBOOK_TIME}</li>
	<li><i class="fa-li fa fa-tags"></i>{COOKBOOK_KEYWORDS}</li>
    {COOKBOOK_AUTHORRATING: type=stars}
  	<li><i class="fa-li fa fa-user"></i>{COOKBOOK_AUTHOR}</li>
  	<li><i class="fa-li fa fa-calendar-alt"></i>{COOKBOOK_DATE}</li>
</ul>
';

$COOKBOOK_TEMPLATE['related']['caption']    = '{LAN=LAN_CB_RELATEDRECIPES}';
$COOKBOOK_TEMPLATE['related']['start']      = '{SETIMAGE: w=150&h=150&crop=1}<div class="row">';
$COOKBOOK_TEMPLATE['related']['item']       = '<div class="col-md-3 col-sm-6">
                                                 <a href="{RELATED_URL}">{RELATED_IMAGE}</a>
                                                 <h4><a href="{RELATED_URL}">{RELATED_TITLE}</a></h4>
                                                </div>';
$COOKBOOK_TEMPLATE['related']['end']        = '</div>';