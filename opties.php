<?


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
<?php if ( current_user_can('manage_options') ) { ?>
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
<?php } ?>
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



?>