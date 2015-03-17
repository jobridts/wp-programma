<?php
/*
Plugin Name: Programma
Plugin URI: http://www.jo.chiroschelle.be/plugins/
Description: Programma Plugin, Nodig voor deze plugin zijn de capabiliteis 'add_programma' & 'managage_programma' en het user-meta-field 'afdeling'
Version: 1.0
Author: Jo Bridts
Author URI: http://www.jo.chiroschelle.be
*/

/*  Copyright 2008-2010  Jo Bridts  (email : jo.bridts@chiroschelle.be)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA




*/


// Sets up Plugin configuration and routing based on names of Plugin folder and files.

# define Plugin constants
define( 'MYPLUGIN_VERSION', "1.1");						#  Plugin Database Version: Change this value every time you make changes to your Plugin.
define( 'MYPLUGIN_PURGE_DATA', '1' );				#  When Plugin is deactivated, if 'true', all Tables, and Options will be removed.

define( 'WP_ADMIN_PATH', ABSPATH . '/wp-admin/');  // If you have a better answer to this Constant, feel free to send me an e-mail.

define( 'MYPLUGIN_FILE', basename(__FILE__) );
define( 'MYPLUGIN_NAME', basename(__FILE__, ".php") );
define( 'MYPLUGIN_PATH', str_replace( '\\', '/', trailingslashit(dirname(__FILE__)) ) );

require_once( MYPLUGIN_PATH . '/functions.php' );
require_once( MYPLUGIN_PATH . '/activation.php' );
require_once( MYPLUGIN_PATH . '/deactivate.php' );
require_once( MYPLUGIN_PATH . '/options.php' );
require_once( MYPLUGIN_PATH . '/menus.php' );
require_once( MYPLUGIN_PATH . '/toon_programma.php' );

define( 'MYPLUGIN_URL', plugins_url('', __FILE__) );  // NOTE: It is recommended that every time you reference a url, that you specify the plugins_url('xxx.xxx',__FILE__), WP_PLUGIN_URL, WP_CONTENT_URL, WP_ADMIN_URL view the video by Will Norris.


register_activation_hook(__FILE__,'programma_activate');  // WordPress Hook that executes the installation

register_deactivation_hook( __FILE__, 'programma_deactivate' ); // WordPress Hook that handles deactivation of the Plugin.

add_action('plugins_loaded', 'programma_activate' );   // check for updates from previous versions.


add_filter('the_content', 'load_programma');
function load_programma ( $content = '' )

{

	$tmp = strip_tags(trim($content));

	//$regex = '/^KPICASA_GALLERY[\s]*(\(.*\))?$/';

	$regex = '/^[\s]*INSERT_PROGRAMMA[\s]*(\(.*\))?[\s]*$/m';



	if ( preg_match($regex, $tmp, $matches) )

	{

		//$showOnlyAlbums = array();

		//$username       = null;



		if ( isset($matches[1]) )

		{

			$args = explode(',', substr( substr($matches[1], 0, strlen($matches[1])-1), 1 ));

			if ( count($args) > 0 )

			{

				foreach( $args as $value )

				{

					$value = str_replace(' ', '', $value);

					/*if ($username == null && 'username:' == substr($value, 0, 9) && strlen($value) > 9)

					{

						$username = substr($value, 9);

					}

					else

					{

						$showOnlyAlbums[] = $value;

					}*/

				}

			}

		}



		//require_once(dirname(__FILE__).'/kpg.class.php');



		ob_start();

		//$gallery = new KPicasaGallery($username, $showOnlyAlbums);

		$buffer  = ob_get_clean();

		return str_replace($matches[0], $buffer, toon_programma());

	}



	return $content;

}

function replace_programma($text){

	$text = strip_tags($text);
	$text = trim($text);
	if ($text == "{insert_programma}"){
		$text = toon_programma();


	}
	return  $text;


}


?>