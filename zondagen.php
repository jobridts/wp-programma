<?php
$aantal = get_option('programma_option_aantal_zondagen');
global $current_user;
get_currentuserinfo();


settings_fields('programma');
echo '<div class="wrap">';

if ($_POST['zondagen_update']){
	#Kijk of alle data zijn ingevuld
	for ($i=1;$i<=$aantal;$i++){
		if (trim($_POST["zondag$i"])==""){
			echo "<p class='error'>Je hebt geen data ingevuld voor zondag $i.</p>";
			$error = true;
		}
	if ($error != true){
		$opties = array(
		'datum' => trim($_POST["zondag$i"]),
		'instuif' => $_POST["instuif$i"],
		'niet_ribspe' => $_POST["niet_ribspe$i"],
		'niet_rakwi' => $_POST["niet_rakwi$i"],
		'niet_tikeas' => $_POST["niet_tikeas$i"],
		'niemand' => $_POST["niemand$i"],
		'reden' => trim($_POST["reden$i"]),
		'extra' => trim($_POST["extra$i"]),

		);
		update_option('programma_options_zondag_'.$i,$opties);
	}
	global $wpdb;
	$sql="SELECT * FROM " . $table_name . "
		  WHERE afdeling='13'
		  and datum='{$_POST['zondag'.$i]}'";
		 $myrows = $wpdb->query($sql);

		  if ($myrows != ""){

		  	$niettoevoegen = true;
		  }
	if ($_POST['niemand$i'] == true && $niettoevoegen != true){
		$sql = "INSERT INTO " . $table_name . " (
				`time` ,
				`afdeling` ,
				`datum` ,
				`programma` ,
				`user`
				)
				VALUES (
				'". time()."', '13', '{$_POST['zondag'.$i]}', '{$_POST['reden'.$i]}', '{$current_user->id}'
);";


		$wpdb->query($sql) or die("error");
	}

	}
}

?>
<h2>Zondagen Toevoegen</h2>
<p>Vul hier per zondag de nodige details in.</p>
<form id="zondagen" method="post">


<table class="widefat fixed" cellspacing="0">
<thead>
<tr class="thead"><th>Datum</th><th>instuif</th><th colspan="3">Niet voor</th><th>Niemand invullen</th><th>Reden</th><th>extra info</th></tr>
</thead>
<tfoot>
<tr class="tfoot"><th>Datum</th><th>instuif</th><th colspan="3">Niet voor</th><th>Niemand invullen</th><th>Reden</th><th>extra info</th></tr>
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

echo  "<tr $alternate><td ><input type='text' name='zondag$i' size='10' value={$opties['datum']}></td><td><input type='checkbox' name='instuif$i' id='instuif$1' value='1'";
if ($opties['instuif']) {echo ' checked ="checked"';}
echo "/></td><td><input type='checkbox' name='niet_ribspe$i' value='1'";
if ($opties['niet_ribspe']) {echo ' checked ="checked"';}
echo " /><label for='niet_ribspe$i'>R-S</label></td><td>
<input type='checkbox' name='niet_rakwi$i' value='1' ";
if ($opties['niet_rakwi']) {echo ' checked ="checked"';}
echo "/><label for='niet_rakwi$i'>Rakwis</label></td><td><input type='checkbox' name='niet_tikeas$i' value='1' ";
if ($opties['niet_tikeas']) {echo ' checked ="checked"';}
echo "/><label for='niet_tikeas$i'>TiKeAs</label></td><td  ><input type='checkbox' name='niemand$i' value='1'";
if ($opties['niemand']) {echo ' checked ="checked"';}
echo "/></td><td  ><textarea name='reden$i' cols='10' rows='4' >{$opties['reden']}</textarea></td><td ><input type='text' name='extra$i' size='15' value='{$opties['extra']}'/></td></tr>";
 }
?>
</tbody>
</table>
<p><input type="submit" value="Verzenden" name="zondagen_update"  class="button-primary" /></p>
</form>
</div>