<?php
/*

This file handles deactivation of programma.  Deletes/Removes database Tables and Options.
If the application notices that the current version is different than the previous version
data will not be removed.  Instead the application will assume that an upgrade is in progress.

*/

function programma_deactivate()
{
	global $wpdb;

	## If the Version Numbers are different, this means that user deactivated and then re-activated programma
	## to preform an upgrade. Data Tables and Options should not be removed.

	if(true) {
	// doe niets
	}
	elseif ((get_option( 'programma_version' ) == MYPLUGIN_VERSION ) && ((get_option( 'programma_purgeUponDeactivation' ))))
	{

		$table_name = $wpdb->prefix . 'programma';  # assigns name to database table.

		if ($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") == $table_name) {

			$wpdb->query( "DROP TABLE ".$table_name."" );

		}

		programma_deactivate_options();

	}

}


?>
