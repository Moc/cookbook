<?php
/*
 * CookBook - an e107 plugin by Tijn Kuyper (http://www.tijnkuyper.nl)
 *
 * Released under the terms and conditions of the
 * Apache License 2.0 (see LICENSE file or http://www.apache.org/licenses/LICENSE-2.0)
 *
 * Setup routines
*/


if(!class_exists("cookbook_setup"))
{
	class cookbook_setup
	{

	    function install_pre($var)
		{
		}

		/**
		 * For inserting default database content during install after table has been created.
		 */
		function install_post($var)
		{
			$ret = e107::getXml(true)->e107Import(e_PLUGIN."cookbook/demodata.xml");

			if(!empty($ret['success']))
			{
				e107::getMessage()->addSuccess("Succesfully imported demo data."); // TODO LAN
			}

			if(!empty($ret['failed']))
			{
				e107::getMessage()->addError("Failed to import demo data."); // TODO LAN
				e107::getMessage()->addDebug(print_a($ret['failed'],true));
			}
			
		}

		function uninstall_options()
		{
		}

		function uninstall_post($var)
		{
		}

		/*
		 * Call During Upgrade Check. May be used to check for existance of tables etc and if not found return TRUE to call for an upgrade.
		 *
		 * @return bool true = upgrade required; false = upgrade not required
		 */
		function upgrade_required()
		{
		}

		function upgrade_post($var)
		{
		}

	}

}