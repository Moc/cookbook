<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Shortcodes used in templates
*/

if (!defined('e107_INIT')) { exit; }
    
class cookbook_shortcodes extends e_shortcode
{
    function sc_cookbook_id($parm='')
    {
        return $this->var['r_id'];
    }

    function sc_cookbook_recipe_thumb($parm='')
    {
    	$thumbImage = $this->var['r_thumbnail']; 

    	// If no thumbnail is set, use default thumbnail
    	if(!$thumbImage)
    	{
    		$thumbImage = "{e_PLUGIN}cookbook/images/default_image.webp";
    	}

        $thumbUrl = e107::getParser()->thumbUrl($thumbImage, 'aw=180');

        if($parm == 'url')
        {
           return $thumbUrl; 
        }

        return '<img class="img-responsive" src="'.$thumbUrl.'" alt="" />';
    }

    function sc_cookbook_date($parm='')
    {
        $date_format = e107::getPlugPref('cookbook', 'date_format', 'short'); 
        return e107::getDate()->convert_date($this->var["r_datestamp"], $date_format);
    }

    function sc_cookbook_author($parm='')
    {
        $username = e107::getDb()->retrieve('user', 'user_name', 'user_id = '.$this->var["r_author"].'');
        return $username;
    }

    function sc_cookbook_recipe_name($parm='')
    {
        if($parm == 'no_url') { return $this->var["r_name"]; }
        if($parm == 'sef') { return $this->var["r_name_sef"]; }

        $urlparms = array(
            'recipe_id'    => $this->var["r_id"],
            'recipe_sef'  => $this->var['r_name_sef'],
        );

        $url = e107::url('cookbook', 'id', $urlparms);

        return '<a href="'.$url.'">'.$this->var["r_name"].'</a>';
    }

    function sc_cookbook_category_name($parm='')
    {
        $category = e107::getDb()->retrieve('cookbook_categories', 'c_id, c_name, c_name_sef', 'c_id = '.$this->var['r_category']);

        if($parm == 'no_url')
        {
            return $category['c_name'];
        }

        $urlparms = array(
            'category_id'	  => $category['c_id'],
            'category_sef'  => $category['c_name_sef'],
        );

        $url = e107::url('cookbook', 'category', $urlparms);

        return '<a href="'.$url.'">'.$category['c_name'].'</a>';
    }

    function sc_cookbook_persons($parm='')
    {
        return $this->var["r_persons"];
    }

    function sc_cookbook_time($parm='')
    {
        return $this->var["r_time"];
    }


    /**
    * Renders the author rating of a recipe
    *
    * @param string $stars - determines whether star images are displayed or just the numeric value
    * 
    * @example {COOKBOOK_AUTHORRATING} // returns numeric value, e.g. "1" 
    * @example {COOKBOOK_AUTHORRATING=stars} // returns star images of the rating
    */
    function sc_cookbook_authorrating($parm='')
    {
        // Check if we want to display the stars
        if($parm == 'stars')
        {
            return e107::js('footer-inline', '
                $(function() {
                    $("#rating").raty({
                        readOnly: true,
                        number: 3,
                        score: '.$this->var["r_authorrating"].',
                        path: "'.e_PLUGIN_ABS.'cookbook/images/stars"
                    });
                });
            ');
        }
        // Just the numeric value as stored in the database
        else
        {
            return $this->var["r_authorrating"];
        }
    }

    /**
    * Renders all keywords belonging to a recipe
    *
    * @param string $class - a custom class that is used when rendering individual keywords
    * @param int $limit - the (maximum) amount of keywords that are displayed
    *
    * @example {COOKBOOK_KEYWORDS: class=btn btn-default pull-right} 
    * @example {COOKBOOK_KEYWORDS: limit=2} 
    * @example {COOKBOOK_KEYWORDS: class=btn btn-default pull-right&limit=2} 
    *
    */
    function sc_cookbook_keywords($parm='')
    {
        // Retrieve keywords from db. Stop when no keywords are present.
        $keywords = $this->var['r_keywords'];
        if(!$keywords) return '';

        // Define other variables
        $ret = $urlparms = array();
        $all_keywords = array_map('trim', explode(',', $keywords));

        // Set class
        $class = (!empty($parm['class'])) ? $parm['class'] : 'label label-primary';

        // Limit is set, clean the array to get rid of the surplus keywords
        if($parm['limit'])
        {
            // Set variables
            $limit 	 = $parm['limit'];
            $real_limit = $parm['limit']-1;

            // Explode by limit. If more keywords are present than limit, the last keyword contains all the surplus keywords.
            $all_keywords = array_filter(array_map('trim', explode(',', $keywords, $limit)));

            // Check if the last keyword consists of just one just one keyword or if it's combined of more keywords (see above)
            // If the latter, strip everything after the first separator (comma)
            // Then replace the cleaned last keyword with the combined last keyword.
            if(count($all_keywords >= $real_limit))
            {
                $last_keyword = $all_keywords[$real_limit];
                list($part1, $part2) = explode(',', $last_keyword);
                $all_keywords = array_map('trim', array_replace($all_keywords, array($real_limit => $part1)));
            }
        }

        // The array of keywords is clean. Now format them into individual labels
        foreach ($all_keywords as $keyword)
        {
            $urlparms['keyword'] = $keyword;
            $url = e107::url('cookbook', 'keyword', $urlparms);
            $keyword = htmlspecialchars($keyword, ENT_QUOTES, 'utf-8');
            $ret[] = '<a href="'.$url.'" title="'.$keyword.'"><span class="'.$class.'">'.$keyword.'</span></a>';
        }

        // And let's return the keywords so the template can display them :)
        return implode(' ', $ret);
    }

	function sc_cookbook_tagcloud($parm='')
   	{
    	$cache_name = 'cookbook_recipe_tagcloud'; // name of cache file
      	$cache_time = '60'; // set to one hour (60 minutes)
      	$caching = e107::pref('cookbook', 'caching'); // preference which checks if cache is enabled (1) or disabled (0)
      	$vals = ''; // this will be the list of all the tags and their count

      	// Check if the tagcloud has been cached and is not older than cache_time
      	if($caching == true && e107::getCache()->retrieve($cache_name, $cache_time))
      	{
          	$vals_cache = e107::getCache()->retrieve($cache_name);
          	$vals = e107::unserialize($vals_cache);
      	}
     	// Tagcloud is not cached or older than cache_time
     	else
      	{
        	// Retrieve tags from database
        	$all_tags = e107::getDb()->retrieve('cookbook_recipes', 'r_keywords', '', TRUE);

        	// Loop through the results and form simpler array
         	$values = array();
        	foreach($all_tags as $tag)
         	{
           		$values[] = $tag['r_keywords'];
         	}

         	// Loop through the array and split all the comma separated tags into separate array values
         	// Each tag now has its own array key
         	$new_array = array();
         	foreach($values as $value)
         	{
            	//$tag_names = explode(", ", $value);
                $tag_names = preg_split( "/(, |,)/", $value); // split by , or , (space)
            	$new_array = array_merge($new_array, $tag_names);
         	}

         	// Generate the tag names and their respective count
         	$vals = array_count_values($new_array);

        	// Cache the results
            $vals_cache = e107::serialize($vals);
        	e107::getCache()->set($cache_name, $vals_cache);
      	}

		// Start preparing the required JS data
		$word_array_js = '';
		$urlparms = array();

		// Loop through the tag array and formulate the JS
		foreach($vals as $key => $value)
		{
			$urlparms['keyword'] = $key;
			$url = e107::url('cookbook', 'keyword', $urlparms);
			$word_array_js .= '{text: "'.$key.'", weight: '.$value.', link: "'.$url.'"},';
		}

		// Structure and return the output
		return e107::js('footer-inline', '
		 var word_array = [
		     '.$word_array_js.'
		 ];

		 $(function() {
		   $("#recipe_tagcloud").jQCloud(word_array,
		    {removeOverflowing: false});
		 });
		').'<div id="recipe_tagcloud" class="container" style="width:650px; height: 350px;"></div>';
	}

	function sc_cookbook_ingredients($parm='')
   	{
		return e107::getParser()->toHTML($this->var["r_ingredients"], TRUE);
	}

	function sc_cookbook_instructions($parm='')
	{
		return  e107::getParser()->toHTML($this->var["r_instructions"], TRUE);
	}

	function sc_cookbook_edit($parm='')
	{
		if(check_class(e107::getPlugPref('cookbook', 'submission_userclass')))
		{
			$link = e_PLUGIN_ABS.'cookbook/admin_config.php?action=edit&id='.$this->var["r_id"].'';
			return '<li><i class="fa-li fa fa-pencil"></i> <a href="'.$link.'">'.LAN_EDIT.'</a></li>';
		}
		return;
	}

    /**
    * Renders a print icon and/or link that redirects to a printer-friendly page of the recipe
    *
    * @param string $url - if set to url, it wil only return the URL (without print icon)
    *
    * @example {COOKBOOK_PRINT=url} returns url e_HTTP.'print.php?plugin:cookbook.{$recipe_id}
    * @example {COOKBOOK_PRINT} renders FA print icon and URL. 
    *
    */
    function sc_cookbook_print($parm='')
    {
        $rid = $this->var["r_id"];
        $url = e_HTTP.'print.php?plugin:cookbook.'.$rid;
    
        if($parm == 'url')
        {
            return $url; 
        }

        return '<li><i class="fa-li fa fa-print"></i> <a href="'.$url.'">Print recipe</a></li>';
    }

    function sc_cookbook_comments($parm = '')
    {
        // TODO Add check if comments are enabled

        $plugin   = 'cookbook';
        $id       = $this->var['r_id'];
        $subject  = $this->var["r_name"];
        $rate     = false;

        return e107::getComment()->render($plugin, $id, $subject, $rate);
    }
}