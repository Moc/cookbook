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

// OVERVIEW TABLE OF ALL RECIPES
$COOKBOOK_TEMPLATE['overview']['start'] = '
<div align="left pull-left">
<table class="table table-bordered text-left recipes dt-responsive" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th></thr>
		  	<th width="40%"></th>
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
	    	<td>{COOKBOOK_RATING}</td>
	    	<td>{COOKBOOK_TAGS: limit=5}</td>
    	</tr>
';

$COOKBOOK_TEMPLATE['overview']['end'] = '
	</tbody>
</table>
</div>
';


// INDIVIDUAL RECIPE ITEM
$COOKBOOK_TEMPLATE['recipe_item'] = '
<div class="row">
        <div class="col-md-12">
	        <!-- Start content left  -->
	        <div class="col-md-8 recipe-box">
	          <div class="recipe-box-title">{COOKBOOK_RECIPE_NAME=no_url}</div>
	          <div class="recipe-box-content">
	            <h3>Ingrediënten</h3>
	            <img class="img-thumbnail pull-right hidden-xs" alt="{COOKBOOK_RECIPE_NAME=sef}" src="{COOKBOOK_RECIPE_THUMB_URL}">
	            {COOKBOOK_INGREDIENTS}

	            <div class="recipe-instructions">
	                <h3>Instructies</h3>
	                {COOKBOOK_INSTRUCTIONS}
	            </div>
	          </div>
	        </div>
	        <!-- End content left-->
            <!-- Sidebar -->
            <div class="col-md-4 recipe-sidebar">

            	<h3>Recept info</h3>
        		<ul class="fa-ul">
        			<li><i class="fa-li fa fa-cutlery"></i>{COOKBOOK_CATEGORY_NAME=no_url}</li>
              		<li><i class="fa-li fa fa-users"></i> {COOKBOOK_PERSONS} personen</li>
              		<li><i class="fa-li fa fa-clock-o"></i> {COOKBOOK_TIME} minuten</li>
                	<li><i class="fa-li fa fa-tags"></i>{COOKBOOK_TAGS}</li>
                  	<li><i class="fa-li fa fa-trophy"></i><div id="rating">{COOKBOOK_RATING=stars}</div></li>
                  	<li><i class="fa-li fa fa-user"></i>{COOKBOOK_AUTHOR}</li>
              	</ul>

              	<h3>Acties</h3>
              	<ul class="fa-ul">
                	{COOKBOOK_EDIT}
                  	<li><i class="fa-li fa fa-print"></i> Print</li>
                  	<li><i class="fa-li fa fa-envelope"></i> E-mail</li>
                  	<li><i class="fa-li fa fa-save"></i> Download als PDF</li>
              	</ul>
            </div>
            <!-- End sidebar -->
        </div> <!-- col-md-12 -->
      </div> <!-- row -->
';

// CATEGORY
$COOKBOOK_TEMPLATE['category'] = '
Dit is de category pagina
';

// TAG OVERVIEW
$COOKBOOK_TEMPLATE['tagoverview'] = '
{COOKBOOK_TAGCLOUD}
';