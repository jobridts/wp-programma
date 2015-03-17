<?php
global $current_user;
      get_currentuserinfo();
      if ($_POST['afdeling']==""){
      	$afdeling =$current_user->afdeling;
      }else{
      	$afdeling = $_POST['afdeling'];
      }
      $user = $current_user->ID;
	$afd_koepel = vind_grotere_groep($afdeling);




 $icon_url = plugins_url('images/plugin-menu-icon32.png', __FILE__);

  echo '<div class="wrap">';



  echo '<div id="icon-programma" class="icon32"><img src="'. $icon_url . '"></div><h2>Goepie invullen</h2>';
  echo '<p>Voer hier bij elke datum het programma in dat die dag in de goepie moet staan.</p>';


	$aantal = get_option('programma_option_aantal_zondagen');
	settings_fields('programma');
	global $wpdb;
	$table_name = $wpdb->prefix . 'programma';  # assigns name to database table.


	  if ($_POST['goepie_update']){
	#Kijk of alle data zijn ingevuld
	for ($i=1;$i<=$aantal;$i++){
		if (trim($_POST["programma$i"])==""){
			echo "<p class='error'>Je hebt geen programma ingevuld voor ". $_POST["datum$i"] .".</p>";
			$error = true;
		}

		 $sql="SELECT * FROM " . $table_name . "
		  WHERE afdeling='$afdeling'
		  and datum='$datum[$i]'";
		 $myrows = $wpdb->query($sql);

		  if ($myrows != ""){
		  	echo "<p class='error'>Je hebt al een programma voor ". $_POST["datum$i"] .".</p>";
		  	$error = true;
		  }
		  $i++;
	}
for ($i=1;$i<=$aantal;$i++){
	switch ($_POST['hidden'.$i]){
		case 'niemand':
			$toevoegen = false;
			break;
		case 'niet_ribspe':
			if ($afdeling>=1 && $afdeling<=4){
				$toevoegen = false;
			}else{$toevoegen=true;}
			break;
		case 'niet rakwi':
			if ($afdeling>=5 && $afdeling<=6){
				$toevoegen=false;
			}else {$toevoegen=true;}
			break;
		case 'niet_tikeas':
			if ($afdeling>=7 && $afdeling<=12){
				$toevoegen= false;
			}else{ $toevoegen = true;}
			break;
		case '':
			$toevoegen = true;

		default:
			$toevoegen = true;
	}


	if ($error != true && $toevoegen==true){
		$data = array(
		'datum' => trim($_POST["datum$i"]),
		'programma' => $_POST["programma$i"],
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


		$wpdb->query($sql) or die("<div class='error'>Fatale fout: $sql</div>");
 		}
	}
	if ($error!=true){
		echo '<div id="message" class="updated fade">Goepie succesvol ingevuld</div>';
	}
	  }
?>
<form id="goepie" method="post">
<p><label for="afdeling">Afdeling:</label><select name="afdeling" <?php if (!current_user_can('manage_programma')) {echo 'disabled="disabled"'; } ?> >
<?php
for ($k=1;$k<=12;$k++){
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
<?php
for ($i = 1; $i<=$aantal;$i++){
if ($i % 2 !=0) {
	$alternate = "class='alternate'";
}else{
	$alternate = "";
}
$opties = get_option('programma_options_zondag_'.$i);
$datum = $opties['datum'];
$reden = $opties['reden'];
$extra = $opties['extra'];
if ($opties['instuif']!=""	&& $afd_koepel == 16) {
	$reden = "Instuif";
	$disabled = 'readonly="readonly"';
	$extra = 'Instuif';
	$hidden = 'instuif';
}elseif ($opties['niemand']=="1"){
	$disabled = 'readonly="readonly"';
	$hidden='niemand';
}elseif ($opties['niet_ribspe']!="" && $afd_koepel == 21){
	$disabled = 'readonly="readonly"';
	$hidden = 'niet_ribspe';
}elseif ($opties['niet_rakwi']!="" && $afd_koepel == 22){
	$disabled = 'readonly="readonly"';
	$hidden = 'niet_rakwi';
}elseif ($opties['niet_tikeas']!="" && $afd_koepel == 16){
	$disabled = 'readonly="readonly"';
	$hidden = 'niet_tikeas';
}else{
	$hidden = '';
	$disabled = '';
	if ($_POST["programma$i"]!=""){
		$reden = $_POST['programma'.$i];
	}else{
		$reden = $opties['reden'];
	}

	$disabled = '';
	$extra = $opties['extra'];
}



echo "<tr $alternate><td>$datum <input type='hidden' name='datum$i' value='$datum' /><input type='hidden' value='$hidden' name='hidden$i' /></td><td>$extra</td><td colspan='4' ><textarea name='programma$i' rows='5' cols='50' $disabled>$reden</textarea></td></tr>";
}

  ?>
  </tbody>
  </table>
  <? if (!isset($_POST['goepie_update']) || $error == true){ ?>
  <p><input type="submit" value="Verzenden" name="goepie_update"  class="button-primary" /></p>
  <?php } ?>
  </form>
  </div>