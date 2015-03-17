<?php

/*
	Read Creating Option Pages - WordPress Codex: http://codex.wordpress.org/Creating_Options_Pages

	Creates/Updates all options that will be used in programma. below are two types
	of options, the first checks if the option has been defined.  If it does not exist it
	will be added with the the specified default values, otherwise it will not be updated.
	these options can be changed in the Administrative Pannel under the options section for the plugin.
	The second type of option, represents the options which are constants throught the program.
	They can only be changed by hardcoding the values in this file.  It is primarily used
	to keep track of the current Version of the plugin, or to specify other constants that cannot
	change through user input.

	Below, 'programma_version' stores the value which represents the current Version/release of programma.
	This value is extreemly important!  It manages any upgrades made to the plugin.  It is the only
	option in programma that needs to be updated every it is changed. MYPLUGIN_VERSION was defined
	in programma.php as a constant with the php DEFINE function.

*/

# define all the options you will use and their default values.

global $ssp_options_array;


$ssp_options_array = array (

	'programma_version' => MYPLUGIN_VERSION,
	'programma_purgeUponDeactivation' => 0,  // Flags wether or not the database should be deleted when application is deactivated.  Default value: MYPLUGIN_DELETE_DATA which is defined in programma.php
	'programma_option_goepie' => '2010-01-01',
	'programma_option_aantal_zondagen' => 0,


);


function programma_options_html() {

  	$ssp_options = ssp_get_options();
	extract( $ssp_options );

  	?>

  	<div class="wrap">

  	<?php $icon_url = plugins_url('images/plugin-menu-icon32.png', __FILE__); ?>

	<div id="icon-programma" class="icon32"><img src="<?php echo $icon_url; ?>"></div><h2>Programma Instellingen</h2>

	<form method="post" id="ssp_form" action="options.php">

	<?php settings_fields('programma'); ?>

	<p>Dit is de Programma opties-pagina. &nbsp; &nbsp;Als je alles het ingevuld, klik dan op Update om je wijzigingen op te slaan.</p>


		<!-- Default Settings: -->
		<table class="form-table ssp_form-table">

			<tr valign="top">
				<th scope="row" class="ssp_form-h2"><h2>Standaard Instellingen:</h2></th>
				<td class="ssp_form-update"><p class="submit ssp_submit"><input type="submit" name="Submit" value="Update &raquo;" /></p></td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="programma_option_goepie">Datum voor binnenleveren goepie</label></th>
				<td>
					<input type="text"  name="programma_option_goepie" value="<?php echo get_option('programma_option_goepie'); ?>"/>
					&nbsp;&nbsp; Vul hier de datum in dat het programma ten laatste moet worden ingevuld (deze dag is nog ok)
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="programma_option_aantal_zondagen">Aantal zondagen</label></th>
				<td>
					<input type="text" name="programma_option_aantal_zondagen" value="<?php echo get_option('programma_option_aantal_zondagen'); ?>" />
					&nbsp;&nbsp;Hoeveel zondagen moeten er in de volgende goepie staan (of er al dan niet een programma moet worden ingegeven is niet belangrijk)
				</td>
			</tr>


		</table>


		<!-- Start: Purge Data -->
		<table class="form-table ssp_form-table ssp_form-table-highlight">
			<tr valign="top">
				<th scope="row" class="ssp_form-h2"><h2>Deactivatie:</h2></th>
				<td class="ssp_form-update"><p class="submit ssp_submit"><input type="submit" name="Submit" value="Update &raquo;" /></p></td>
			</tr>
			<tr valign="top" class="ssp_highlight-option">
				<th scope="row"><label for="programma_purgeUponDeactivation">Verwijder alle data bij deactiveren:</label></th>
				<td class="td_deactivate">
					<input type="checkbox" name="programma_purgeUponDeactivation" id="programma_purgeUponDeactivation" value="1" <?php echo (!strcmp($programma_purgeUponDeactivation, 'On' ) || !strcmp($programma_purgeUponDeactivation, '1' )) ? ' checked="checked"' : ''; ?> />&nbsp;&nbsp;<?php _e("Alle data en opties gecreëerd door Programma zullen worden verwijder bij deactiveren van de Plugin."); ?>
				</td>
			</tr>
		</table>
		<!-- End: Purge Data -->

	<input type='hidden' name='programma_version' value='<?php echo $programma_version; ?>' />


	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Update'); ?>" />
	</p>

	</form>
	</div>

<?php
$aantal = get_option('programma_option_aantal_zondagen');
for ($i=1;$i<=$aantal;$i++){
	add_option('programma_option_zondag_'.$i, array(
	'datum' => '',
	'instuif' => 0,
	'niet_ribspe' => 0,
	'niet_rakwi' => 0,
	'niet_tikeas' => 0,
	'niemand' => 0,
	'reden' => '',
	'extra' => '',
	));
}


} ?>