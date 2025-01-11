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
    /**
    * Returns the ID of a recipe 
    *
    * @example {COOKBOOK_RECIPE_ID} 
    */
    function sc_cookbook_recipe_id($parm = array())
    {
        return $this->var['r_id'];
    }

    /**
    * Renders a thumbnail of a recipe. 
    * 
    * @param string $class - a custom class that is used when rendering the link
    * 
    * @example {COOKBOOK_RECIPE_THUMB} 
    * @example {COOKBOOK_RECIPE_THUMB: class=something} // returns rendered link with custom class
    */
    function sc_cookbook_recipe_thumb($parm = array())
    {
        $class = (!empty($parm['class'])) ? $parm['class'] : 'img-responsive';

    	$thumbImage = $this->var['r_thumbnail']; 

    	// If no thumbnail is set, use default thumbnail
    	if(!$thumbImage)
    	{
    		$thumbImage = "{e_PLUGIN}cookbook/images/default_image.webp";
    	}

        // Check if the set thumbnail is an external URL or a local media manager managed file
        if(filter_var($thumbImage, FILTER_VALIDATE_URL) === false) 
        {
            $thumbUrl = e107::getParser()->thumbUrl($thumbImage);
        }
        else
        {
            $thumbUrl = $thumbImage; 
        }

        

        return '<img class="'.$class.'" src="'.$thumbUrl.'" alt="'.$this->sc_cookbook_recipe_anchor.'" />';
    }

    /**
    * Returns the URL of the thumbnail of a recipe. When no thumb is selected, url to default image is returned. 
    *
    * @example {COOKBOOK_RECIPE_THUMB_URL} 
    */
    function sc_cookbook_recipe_thumb_url($parm = array())
    {
        $thumbImage = $this->var['r_thumbnail']; 

        // If no thumbnail is set, use default thumbnail
        if(!$thumbImage)
        {
            $thumbImage = "{e_PLUGIN}cookbook/images/default_image.webp";
        }

        // Check if the set thumbnail is an external URL or a local media manager managed file
        if(filter_var($thumbImage, FILTER_VALIDATE_URL) === false) 
        {
            $thumbUrl = e107::getParser()->thumbUrl($thumbImage);
        }
        else
        {
            $thumbUrl = $thumbImage; 
        }

        return $thumbUrl;
    }
    
    /**
    * Returns the date of the recipe. Uses date formatting as defined in preferences. 
    *
    * @example {COOKBOOK_RECIPE_DATE} 
    */
    function sc_cookbook_recipe_date($parm = array())
    {
        $date_format = e107::getPlugPref('cookbook', 'date_format', 'short'); 
        return e107::getDate()->convert_date($this->var["r_datestamp"], $date_format);
    }

    /**
    * Returns the username of the author of the recipe 
    *
    * @example {COOKBOOK_RECIPE_AUTHOR} 
    */
    function sc_cookbook_recipe_author($parm = array())
    {
        $username = e107::getDb()->retrieve('user', 'user_name', 'user_id = '.$this->var["r_author"].'');
        return $username;
    }

    /**
    * Returns the name of a recipe. Can also render a simple link.
    *
    * @param string $type - when set to 'link', returns a rendered link in <a> tags. 
    * @param string $class - a custom class that is used when rendering the link
    * 
    * @example {COOKBOOK_RECIPE_NAME} // returns only the name
    * @example {COOKBOOK_RECIPE_NAME: type=link&class=btn small} // returns rendered link with custom class
    */
    function sc_cookbook_recipe_name($parm = array())
    {
        $type   = varset($parm['type']);
        $class  = (!empty($parm['class'])) ? $parm['class'] : '';

        if($type == "link")
        {
            $urlparms = array(
                'r_id'          => $this->var["r_id"],
                'r_name_sef'    => $this->var['r_name_sef'],
            );

            $url = e107::url('cookbook', 'id', $urlparms);

            return '<a class="'.$class.'" href="'.$url.'">'.$this->var["r_name"].'</a>';
        }

        return $this->var["r_name"];
    }

    /**
    * Returns the SEF anchor for a recipe name
    *
    * @example {COOKBOOK_RECIPE_ANCHOR}
    */
    function sc_cookbook_recipe_anchor($parm = array())
    {
        return $this->var["r_name_sef"];
    }

    /**
    * Returns the URL of a recipe. 
    *
    * @example {COOKBOOK_RECIPE_URL} 
    */
    function sc_cookbook_recipe_url($parm = array())
    {
        $urlparms = array(
            'r_id'          => $this->var["r_id"],
            'r_name_sef'    => $this->var['r_name_sef'],
        );

        $url = e107::url('cookbook', 'id', $urlparms);

        return $url; 
    }

    /**
    * Returns the ID of a category 
    *
    * @example {COOKBOOK_CATEGORY_ID} 
    */
    function sc_cookbook_category_id($parm = array())
    {
        return $this->var['c_id'];
    }

    /**
    * Renders a thumbnail of a category
    * 
    * @param string $class - a custom class that is used when rendering the link
    * 
    * @example {COOKBOOK_CATEGORY_THUMB} 
    * @example {COOKBOOK_CATEGORY_THUMB: class=something} // returns rendered link with custom class
    */
    function sc_cookbook_category_thumb($parm = array())
    {
        $class = (!empty($parm['class'])) ? $parm['class'] : 'img-responsive';

        $thumbImage = $this->var['c_thumbnail']; 

        // If no thumbnail is set, use default thumbnail
        if(!$thumbImage)
        {
            $thumbImage = "{e_PLUGIN}cookbook/images/default_image.webp";
        }

        $thumbUrl = e107::getParser()->thumbUrl($thumbImage);

        return '<img class="'.$class.'" src="'.$thumbUrl.'" alt="'.$this->sc_cookbook_category_anchor.'" />';
    }

    /**
    * Returns the URL of the thumbnail of a category. When no thumb is selected, url to default image is returned. 
    *
    * @example {COOKBOOK_CATEGORY_THUMB_URL} 
    */
    function sc_cookbook_category_thumb_url($parm = array())
    {
        $thumbImage = $this->var['c_thumbnail']; 

        // If no thumbnail is set, use default thumbnail
        if(!$thumbImage)
        {
            $thumbImage = "{e_PLUGIN}cookbook/images/default_image.webp";
        }

        $thumbUrl = e107::getParser()->thumbUrl($thumbImage);

        return $thumbUrl;
    }

    /**
    * Returns the name of the category. Can also render a simple link.
    *
    * @param string $type - when set to 'link', returns a rendered link in <a> tags. 
    * @param string $class - a custom class that is used when rendering the link
    * 
    * @example {COOKBOOK_CATEGORY_NAME} // returns only the name
    * @example {COOKBOOK_CATEGORY_NAME: type=link&class=btn small} // returns rendered link with custom class
    */
    function sc_cookbook_category_name($parm = array())
    {
        $type   = varset($parm['type']);
        $class  = (!empty($parm['class'])) ? $parm['class'] : '';

        $category = e107::getDb()->retrieve('cookbook_categories', 'c_id, c_name, c_name_sef', 'c_id = '.$this->var['r_category']);

        if($type == "link")
        {
            $urlparms = array(
                'c_id'        => $category['c_id'],
                'c_name_sef'  => $category['c_name_sef'],
            );

            $url = e107::url('cookbook', 'category', $urlparms);

            return '<a class="'.$class.'" href="'.$url.'">'.$category['c_name'].'</a>';
        }
        
        return $category['c_name']; 
    }

    /**
    * Returns the SEF anchor for a category name.
    *
    * @example {COOKBOOK_CATEGORY_ANCHOR}
    */
    function sc_cookbook_category_anchor($parm = array())
    {
         $category_sef = e107::getDb()->retrieve('cookbook_categories', 'c_name_sef', 'c_id = '.$this->var['r_category']);

         return $category_sef;
    }

    /**
    * Return URL to the category. Can also render a simple link.
    *
    * @param string $type when set to 'link', returns a rendered link in <a> tags. 
    * 
    * @example {COOKBOOK_CATEGORY_URL} // returns raw url
    * @example {COOKBOOK_CATEGORY_URL: type=link} // returns rendered link
    */
    function sc_cookbook_category_url($parm = array())
    {
        $type = varset($parm['type']); 

        $category = e107::getDb()->retrieve('cookbook_categories', 'c_id, c_name, c_name_sef', 'c_id = '.$this->var['r_category']);

        $urlparms = array(
            'c_id'        => $category['c_id'],
            'c_name_sef'  => $category['c_name_sef'],
        );

        $url = e107::url('cookbook', 'category', $urlparms);

        if($type == "link")
        {
            return '<a href="'.$url.'">'.$category['c_name'].'</a>';
        }

        return $url; 
    }

    /**
    * Returns the number of recipes in the (current) category. Can also be a specific category id. 
    * 
    * @param int $id - id of a specific category. 
    *
    * @example {COOKBOOK_RECIPES_IN_CATEGORY} // returns number of recipes in current category
    * @example {COOKBOOK_RECIPES_IN_CATEGORY: id=5} // returns number of recipes in category id 5
    */
    function sc_cookbook_recipes_in_category($parm = array())
    {
        $id = (!empty($parm['id'])) ? $parm['id'] : $this->var["r_category"];

        return e107::getDb()->count('cookbook_recipes', '(*)', 'WHERE r_category = '.$id);
    }

    /**
    * Returns the persons value of a recipe
    *
    * @example {COOKBOOK_RECIPE_PERSONS}
    */
    function sc_cookbook_recipe_persons($parm = array())
    {
        if(!$this->var["r_persons"])
        {
            return "&nbsp;"; // To align icons properly 
        }
        else
        {
            return $this->var["r_persons"];
        }
    }

    /**
    * Returns the active time value of a recipe
    *
    * @example {COOKBOOK_RECIPE_ACTIVETIME}
    */
    function sc_cookbook_recipe_activetime($parm = array())
    {
        if(!$this->var["r_activetime"])
        {
            return "&nbsp;"; // To align icons properly 
        }
        else
        {
            return $this->var["r_activetime"];
        }
    }

    /**
    * Returns the total time value of a recipe
    *
    * @example {COOKBOOK_RECIPE_TOTALTIME}
    */
    function sc_cookbook_recipe_totaltime($parm = array())
    {
        if(!$this->var["r_totaltime"])
        {
            return "&nbsp;"; // To align icons properly 
        }
        else
        {
            return $this->var["r_totaltime"];
        }
         
    }

    /**
    * Renders the author rating of a recipe
    *
    * @param string $stars - determines whether star images are displayed or just the numeric value
    * 
    * @example {COOKBOOK_RECIPE_AUTHORRATING} // returns numeric value, e.g. "1" 
    * @example {COOKBOOK_RECIPE_AUTHORRATING: type=stars} // returns star images of the rating
    */
    function sc_cookbook_recipe_authorrating($parm = array())
    {
        $type = varset($parm['type']);
       
        if(e107::getPlugPref('cookbook', 'recipe_authorrating') == false)
        {
            return "&nbsp;";
        }

        // Check if we want to display the stars
        if($type == "stars")
        {

            return e107::js('footer-inline', '
                $(function() {
                    $("#authorrating").raty({
                        readOnly: true,
                        number: 3,
                        score: '.$this->var["r_authorrating"].',
                        path: "'.e_PLUGIN_ABS.'cookbook/images/stars",
                        hints: ["Good", "Very good", "Exceptional"], <!-- TODO LAN -->
                    });
                });
            ')."<!-- -->";
        }
        // Just the numeric value as stored in the database
        else
        {
            return $this->var["r_authorrating"];
        }
    }


    /**
    * Renders the diffulty level of a recipe
    *
    * @param string $stars - determines whether star images are displayed or just the textual value
    * 
    * @example {COOKBOOK_RECIPE_DIFFICULTY} // returns textual value, e.g. "Easy" (value in DB is 1)
    * @example {COOKBOOK_RECIPE_DIFFICULTY: type=stars} // returns star images of the rating
    */
    function sc_cookbook_recipe_difficulty($parm = array())
    {
        $type = varset($parm['type']);
       
        if(e107::getPlugPref('cookbook', 'recipe_difficulty') == false)
        {
            return "&nbsp;";
        }

        // Check if we want to display the stars
        if($type == "stars")
        {

            return e107::js('footer-inline', '
                $(function() {
                    $("#difficulty").raty({
                        readOnly: true,
                        number: 3,
                        score: '.$this->var["r_difficulty"].',
                        path: "'.e_PLUGIN_ABS.'cookbook/images/stars",
                        hints: ["'.LAN_CB_COMPLEX_EASY.'", "'.LAN_CB_COMPLEX_MODERATE.'", "'.LAN_CB_COMPLEX_HARD.'"],
                    });
                });
            ')."<!-- -->";
        }
        // Just the textual value 
        else
        {
            switch ($this->var["r_difficulty"]) 
            {
                case 1:
                    $text = LAN_CB_COMPLEX_EASY; 
                    break;
                case 2:
                    $text = LAN_CB_COMPLEX_MODERATE; 
                    break;
                case 3:
                    $text = LAN_CB_COMPLEX_HARD; 
                    break;
                default:
                    $text = LAN_ERROR; 
                    break;
            }

            return $text;
        }
    }

    /**
    * Renders an area where users can rate the current recipes and see the rating of the recipe
    *
    * @param string $LABEL - a custom label, rather than the default "Rate this recipe"
    *
    * @example {COOKBOOK_RECIPE_USERRATING: label=Do something} 
    *
    */
    function sc_cookbook_recipe_userrating($parm = array())
    {
        $userrating_pref = e107::getPlugPref('cookbook', 'recipe_userrating', 0);

        if(!$userrating_pref)
        {
            return;
        }

        // Check permissions 
        if(!check_class(e107::getPlugPref('cookbook', 'recipe_userratingclass')))
        {
            return;
        }

        $label = (!empty($parm['label'])) ? $parm['label'] : LAN_CB_RATE_RECIPE;

        $options = array(); 
        $options['label'] = $label;
        $options['template'] = "RATE|VOTES";

        return e107::getForm()->rate("cookbook", $this->var["r_id"], $options);
    }

    /**
    * Renders all keywords belonging to a recipe
    *
    * @param int $limit - the (maximum) amount of keywords that are displayed
    *
    * @example {COOKBOOK_RECIPE_KEYWORDS: limit=2}
    *
    */
    function sc_cookbook_recipe_keywords($parm = array())
    {
        // Retrieve keywords from db. Stop when no keywords are present.
        $keywords = $this->var['r_keywords'];
        if(!$keywords) return '&nbsp;';

        // Define other variables
        $ret            = $urlparms = array();
        $all_keywords   = array_map('trim', explode(',', $keywords));
        $template       = e107::getTemplate('cookbook', 'cookbook', 'recipe_keyword');

        // Limit is set, clean the array to get rid of the surplus keywords
        if($parm['limit'])
        {
           $all_keywords = array_slice($all_keywords, 0, $parm['limit']);
        }

        // The array of keywords is clean. Now format them into individual labels
        foreach ($all_keywords as $keyword)
        {
            $urlparms['keyword']    = $keyword;
            $url                    = e107::url('cookbook', 'keyword', $urlparms);
            $keyword                = htmlspecialchars($keyword, ENT_QUOTES, 'utf-8');
           
            $vars = array(
                'KEYWORD'   => $keyword,
                'URL'       => $url,
            ); 

            $ret[] = e107::getParser()->simpleParse($template, $vars); 
        }

        // And let's return the keywords so the template can display them :)
        return implode(' ', $ret);
    }

    /**
    * Renders most used/popular keywords. Used in "Popular keywords" menu.
    *
    * @param int $limit - the (maximum) amount of keywords that are displayed
    * @param string $tempate - the template key to use
    *
    * @example {COOKBOOK_POPULAR_KEYWORDS: limit=2} 
    * @example {COOKBOOK_POPULAR_KEYWORDS: limit=2&template=other}
    *
    */
    function sc_cookbook_popular_keywords($parm = array())
    {
        $return     = $urlparms = array();
        

        // Set class
        $class = (!empty($parm['class'])) ? $parm['class'] : 'btn btn-default';

        // Set limit
        $limit = (!empty($parm['limit'])) ? $parm['limit'] : '5';

        // Set template key
        $tmplkey = (!empty($parm['template'])) ? $parm['template'] : 'default';

        $template   = e107::getTemplate('cookbook', 'cookbook_popkeywords', $tmplkey);

        require_once(e_PLUGIN."cookbook/cookbook_class.php");
        $cookbook_class = new cookbook;

        // Get all tags from cache file
        $array = $cookbook_class->compileKeywordsFile();

        // Sort array so most popular keywords (keys) are listed first
        arsort($array); 

        // Get limit amount of the first most popular keywords (keys)
        $all_keywords = array_slice($array, 0, $limit); 

        // Loop through, add url, and format. 
        foreach ($all_keywords as $keyword => $value)
        {
            $urlparms['keyword']    = $keyword;
            $url                    = e107::url('cookbook', 'keyword', $urlparms);
            $keyword                = htmlspecialchars($keyword, ENT_QUOTES, 'utf-8');

            $vars = array(
                'KEYWORD'   => $keyword,
                'URL'       => $url,
                'COUNT'     => $value,
            ); 

            $ret[] = e107::getParser()->simpleParse($template['item'], $vars); 
        }

        // And let's return the keywords so the template can display them
        return implode(' ', $ret);
    }

    /**
    * Shows a a Tagcloud of all keywords of all recipes
    * 
    * @example {COOKBOOK_TAGCLOUD}
    * 
    */
	function sc_cookbook_tagcloud($parm = array())
   	{
        require_once(e_PLUGIN."cookbook/cookbook_class.php");
        $cookbook_class = new cookbook;

    	$vals = $cookbook_class->compileKeywordsFile();

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
		');
	}

    /**
    * Renders the summary of a recipe
    *
    * @param int $max - Limits the summary to a maximum amount of characters
    * 
    * @example {COOKBOOK_RECIPE_SUMMARY: max=150} // returns the summary limited to 150 characters. 
    * 
    */
    function sc_cookbook_recipe_summary($parm = array())
    {
        if($parm['max'])
        {
            $summary = e107::getParser()->toText($this->var["r_summary"]); 
            $summary = str_replace("\n", ' ', $summary);
            $summary = e107::getParser()->truncate($summary, $parm['max']);

            return $summary;
        }

        return e107::getParser()->toHTML($this->var["r_summary"], TRUE);
    }

	function sc_cookbook_recipe_ingredients($parm = array())
   	{
		return e107::getParser()->toHTML($this->var["r_ingredients"], TRUE);
	}

	function sc_cookbook_recipe_instructions($parm = array())
	{
		return  e107::getParser()->toHTML($this->var["r_instructions"], TRUE);
	}


    /**
    * Renders edit link and/or icon for a specific recipe
    *
    * @param string $class - a custom class for the <a> tag
    * @param string $icon - FontAwesome icon to use
    * @param string $type - url, link, icon (default is 'link')
    * 
    *
    * @example {COOKBOOK_RECIPE_EDIT} // returns <a class='' href="url to recipe">Edit</a>
    * @example {COOKBOOK_RECIPE_EDIT: type=icon} // returns <a class='' href="url to recipe">pencil icon</a> 
    * @example {COOKBOOK_RECIPE_EDIT: type=icon&icon=fa gears} // returns <a class='' href="url to recipe">gears icon icon</a>
    * @example {COOKBOOK_RECIPE_EDIT: type=url} // retuns just the URL: e_PLUGIN_ABS.'cookbook/admin_config.php?action=edit&id='.$this->var["r_id"]
    * @example {COOKBOOK_RECIPE_EDIT: class=btn btn-default} // returns <a class='btn btn-default' href="url to recipe">Edit</a>
    *
    */
	function sc_cookbook_recipe_edit($parm = array())
	{
        // Check permissions 
        if(!check_class(e107::getPlugPref('cookbook', 'submission_userclass')))
        {
            return;
        }

        // Set class
        $class = (!empty($parm['class'])) ? $parm['class'] : '';

        // Set icon
        $icon = (!empty($parm['icon'])) ? $parm['icon'] : 'fa-pencil';

        // Set type
        $type = (!empty($parm['type'])) ? $parm['type'] : 'link';

		
        $url = e_PLUGIN_ABS.'cookbook/admin_config.php?action=edit&id='.$this->var["r_id"].'';

        if($type == "icon" && !empty($icon))
        { 
            return '<a class="'.$class.'" href="'.$url.'">'.e107::getParser()->toGlyph($icon).'</a>';
        }

        if($type == "url")
        { 
            return $url;
        }

		return '<a class="'.$class.'" href="'.$url.'">'.LAN_EDIT.'</a>';
	}


    function sc_cookbook_recipe_bookmark($parm = '')
    {
        $bookmark_pref = e107::getPlugPref('cookbook', 'recipe_showbookmark', 1);

        if(!$bookmark_pref)
        {
            return;
        }

        if(!USERID)
        {
            return; 
        }

        // check if recipe is already bookmarked by user
        $bookmarked = e107::getDb()->count("cookbook_bookmarks", "(*)", "WHERE user_id =".USERID." AND recipe_id = ".$this->var['r_id'].""); 
   
        // Not bookmarked yet, display 'empty' bookmark icon
        if(!$bookmarked)
        {
            $value      = LAN_CB_ADDTOBOOKMARKS;
            $template   = e107::getTemplate('cookbook', 'cookbook', 'recipe_bookmark_empty');
             
        }
        // Already bookmarked, display 'full' bookmark icon
        else
        {
            $value      = LAN_CB_REMOVEFROMBOOKMARKS;
            $template   = e107::getTemplate('cookbook', 'cookbook', 'recipe_bookmark_full');
        }

        $vars = array(
            'VALUE' => $value,
        );

        $text = e107::getParser()->simpleParse($template, $vars);

        return '<span data-cookbook-action="bookmark" data-cookbook-recipeid="'.$this->var['r_id'].'">'.$text.'</span>';
    }


    /**
    * Renders a print icon and/or link that redirects to a printer-friendly page of the recipe
    *
    * @param string $class - a custom class for the <a> tag
    * @param string $icon - FontAwesome icon to use
    * @param string $type - url, link, icon (default is 'link')
    *
    *  
    * @example {COOKBOOK_RECIPE_PRINT} // returns <a class='' href="url to print-friendly recipe">Print recipe</a>
    * @example {COOKBOOK_RECIPE_PRINT: type=icon} // returns <a class='' href="url to print-friendly recipe">print icon</a> 
    * @example {COOKBOOK_RECIPE_PRINT: type=icon&icon=fa gears} // returns <a class='' href="url to print-friendly recipe">gears icon icon</a>
    * @example {COOKBOOK_RECIPE_PRINT: type=url} // retuns just the URL: e_HTTP.'print.php?plugin:cookbook.'.$this->var["r_id"];
    * @example {COOKBOOK_RECIPE_PRINT: class=btn btn-default} // returns <a class='btn btn-default' href="url to print-friendly recipe">Print recipe</a>
    * 
    */
    function sc_cookbook_recipe_print($parm = array())
    {
        $print_pref = e107::getPlugPref('cookbook', 'recipe_showprint', 1);

        if(!$print_pref)
        {
            return;
        }

        $rid = $this->var["r_id"];
        $url = e_HTTP.'print.php?plugin:cookbook.'.$rid;

        // Set class
        $class = (!empty($parm['class'])) ? $parm['class'] : '';

        // Set icon
        $icon = (!empty($parm['icon'])) ? $parm['icon'] : 'fa-print';

        // Set type
        $type = (!empty($parm['type'])) ? $parm['type'] : 'link';

        if($icon == "icon" && !empty($icon))
        { 
            return '<a class="'.$class.'" href="'.$url.'">'.e107::getParser()->toGlyph($icon).'</a>';
        }

        if($icon == "url")
        { 
            return $url;
        }

        return '<a class="'.$class.'" href="'.$url.'">'.LAN_CB_PRINTRECIPE.'</a>';
    }

    /**
    * Shows a comments form on a recipe
    * 
    * @example {COOKBOOK_RECIPE_COMMENTS}
    * 
    */
    function sc_cookbook_recipe_comments($parm = array())
    {
        $comments_pref = e107::getPlugPref('cookbook', 'comments_enabled', 1);

        if(!$comments_pref)
        {
            return;
        }
        
        $plugin   = 'cookbook';
        $id       = $this->var['r_id'];
        $subject  = $this->var["r_name"];
        $rate     = false;

        return e107::getComment()->render($plugin, $id, $subject, $rate);
    }

    /**
    * Shows other recipes that are related to the current recipe (based on tags)
    * 
    * @param array $parm
    * @param string $parm['types'] // Allows to cross-check with other areas (e.g. news) for similar tags
    * @param int $parm['limit']
    * 
    * @example {COOKBOOK_RECIPE_RELATED: types=cookbook,news&limit=3} // Shows maximum of 3 related items, which could be cookbook recipes or news items
    * 
    */
    function sc_cookbook_recipe_related($parm = array())
    {
        $related_pref = e107::getPlugPref('cookbook', 'recipe_showrelated', 1);

        if(!$related_pref)
        {
            return;
        }

        if(!varset($parm['types']))
        {
            $parm['types'] = 'cookbook';
        }

        if(!varset($parm['limit']))
        {
            $parm['limit'] = '5';
        }

        $template = e107::getTemplate('cookbook', 'cookbook', 'related');

        return e107::getForm()->renderRelated($parm, $this->var['r_keywords'], array('cookbook' => $this->var['r_id']), $template);
    }

    /**
    * Shows the Next Prev when using Grid View 
    * 
    * @example {COOKBOOK_GRID_NEXTPREV}
    * 
    */
    function sc_grid_nextprev($parm = array())
    {
        $count      = $this->var['recipecount'];

        $page       = empty($_GET['page']) ? 1 : (int) $_GET['page'];
        $perPage    = e107::getPlugPref('cookbook', 'gridview_itemspp', 10);

        $from       = ($page - 1) * $perPage;
        $total      = ceil($count / $perPage); 
        $options    = array('type' => 'page', 'navcount' => 4);

        return e107::getForm()->pagination(e_REQUEST_SELF.'?page=[FROM]', $total, $page, $perPage, $options); 
    }
}