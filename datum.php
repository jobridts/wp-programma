<?php
global $current_user;
      get_currentuserinfo();
      if ($_POST['afdeling']==""){
      	$afdeling =$current_user->afdeling;
      }else{
      	$afdeling = $_POST['afdeling'];
      }
      $user = $current_user->ID;




 $icon_url = plugins_url('images/plugin-menu-icon32.png', __FILE__);

  echo '<div class="wrap">';



  echo '<div id="icon-programma" class="icon32"><img src="'. $icon_url . '"></div><h2>Activiteit toevoegen</h2>';
  echo '<p>Voer hier bij een programma toe.</p>';


	$aantal = get_option('programma_option_aantal_zondagen');
	settings_fields('programma');
	global $wpdb;
	$table_name = $wpdb->prefix . 'programma';  # assigns name to database table.

if ($_POST['datum_update']){
	#Kijk of alle data zijn ingevuld

	if (trim($_POST["programma"])==""){
		echo "<p class='error'>Je hebt geen programma ingevuld.</p>";
		$error = true;
	}
	if ($_POST['jaar']==0 || $_POST['maand']==0 || $_POST['dag'] == 0){
		echo "<p class='error'>Je hebt geen juiste datum ingevuld.</p>";
		$error = true;
	}else{
		$ja = trim($_POST['jaar']);
		$m = $_POST['maand'];
		$d = $_POST['dag'];
		//kijk of de sommige maanden meer dan 30 dagen hebben
		if (($m==2 || $m==4 || $m==6 || $m==9 || $m==11) && $d>30){
			echo "<p class='error'>Je hebt geen juiste datum ingevuld.</p>";
			$error = true;
		}
		// 28 of 29 dagen in februari
		if ($m == 2 && $d >schrikkeljaar($ja)){
			echo "<p class='error'>Je hebt geen juiste datum ingevuld.</p>";
			$error = true;
		}


	}

if ($error != true){
	$data = array(
	'datum' => $ja . "-" . $m . "-" . $d,
	'programma' => $_POST["programma"],
	'afdeling' => $afdeling,
	'user' => $user,
	'time' => date("Y-m-d H:i:s",time())

	);
	$sql = "INSERT INTO " . $table_name . " (
			`time` ,
			`afdeling` ,
			`datum` ,
			`programma` ,
			`user`
			)
			VALUES (
			'{$data['time']}', '{$data['afdeling']}', '{$data['datum']}', '{$data['programma']}', '{$data['user']}'
);";


	$wpdb->query($sql) or die("error");
	echo '<div id="message" class="updated fade"><p>Activiteit succesvol toegevoegd</p></div>';

}
}



	?>
  <form id="activiteit" method="post">
  <p><label for="afdeling">Afdeling:</label><select name="afdeling" <?php if (!current_user_can('manage_programma')) {echo 'disabled="disabled"'; } ?> >
<?php
for ($k=1;$k<=13;$k++){
	echo '<option value="' . $k .'" ';
	if ($afdeling == $k){ echo 'selected="selected" ';}
	echo '>' . maaknummerafdeling($k) . '</option>';
}
for ($k=15;$k<=17;$k++){
	echo '<option value="' . $k .'" ';
	if ($afdeling == $k){ echo 'selected="selected" ';}
	echo '>' . maaknummerafdeling($k) . '</option>';
}
for ($k=21;$k<=22;$k++){
	echo '<option value="' . $k .'" ';
	if ($afdeling == $k){ echo 'selected="selected" ';}
	echo '>' . maaknummerafdeling($k) . '</option>';
}

?>
</select>
</p>
	<table class="widefat fixed" cellspacing="0">
<thead>
<tr class="thead"><th colspan="2" >Datum</th><th colspan="4">Programma</th></tr>
</thead>
<tfoot>
<tr class="tfoot"><th colspan="2">Datum</th><th colspan="4">Programma</th></tr>
</tfoot>
<tbody>
<tr>
	<td colspan="2">
		<select name="dag">
			<option value="0"> -- </option>
			<?php
			for ($i=1;$i<=31;$i++){
				if ($i == $_POST['dag']){
					$selected = 'selected=selected"';
				}else{
					$selected = '';
				}
				echo "<option value='$i' $selected>$i</option>";
			}
			?>
		</select>
		<select name="maand">
			<option value="0"> -- </option>
			<option value="1" <?php if ($_POST['maand'] ==1) { echo 'selected ="selected"'; } ?>>januari</option>
			<option value="2" <?php if ($_POST['maand'] ==2) { echo 'selected ="selected"'; } ?>>februari</option>
			<option value="3" <?php if ($_POST['maand'] ==3) { echo 'selected ="selected"'; } ?>>maart</option>
			<option value="4" <?php if ($_POST['maand'] ==4) { echo 'selected ="selected"'; } ?>>april</option>
			<option value="5" <?php if ($_POST['maand'] ==5) { echo 'selected ="selected"'; } ?>>mei</option>
			<option value="6" <?php if ($_POST['maand'] ==6) { echo 'selected ="selected"'; } ?>>juni</option>
			<option value="7" <?php if ($_POST['maand'] ==7) { echo 'selected ="selected"'; } ?>>juli</option>
			<option value="8" <?php if ($_POST['maand'] ==8) { echo 'selected ="selected"'; } ?>>augustus</option>
			<option value="9" <?php if ($_POST['maand'] ==9) { echo 'selected ="selected"'; } ?>>september</option>
			<option value="10" <?php if ($_POST['maand'] ==10) { echo 'selected ="selected"'; } ?>>oktober</option>
			<option value="11" <?php if ($_POST['maand'] ==11) { echo 'selected ="selected"'; } ?>>november</option>
			<option value="12" <?php if ($_POST['maand'] ==12) { echo 'selected ="selected"'; } ?>>december</option>
		</select>
		<select name="jaar">
			<option value="0"> -- </option>
			<?php
			for ($i=2010; $i<=2020; $i++){
				if ($i == $_POST['jaar']){
					$selected = 'selected=selected"';
				}else {
					$selected = '';
				}
				echo "<option value='$i' $selected>$i</option>";
			}
			?>
		</select>
	</td>
	<td colspan="4"><textarea name="programma" rows="5" cols="50"><?php echo $_POST['programma']; ?></textarea></td>
</tr>
</tbody>
</table>
<p><input type="submit" value="Verzenden" name="datum_update"  class="button-primary" /></p>
  </form>
  </div>