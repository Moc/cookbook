<?php

// Load the LAN files
e107::lan('cookbook', false, true);

class cookbook
{
	protected $breadcrumb_array = array();

	public $caption; 
	
	function __construct()
	{
		// Add Cookbook home to breadcrumb (default)
		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_CB_NAME, 
			'url' 	=> e107::url('cookbook', 'index'),
		);
	}

	public function bookmarkRecipe()
	{
		$sql = e107::getDb();
		
		$recipe_id 	= e107::getParser()->filter($_POST["rid"], 'int');
		$user_id 	= USERID; 

		$log_error = array();

		$ret = array(
			'action' 	=> 'unknown', 
			'msg' 		=> 'unkown', 
			'status' 	=> 'error'
		);
		
		// Check if user has already bookmarked this recipe 
		if($sql->count("cookbook_bookmarks", "(*)", "WHERE user_id =".USERID." AND recipe_id = ".$recipe_id.""))
		{	
			// Already bookmarked, so unbookmark (remove from database)
			if(!$sql->delete("cookbook_bookmarks", "user_id = ".USERID." AND recipe_id = ".$recipe_id.""))
			{
				$ret['status'] 	= "error";
				$ret['msg'] 	= "Unable to remove bookmark";
		
				$log_error[] = 'SQL Error #'.$sql->getLastErrorNumber().': '.$sql->getLastErrorText();
				$log_error[] = $sql->getLastQuery();
				e107::getLog()->add("Cookbook - Unable to remove bookmark", $log_error, E_LOG_WARNING);
			}				
			else
			{
				$ret['status'] 	= "ok";
				$ret['action']  = "removed";
				$ret['msg'] 	= "<i class='fa-li far fa-bookmark'></i> <a href='#'>".LAN_CB_ADDTOBOOKMARKS."</a>";
			}
		}
		// Not yet bookmarked, so insert into database
		else
		{
			// Setup data
			$insert_data = array(
				'user_id' 				=> USERID,
				'recipe_id' 			=> $recipe_id,
				'bookmark_datestamp' 	=> time(),
			);

			// Insert into db and catch errors
			if(!$sql->insert("cookbook_bookmarks", $insert_data))
			{
				$ret['status'] 	= "error";
				$ret['msg'] 	= "Unable to add bookmark";
		
				$log_error[] = 'SQL Error #'.$sql->getLastErrorNumber().': '.$sql->getLastErrorText();
				$log_error[] = $sql->getLastQuery();
				e107::getLog()->add("Cookbook - Unable to add bookmark", $log_error, E_LOG_WARNING);
			}
			else
			{
				$ret['status'] 	= "ok";
				$ret['action']  = "added";
				$ret['msg'] 	= "<i class='fa-li fas fa-bookmark'></i> <a href='#'>".LAN_CB_REMOVEFROMBOOKMARKS."</a>";
			}
			
		}

		echo json_encode($ret);
		exit;
	}

	public function getTitle($id)
	{
		$id = (int) $id; 

		if($title = e107::getDb()->retrieve('cookbook_recipes', 'r_name', 'r_id='.$id))
		{
			return $title;
		}

		return LAN_ERROR; 
	}

	public function getRecipeData($id)
	{
		$id = (int) $id; 

		// Retrieve all information of the individual recipe from the database
		if($data = e107::getDb()->retrieve("cookbook_recipes", "*", "r_id = '{$id}'"))
		{
			return $data; 
		}

		return false; 
	}

	// Renders an individual recipe
	public function renderRecipe($rid = '')
	{
		$id = (int) $id;

		$text = '';

		// Retrieve all information of the individual recipe from the database
		if($data = e107::getDb()->retrieve("cookbook_recipes", "*", "r_id = '{$rid}'"))
		{
			// Set caption
			$this->caption = " - ".$data['r_name']; // TODO make this customizable

			// Add breadcrumb data
			$cUrlparms = array(
				"c_id"  	 => $data['r_category'],
				"c_name_sef" => $this->getCategoryName($data['r_category'], true),
			);

			$this->breadcrumb_array[] = array(
				'text' 	=> $this->getCategoryName($data['r_category']),
				'url' 	=> e107::url('cookbook', 'category', $cUrlparms),
			);

			$rUrlparms = array(
				"r_id"  => $rid,
				"r_name_sef" => $data['r_name_sef'],
			);

			$this->breadcrumb_array[] = array(
				'text' 	=> $data['r_name'], 
				'url' 	=> e107::url('cookbook', 'id', $rUrlparms),
			);

			// Load shortcode
			$sc = e107::getScBatch('cookbook', true);

			// Pass database info onto the shortcodes
			$sc->setVars($data);

			// Load template
			$LAYOUT = e107::getTemplate('cookbook', 'cookbook', 'recipe_layout');

			// Render recipe content
			$recipe_content = $this->loadRecipeContent($data);

			// Render recipe info
			$recipe_info = $this->loadRecipeInfo($data);

			// Replace template placheolders with recipe content and recipe information
			$LAYOUT = str_replace(
				['{---RECIPE-CONTENT---}', '{---RECIPE-INFO---}'],
				[$recipe_content, $recipe_info],
				$LAYOUT
			);

			$text .= e107::getParser()->parseTemplate($LAYOUT, true, $sc);
		}
		else
		{
			$text .= "<div class='alert alert-danger text-center'>".LAN_CB_RECIPENOTFOUND."</div>"; // TODO notify admin?
		}

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);
		
		return $text; 
	}

	private function loadRecipeContent($data)
	{
		// Load shortcodes
		$sc = e107::getScBatch('cookbook', true);

		// Pass data
		$sc->setVars($data);

		// Set wrapper
		$sc->wrapper('cookbook/recipe_content');

		$RECIPE_CONTENT = e107::getTemplate('cookbook', 'cookbook', 'recipe_content');

		return e107::getParser()->parseTemplate($RECIPE_CONTENT, true, $sc);
	}

	private function loadRecipeInfo($data)
	{
		// Load shortcodes
		$sc = e107::getScBatch('cookbook', true);

		// Pass data
		$sc->setVars($data);

		// Set wrapper
		$sc->wrapper('cookbook/recipe_info');

		$RECIPE_INFO = e107::getTemplate('cookbook', 'cookbook', 'recipe_info');

		return e107::getParser()->parseTemplate($RECIPE_INFO, true, $sc);
	}

	public function renderOverviewTable($recipes)
	{
		$text = '';

		$key = e107::getPlugPref('cookbook', 'overview_format', 'overview_grid'); 

		// Load template
		$template = e107::getTemplate('cookbook', null, $key);
		$template = array_change_key_case($template);

		// Load shortcode
		$sc = e107::getScBatch('cookbook', true);

	 	$text .= e107::getParser()->parseTemplate($template['start'], true, $sc);

		foreach($recipes as $recipe)
		{
			// Pass query values onto the shortcodes
			$sc->setVars($recipe);
			$text .= e107::getParser()->parseTemplate($template['items'], true, $sc);
		}

		$text .= e107::getParser()->parseTemplate($template['end'], true, $sc);

		return $text;
	}

	public function renderCategory($data)
	{
		$sql 	= e107::getDb();
		$tp 	= e107::getParser();
		$text 	= '';

		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_CATEGORIES,
			'url' 	=> e107::url('cookbook', 'categories'),
		);

		// Split and do some lookups do figure out category id and name.
		$category_full 	= e107::getParser()->toDb($data);
		$category 		= explode('/', $category_full);
		$category_id 	= (int)$category[0];
		$category_name 	= e107::getDb()->retrieve('cookbook_categories', 'c_name', 'c_id = '.$category_id.'');
		
		if($category_name)
		{
			$this->caption = LAN_CATEGORY." - ".$category_name;

			// Retrieve all recipe entries within this category
			$recipes = e107::getDb()->retrieve('cookbook_recipes', '*', 'r_category = '.$category_id.'', true);

			$cUrlparms = array(
				"c_id"  => $category_id,
				"c_name_sef" => $this->getCategoryName($category_id, true),
			);

			$this->breadcrumb_array[] = array(
				'text' 	=> $this->getCategoryName($category_id),
				'url' 	=> e107::url('cookbook', 'category', $cUrlparms),
			);

			// Load shortcode
			$sc = e107::getScBatch('cookbook', true);

			// Check if there are recipes in this category
			if($recipes)
			{
			 	$text .= $this->renderOverviewTable($recipes);
			}
			// No recipes in this category yet
			else
			{
				$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPESINCAT."</div>";
			}
		}
		else
		{
			$caption = LAN_CB_NAME." - ".LAN_ERROR;
			$text .= LAN_CB_CATNOTFOUND;
		}

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		return $text;
	}

	public function renderCategories()
	{
		$sql 	= e107::getDb();
		$tp 	= e107::getParser();
		$text 	= '';

		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_CATEGORIES,
			'url' 	=> e107::url('cookbook', 'categories'),
		);

		// Retrieve all categories
		if($categories = $sql->retrieve('cookbook_categories', '*', '', TRUE))
		{
			// Loop through categories and display recipes for each category
			foreach($categories as $category)
			{
				$text .= "<h3>".$category['c_name']."</h3>";

				// Retrieve all recipe entries for this category
				$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_category = '.$category["c_id"].'', TRUE);

				// Check if there are recipes in this category
				if($recipes)
				{
					$text .= $this->renderOverviewTable($recipes);
				}
				// No recipes for this category, display info message
				else
				{
					$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPESINCAT."</div>";
				}
			}
		}
		else
		{
			$text .= "<div class='alert alert-info text-center'>".LAN_CB_NOCATEGORIESYET."</div>";
		}
		

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		return $text;
	}

	public function renderKeyword($keyword)
	{
		$sql 	= e107::getDb();
		$tp 	= e107::getParser();
		$text 	= '';

		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		// Retrieve all recipe entries with this keyword
		$recipes = $sql->retrieve('cookbook_recipes', '*', 'r_keywords LIKE "%'.$keyword.'%"', TRUE);

		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_KEYWORDS,
			'url' 	=> e107::url('cookbook', 'keywords'),
		);

		$kUrlparms = array(
			"keyword"  => $keyword,
		);

		$this->breadcrumb_array[] = array(
			'text' 	=> $keyword,
			'url' 	=> e107::url('cookbook', 'keyword', $kUrlparms),
		);

		// Check if there are recipes with this keyword
		if($recipes)
		{
			$text .= $this->renderOverviewTable($recipes);
		}
		// No recipes with this keyword
		else
		{
			$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPES."</div>";
		}

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		return $text;
	}

	public function renderKeywordOverview()
	{
		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		$sc = e107::getScBatch('cookbook', true);

		$this->breadcrumb_array[] = array(
			'text' 	=> LAN_KEYWORDS,
			'url' 	=> e107::url('cookbook', 'keywords'),
		);

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		$text = e107::getParser()->parseTemplate($template['keyword_overview'], true, $sc);
		
		return $text; 
	}

	public function renderRecipeOverview()
	{
		$sql 	= e107::getDb();
		$tp 	= e107::getParser();
		$text 	= '';

		$template = e107::getTemplate('cookbook');
		$template = array_change_key_case($template);

		// Retrieve all recipe entries
		$recipes = $sql->retrieve('cookbook_recipes', '*', '', TRUE);

		// Check if there are recipes 
		if($recipes)
		{
			$text .= $this->renderOverviewTable($recipes);
		}
		// No recipes yet
		else
		{
			$text .= "<div class='alert alert-info text-center'>".LAN_CB_NORECIPES."</div>";
		}

		// Send breadcrumb information
		e107::breadcrumb($this->breadcrumb_array);

		return $text;
	}

	public function getCategoryName($id = '', $sef = false)
	{
		$cid = e107::getParser()->toDb($id);

		if($cdata  = e107::getDb()->retrieve('cookbook_categories', 'c_name, c_name_sef', 'c_id = '.$cid.''))
		{
			if($sef == false)
			{
				return $cdata["c_name"]; 
			}
			else
			{
				return $cdata["c_name_sef"];
			}
		}	
	
		return false; 
	}

	public function compileTagsFile()
	{
		$cache_name = 'cookbook_recipe_tags'; // name of cache file 
      	$vals = ''; // this will be the list of all the tags and their count

      	// Check if the tagcloud has been cached and is not older than cache_time
      	if( e107::getCache()->retrieve($cache_name))
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

      	// Return the values and weights
      	return $vals;
	}
}