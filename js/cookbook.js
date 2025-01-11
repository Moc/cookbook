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
							if(response.status == 'ok')
							{
								var newText = response.msg; 
								$('span[data-cookbook-recipeid='+recipeID+']').html(newText);
								//console.log("going to reload")
								//alert("going to reload")
								//location.reload();
							}
							else
							{
								alert(response.msg); 
								return;
							}	
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