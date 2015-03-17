<?php

/**
 * options.php functions
 *
 * These functions are used in the options.php file, they were moved to this location
 * because changes are not required to these routines, and it illiminates clutter.
 *
 */

function ssp_get_options() {

	global $ssp_options_array, $ssp_options_array_excluded;

	foreach ($ssp_options_array as $option => $default_value) {
		if (in_array( $option, array($ssp_options_array_excluded) ) ) continue;  // ignore getting options listed in this array.
		$ssp_options[$option] = get_option( $option );
	}

	return $ssp_options;
}


function programma_activate_options() {
	global $ssp_options_array;

	foreach ($ssp_options_array as $option => $default_value) {
	  add_option( $option, $default_value );
	}
}


function programma_deactivate_options()
{
	global $ssp_options_array;

	foreach ($ssp_options_array as $option => $default_value) {
	  delete_option( $option, $default_value );
	}
}


# register plugin settings
add_action('admin_init', 'ssp_admin_init');
function ssp_admin_init() {
	global $ssp_options_array, $ssp_options_array_excluded;
	if (function_exists('register_setting'))
		$function = 'register_setting';
	else
		$function = 'add_option_update_handler';
	foreach ($ssp_options_array as $option => $default_value) {
		if (in_array( $option, array($ssp_options_array_excluded) ) ) continue;  // ignore getting options listed in this array.
		call_user_func($function, 'programma', $option);
	}
	// Wrapper for settings_fields function which doesn't exist in wordpress MU 2.6.5
	if (!function_exists('settings_fields')) {
		function settings_fields($option_group) {
			echo "<input type='hidden' name='option_page' value='$option_group' />";
			echo '<input type="hidden" name="action" value="update" />';
			wp_nonce_field("$option_group-options");
		}
	}
}


function programma_options_page() {

	programma_options_html(); 	// display the options page.

}


add_action('admin_head', 'programma_load_options_css');

function programma_load_options_css()
{
	if ( strpos($_SERVER['REQUEST_URI'], 'programma-options' ) !== false ) { # load css for options page
		echo '<link rel="stylesheet" href="'.plugins_url('css/options.css', __FILE__).'" type="text/css" media="screen" />'."\n";
		echo '<link rel="stylesheet" href="'.admin_url().'/css/farbtastic.css" type="text/css" media="screen" />'."\n";
	}
}


add_action( 'init', 'programma_options_load_js' ); # Loads JavaScript and CSS files

function programma_options_load_js()
{
	if ( strpos($_SERVER['REQUEST_URI'], 'programma-options' ) !== false ) { # load js for options page

		## -- Fabrastic Color Picker - Start  ##
		## ------------------------------------------------------------------------------------------
		## Fabrastic is a circular color selector.  It uses two JavaScript routines that are located in the
		## 'programma/widgets' directory: 1) rgbcolor.js and 2) farbtastic.  It also uses HTML code which I
		## provided below under <!--
		## Website/Reference: ( http://acko.net/blog/farbtastic-color-picker-released )

		wp_enqueue_script( 'programma_farbtastic', plugins_url('widgets/programma_farbtastic.js', __FILE__), array( 'jquery', 'farbtastic', 'rgbcolor' ) ); // this is very important
		wp_enqueue_script( 'rgbcolor', plugins_url('widgets/rgbcolor.js', __FILE__)   );

		## Do not remove the 'ssp_insert_colorpicker' action or function unless you don't want to use farbastic.

	    add_action('admin_footer', 'ssp_insert_colorpicker');
		function ssp_insert_colorpicker()
		{
			echo "\n";
			echo '<div id="ssp_farbtastic" style="display:none"> </div>'."\n";
			echo "\n";
		}
		## -- Fabrastic Color Picker - End  ##

	}

}

function maaknummerafdeling($afdeling) {
	switch ($afdeling) {
	case 0:
    	$afdeling = '';
	    break;
	case 1:
	   $afdeling = 'Ribbel Jongens';
	    break;
	case 2:
    	$afdeling = 'Ribbel Meisjes';
	    break;
	case 3:
		$afdeling = 'Speelclub Jongens';
    	break;
	case 4:
		$afdeling = 'Speelclub Meisjes';
    	break;
	case 5:
		$afdeling = 'Rakkers';
    	break;
	case 6:
		$afdeling = 'Kwiks';
    	break;
	case 7:
		$afdeling = 'Toppers';
    	break;
	case 8:
		$afdeling = 'Tippers';
    	break;
	case 9:
		$afdeling = 'Kerels';
    	break;
	case 10:
		$afdeling = 'Tiptiens';
    	break;
	case 11:
		$afdeling = 'Aspi Jongens';
    	break;
	case 12:
		$afdeling = 'Aspi Meisjes';
    	break;
	case 13:
		$afdeling = 'IEDEREEN';
		break;
	case 14:
		$afdeling = 'Leiding';
		break;
	case 15:
		$afdeling = 'Muziekkapel';
		break;
	case 16:
	    $afdeling = 'Tikeas';
	    break;
	case 17:
		$afdeling = "Activiteiten";
		break;
	case 18:
		$afdeling = "Oud-leiding";
		break;
	case 19:
		$afdeling = "VeeBee";
		break;
	case 20:
		$afdeling = "Sympathisant";
		break;
	case 21:
		$afdeling = 'Ribbel-Speelcub';
		break;
	case 22:
		$afdeling = 'Rakwi';
		break;
	}
		return $afdeling;
}

function maakafdelingnummer($afdeling){
	 switch ($afdeling){
      	case 'ribbel jongens':
      		$ribspe = true;
      		$nummer = 1;
      		break;
      	case  'ribbel meisjes':
      		$ribspe = true;
      		$nummer = 2;
      		break;
      	case 'speelclub jongens':
      		$ribspe = true;
      		$nummer = 3;
      		break;
      	case 'speelclub meisjes':
      		$ribspe = true;
      		$nummer = 4;
      		break;
      	case 'rakkers':
      		$rakwi = true;
      		$nummer = 5;
      		break;
      	case 'kwiks':
      		$rakwi = true;
      		$nummer = 6;
      		break;
      	case 'toppers':
      		$tikeas = true;
      		$nummer = 7;
      		break;
      	case 'tippers':
      		$tikeas = true;
      		$nummer = 8;
      		break;
      	case 'kerels':
      		$tikeas = true;
      		$nummer = 9;
      		break;
      	case 'tipriens':
      		$tikeas = true;
      		$nummer = 10;
      		break;
      	case 'aspi jongens':
      		$tikeas = true;
      		$nummer = 11;
      		break;
      	case 'aspi meisjes':
      		$tikeas = true;
      		$nummer = 12;
      		break;
      	default:
      		break;
      }
      return $nummer;

}
/**
* This function gets a year as a parameter and returns an integer,
* which is 29 for leap years and 28 for normal years.
*
* @param int $year
* @return int
*/
function schrikkeljaar($year)
{
    # Check for valid parameters #
    if (/*!is_int($year) ||*/ $year < 0)
    {
        printf('Wrong parameter for $year in function schrikkeljaar. It must be a positive integer.');
        exit();
    }

    # In the Gregorian calendar there is a leap year every year divisible by four
    # except for years which are both divisible by 100 and not divisible by 400.

    if ($year % 4 != 0)
    {
        return 28;
    }
    else
    {
        if ($year % 100 != 0)
        {
            return 29;    # Leap year
        }
        else
        {
            if ($year % 400 != 0)
            {
                return 28;
            }
            else
            {
                return 29;    # Leap year
            }
        }
    }
}

function vind_grotere_groep($afdeling){
	if ($afdeling>=1 && $afdeling<=4){
		return 21; // ribbel-speelclub
	}
	if ($afdeling>=5 && $afdeling <=6){
		return 22; // rakwi
	}
	if ($afdeling>=7 && $afdeling<=12){
		return 16; //tikeas
	}

}
?>