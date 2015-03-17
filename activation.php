<?php
/*

This section handles activation of plugin.  Creates/Updates database Tables, and will
allow the plugin to create tables, and insert default data into the tables.

*/

function programma_activate() {

	global $wpdb;

	##
	## You can add as many databases as you want.  For the purpose of this
	## demonstration we are only using one database Table.
	##

	$table_name = $wpdb->prefix . 'programma';  # assigns name to database table.

	$new_installation = $wpdb->get_var("show tables like '$table_name'") != $table_name; #detects if this is a new installation or simply an update.

	$installed_ver = get_option( MYPLUGIN_NAME );  #detect if we are adding this plugin for the first time, or we are updatining it.

	if ( $installed_ver != MYPLUGIN_VERSION ) {

		##  Creating or Updating the Table will require the use of the dbDelta function. The dbDelta function examines
		##  the current table structure, compares it to the desired table structure, and either adds or modifies the
		##  table as necessary.  Note that the dbDelta function is rather picky.

		##  - You have to put each field on its own line in your SQL statement.
		##  - You have to have two spaces between the words PRIMARY KEY and the definition of your primary key.
		##  - You must use the key word KEY rather than its synonym INDEX and you must include at least one KEY.

		$sql = "CREATE TABLE " . $table_name . " (
		id mediumint(11) NOT NULL AUTO_INCREMENT,
		time datetime NOT NULL,
		afdeling int(11) NOT NULL,
		datum date NOT NULL,
		programma text NOT NULL,
		user bigint(20) NOT NULL,
		UNIQUE KEY id (id)
		);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php');  # this runs the WordPress database table upgrade routine.
		dbDelta($sql);


		if ($new_installation)
		{
			programma_default_table_data ();

		}

		programma_activate_options();

	}
}

/*
function programma_default_table_data() {

	global $wpdb;

	$welcome_name = "Mr. Wordpress";
	$welcome_text = "Congratulations, you just completed the installation!";

	$table_name = $wpdb->prefix . 'programma';  # assigns name to database table.

	$insert = "INSERT INTO " . $table_name . " " .
	"(time, name, text) " .
	"VALUES ('" . time() . "','" . $wpdb->escape($welcome_name) . "','" . $wpdb->escape($welcome_text) . "')";

	$wpdb->query( $insert );

}
*/


?>