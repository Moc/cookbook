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

// OVERVIEW GRID
$COOKBOOK_TEMPLATE['overview_grid']['start'] = '
<div class="row">';

$COOKBOOK_TEMPLATE['overview_grid']['items'] = '
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            {SETIMAGE: w=200&h=150&crop=1}
            <a href="{COOKBOOK_RECIPE_URL}">{COOKBOOK_RECIPE_THUMB}</a>
            <div class="caption text-center">
                <h3>{COOKBOOK_RECIPE_NAME: type=link}</h3>
                <p>{COOKBOOK_RECIPE_SUMMARY: max=150}</p>

                <ul class="list-inline text-center">
                    <li>{GLYPH=fa-clock} {COOKBOOK_RECIPE_TIME}</li>
                    <li>{GLYPH=fa-user} {COOKBOOK_RECIPE_AUTHOR}</li>
                    <li>{GLYPH=fa-cutlery} {COOKBOOK_CATEGORY_NAME}</li>
                </ul>
            </div>
        </div>
    </div>
';

$COOKBOOK_TEMPLATE['overview_grid']['end'] = '
</div>
<div class="row"> 
   {GRID_NEXTPREV}
</div>';   


// OVERVIEW TABLE (DATATABLES) 
// NOTE: requires the "recipes" class in <table>. Otherise DataTabels won't initialise. 
// NOTE: you can use DataTables data-attributes for customization: https://datatables.net/examples/advanced_init/html5-data-options.html
$COOKBOOK_TEMPLATE['overview_datatable']['start'] = '
<div align="left pull-left">
<table class="table table-bordered text-left recipes dt-responsive nowrap" data-order=\'[[5, "desc"]]\' cellspacing="0" width="100%">
	<thead>
		<tr>
		  	<th data-orderable="false" width="40%">{LAN=LAN_CB_RECIPE}</th>
		  	<th>{GLYPH=fa-cutlery}</th>
		  	<th>{GLYPH=fa-users}</th>
	  	 	<th>{GLYPH=fa-clock-o}</th>
	  	 	<th>{GLYPH=fa-toolbox}</th>
            <th>{GLYPH=fa-star}</th>
	  	 	<th data-orderable="false">{GLYPH=fa-tags}</th>
		</tr>
	</thead>
    <tbody>
';

$COOKBOOK_TEMPLATE['overview_datatable']['items'] = '
		<tr>
			<td>{COOKBOOK_RECIPE_NAME: type=link}</td>
	    	<td>{COOKBOOK_CATEGORY_NAME: type=link}</td>
	    	<td>{COOKBOOK_RECIPE_PERSONS}</td>
	    	<td>{COOKBOOK_RECIPE_TIME}</td>
            <td>{COOKBOOK_RECIPE_DIFFICULTY}</td>
	    	<td>{COOKBOOK_RECIPE_AUTHORRATING}</td>
	    	<td>{COOKBOOK_RECIPE_KEYWORDS: limit=5}</td>
    	</tr>
';

$COOKBOOK_TEMPLATE['overview_datatable']['end'] = '
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
        {COOKBOOK_RECIPE_COMMENTS}
        {SETSTYLE=default}
    </div>
</div>

<div class="row">
    <div class="col-md-12">  
        {SETSTYLE=cookbook_related}   
        {COOKBOOK_RECIPE_RELATED}
        {SETSTYLE=default}
    </div>
</div>
';

// NOTE: <div id="recipe-ingredients"> is used by JS to add checkboxes to the ingredient list (to each <li>)
$COOKBOOK_TEMPLATE['recipe_content'] = '
<!-- Start content left  -->
<div class="col-md-8 recipe-box">
    <div class="recipe-box-title">{COOKBOOK_RECIPE_NAME}</div>
    <div class="recipe-box-content">
        <div id="recipe-ingredients">
            <h3>{LAN=LAN_CB_INGREDIENTS}</h3>
            {SETIMAGE: w=180&h=180}
            <img class="img-thumbnail pull-right hidden-xs" alt="{COOKBOOK_RECIPE_ANCHOR}" src="{COOKBOOK_RECIPE_THUMB_URL}">
            {COOKBOOK_RECIPE_INGREDIENTS}
        </div>
        <div class="recipe-instructions">
            <h3>{LAN=LAN_CB_INSTRUCTIONS}</h3>
            {COOKBOOK_RECIPE_INSTRUCTIONS}
        </div>
        {COOKBOOK_RECIPE_USERRATING}
    </div>
</div>
<!-- End content left-->
';

$COOKBOOK_WRAPPER['recipe_info']['COOKBOOK_RECIPE_AUTHORRATING: type=stars']   = '<div id="authorrating">{---}</div>';
$COOKBOOK_WRAPPER['recipe_info']['COOKBOOK_RECIPE_DIFFICULTY: type=stars']     = '<div id="difficulty">{---}</div>';

$COOKBOOK_TEMPLATE['recipe_info'] = '
<!-- Sidebar -->
<div class="col-md-4 recipe-sidebar">
    <h3>{LAN=LAN_CB_RECIPEINFO}</h3>
    <ul class="fa-ul">
        <li>{GLYPH: type=fa-cutlery&class=fa-li} {COOKBOOK_CATEGORY_NAME: type=link}</li>
        <li>{GLYPH: type=fa-users&class=fa-li} {COOKBOOK_RECIPE_PERSONS}</li>
        <li>{GLYPH: type=fa-clock-o&class=fa-li} {COOKBOOK_RECIPE_TOTALTIME}</li>
        <li>{GLYPH: type=fa-tags&class=fa-li} {COOKBOOK_RECIPE_KEYWORDS: limit=5}</li>
        <li>{GLYPH: type=fa-trophy&class=fa-li} {COOKBOOK_RECIPE_AUTHORRATING: type=stars}</li>
        <li>{GLYPH: type=fa-toolbox&class=fa-li} {COOKBOOK_RECIPE_DIFFICULTY: type=stars}</li>
        <li>{GLYPH: type=fa-user&class=fa-li} {COOKBOOK_RECIPE_AUTHOR}</li>
        <li>{GLYPH: type=fa-calendar&class=fa-li} {COOKBOOK_RECIPE_DATE}</li>
    </ul>

    <h3>{LAN=LAN_CB_ACTIONS}</h3>
    <ul class="fa-ul">
        <li>{COOKBOOK_RECIPE_BOOKMARK}</li>
        <li>{GLYPH: type=fa-pencil&class=fa-li} {COOKBOOK_RECIPE_EDIT}</li>
        <li>{GLYPH: type=fa-print&class=fa-li} {COOKBOOK_RECIPE_PRINT}</li>
    </ul>
</div>
<!-- End sidebar -->
';

// Styling of an individual keyword (when using {COOKBOOK_RECIPE_KEYWORDS})
$COOKBOOK_TEMPLATE['recipe_keyword'] = '<a href="{URL}" title="{KEYWORD}"><span class="label label-primary">{KEYWORD}</span></a>';

// Styling of bookmark
$COOKBOOK_TEMPLATE['recipe_bookmark_empty'] = '<i class="fa-li far fa-bookmark"></i> <a href="">{VALUE}</a>'; // Used when recipe has not been bookmarked yet
$COOKBOOK_TEMPLATE['recipe_bookmark_full']  = '<i class="fa-li fas fa-bookmark"></i> <a href="">{VALUE}</a>'; // Used when recipe is already bookmarked

// KEYWORD OVERVIEW (TAGCLOUD) (div #id should always be 'recipe_tagcloud')
$COOKBOOK_TEMPLATE['keyword_overview'] = '
{COOKBOOK_TAGCLOUD}
<div id="recipe_tagcloud" class="container-fluid" style="min-height: 350px;"></div>
';


$COOKBOOK_TEMPLATE['categories_categoryname'] = '<h3>{VALUE}</h3>'; 


$COOKBOOK_WRAPPER['print_recipe_layout'] = $COOKBOOK_WRAPPER['recipe_info']; 

// PRINT TEMPLATE FOR INDIVIDUAL RECIPE
$COOKBOOK_TEMPLATE['print_recipe_layout'] = '
<h1>{COOKBOOK_RECIPE_NAME}<h1>

<h2>{LAN=LAN_CB_INGREDIENTS}</h2>
<p>{COOKBOOK_RECIPE_INGREDIENTS}</p>
	            
<h2>{LAN=LAN_CB_INSTRUCTIONS}</h2>
{COOKBOOK_RECIPE_INSTRUCTIONS}
	           
<h3>{LAN=LAN_CB_RECIPEINFO}</h3>
<ul class="fa-ul">
	<li>{GLYPH: type=fa-cutlery&class=fa-li} {COOKBOOK_CATEGORY_NAME}</li>
	<li>{GLYPH: type=fa-users&class=fa-li} {COOKBOOK_RECIPE_PERSONS}</li>
	<li>{GLYPH: type=fa-clock-o&class=fa-li} {COOKBOOK_RECIPE_TIME}</li>
	<li>{GLYPH: type=fa-tags&class=fa-li} {COOKBOOK_RECIPE_KEYWORDS}</li>
    <li>{GLYPH: type=fa-trophy&class=fa-li} {COOKBOOK_RECIPE_AUTHORRATING: type=stars}</li>
    <li>{GLYPH: type=fa-toolbox&class=fa-li} {COOKBOOK_RECIPE_DIFFICULTY: type=stars}</li>
    <li>{GLYPH: type=fa-user&class=fa-li} {COOKBOOK_RECIPE_AUTHOR}</li>
    <li>{GLYPH: type=fa-calendar&class=fa-li} {COOKBOOK_RECIPE_DATE}</li>
</ul>
';

$COOKBOOK_TEMPLATE['related']['caption']    = '{LAN=LAN_CB_RELATEDRECIPES}';
$COOKBOOK_TEMPLATE['related']['start']      = '{SETIMAGE: w=150&h=150&crop=1}<div class="row">';
$COOKBOOK_TEMPLATE['related']['item']       = '<div class="col-md-3 col-sm-6">
                                                 <a href="{RELATED_URL}">{RELATED_IMAGE}</a>
                                                 <h4><a href="{RELATED_URL}">{RELATED_TITLE}</a></h4>
                                                </div>';
$COOKBOOK_TEMPLATE['related']['end']        = '</div>';