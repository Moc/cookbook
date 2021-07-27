/**
 * @file
 * Cookbook JavaScript behaviors integration.
 */

var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{
	/**
	 * Behavior to bind click events on action buttons/links.
	 *
	 * @type {{attach: e107.behaviors.cookbookActions.attach}}
	 * @see "e107_web/js/core/all.jquery.js" file for more information.
	 */
	e107.behaviors.cookbookActions = {
		attach: function (context, settings)
		{
			$(function (){
				// When bookmark icon is clicked
			    $("span[data-cookbook-action='bookmark']").click(function (){

			        var $this 		= $(this);
					var action 		= $this.attr('data-cookbook-action');
					var recipeID 	= $this.attr('data-cookbook-recipeid');			


					$.ajax({  
					    type: 'post',
					    dataType: 'JSON',       
					    data: 	{
					    			action: action,
			                    	rid: recipeID,
			                	},

			        	success: function(response)
			        	{
 
							switch(response) 
							{
							  case 'added':
							    var newIcon = '<i class="fa-li fas fa-bookmark"></i> Remove from bookmarks'; 
							    break;
							  case 'deleted':
							    var newIcon = '<i class="fa-li far fa-bookmark"></i> Add to bookmarks'; 
							    break;
							  default:
							    var newIcon = 'ERROR updating bookmark'; 
							}
			        		
			        		$('span[data-cookbook-recipeid='+recipeID+']').html(newIcon);
					       		
							
			            },
			            error: function(jqXHR, textStatus, errorThrown) 
			            {
			                alert('An error occurred... Look at the console for more information!');
			                console.log('jqXHR:');
			                console.log(jqXHR);
			                console.log('textStatus:');
			                console.log(textStatus);
			                console.log('errorThrown:');
			                console.log(errorThrown);
					    },
					});
				});
			});
		}
	};
})(jQuery);