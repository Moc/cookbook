<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Custom install/uninstall/update routines
*/

class cookbook_setup
{

 	function install_pre($var)
	{

	}

	/**
	 * Installs example data after tables have been created
	 */
	function install_post($var)
	{
		$sql = e107::getDb();
		$mes = e107::getMessage();

		// Categories
		$query_categories = "
		INSERT INTO `#cookbook_categories` (`c_id`, `c_name`, `c_name_sef`) VALUES
			(1, 'Voorgerecht', 	'voorgerecht'),
			(2, 'Hoofdgerecht', 'hoofdgerecht'),
			(3, 'Nagerecht', 	'nagerecht'),
			(4, 'Bijgerecht',	'bijgerecht'),
			(5, 'Anders', 		'anders');
		";

		$status = ($sql->gen($query_categories)) ? E_MESSAGE_SUCCESS : E_MESSAGE_ERROR;
		$mes->add("Adding example categories", $status);

		// Recipes
		$query_recipes = "
		INSERT INTO `#cookbook_recipes`
			(`r_id`, `r_author`, `r_thumbnail`, `r_name`, `r_name_sef`, `r_category`, `r_datestamp`, `r_tags`, `r_persons`, `r_time`, `r_rating`, `r_ingredients`, `r_instructions`)
		VALUES
			(1, 1, '', 'Test voorgerecht', 'test-voorgerecht', 1, 1430438400, 'italiaans, snel', 4, 30, 2, '[html]<ul>\n<li>honderd aardappels</li>\r\n<li>vier vierkanten</li>\r\n<li>drie driehoeken</li>\r\n<li>vijf bananen</li>\r\n</ul>[/html]', '[html]<p>schil en bak de aardappels</p>\r\n<p>Alles mengen</p>\r\n<p>En klaar</p>[/html]'),
			(2, 1, '', 'Paddenstoelenfettucine met room', 'paddenstoelenfettucine-met-room', 2, 1430438400, 'pasta, champignons, snel, groep', 4, 30, 3, '[html]<ul>\n<li>200 gram spekblokjes</li>\r\n<li>1 rode ui</li>\r\n<li>400 gram paddenstoelen gemengd</li>\r\n<li>3 takjes rozemarijn</li>\r\n<li>300 gram fettuccine</li>\r\n<li>2 el olijfolie</li>\r\n<li>50 ml witte wijn</li>\r\n<li>200 gram slagroom</li>\r\n</ul>[/html]', '[html]<ol>\n<li>Pel en snipper de ui. Maak de paddenstoelen schoon en snijd ze grof. Was de de rozemarijn en ris de naalden van de takjes.</li>\r\n<li>Verhit de olijfolie en bak er het spek en de paddenstoelen ca. 2 minuten in. Voeg de ui en de helft van de rozemarijn toe en bak nog ca. 5 minuten.</li>\r\n<li>Blus het geheel af met de witte wijn en de slagroom. Laat de saus ca. 10 minuten op laag vuur koken. Kook intussen de pasta al dente.</li>\r\n<li>Giet de pasta af en meng het door de saus. Breng het geheel op smaak met zout en peper. Serveer de pasta in borden en bestrooi met de overige rozemarijn.</li>\r\n</ol>[/html]');
		";

		$status = ($sql->gen($query_recipes)) ? E_MESSAGE_SUCCESS : E_MESSAGE_ERROR;
		$mes->add("Adding example recipes", $status);
	}


	function uninstall_options()
	{

	}


	function uninstall_post($var)
	{

	}


	function upgrade_post($var)
	{

	}

}