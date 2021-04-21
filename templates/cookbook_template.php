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

// OVERVIEW TABLE OF ALL RECIPES - TODO, REWRITE USING WRAPPER
$COOKBOOK_TEMPLATE['overview']['start'] = '
<div align="left pull-left">
<table class="table table-bordered text-left recipes dt-responsive" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th></thr>
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
			<td></td>
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


// RECIPE
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
    </div>
</div>
';

$COOKBOOK_TEMPLATE['recipe_content'] = '
<!-- Start content left  -->
<div class="col-md-8 recipe-box">
    <div class="recipe-box-title">{COOKBOOK_RECIPE_NAME=no_url}</div>
    <div class="recipe-box-content">
        <h3>{LAN=LAN_CB_INGREDIENTS}</h3>
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
        {COOKBOOK_EDIT}
        {COOKBOOK_PRINT}
    </ul>
</div>
<!-- End sidebar -->
';





// KEYWORD OVERVIEW (TAGCLOUD)
$COOKBOOK_TEMPLATE['keyword_overview'] = '
{COOKBOOK_TAGCLOUD}
';


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