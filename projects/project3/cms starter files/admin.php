<?php
		session_start();
		require_once 'Page.class.php';
		require_once 'P3_lib.php';

		echo Page::header("Admin Page");
		
		//put code in here to check access and logged in or not
		
			//uses singleton class - only one instance of the class is allowed
			$db = Database::getInstance();

			echo Page::navigation();

			//get valid table names
			$table_names = $db->getValidTableNames("cms_%");
			
			//check to see if any tables need to be removed for editor? Use provided functions in lib to accomplish?
			
			//select table to edit here

			/*****
			  *   2 types of tables:
			  *        1) simple tables that can just use input boxes (cms_user, cms_banners, cms_edition, cms_ads/news_which_edition)
			  *        2) more complex tables that have text areas and don't fit in one row of a table easily
			  *        
			  *	 Some of the tables have foreign keys in them, so will produce errors if constraints aren't met
			  *
			 */
			 
			 //perform requested action(s).  Try to write code that uses functions that will work for similar tables without
			 //duplicating code.  Use functions provided in database class to help with this
		
		echo Page::footer();			
?>