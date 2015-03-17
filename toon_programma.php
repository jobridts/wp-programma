<?php

function toon_programma() {
	#haal info uit url
$dag = $_GET['dag'];
$maand = $_GET['maand'];
$jaar = $_GET['jaar'];
$toon = $_GET['toon'];
$getafdeling = $_GET['afdeling'];

	setlocale(LC_ALL, 'nl_NL');
	global $wpdb;
	$table_name = $wpdb->prefix . 'programma';
	global $current_user;
      get_currentuserinfo();
      if ($getafdeling ==""){
      	$afdeling = $current_user->afdeling;
      }else{
      	$afdeling = $getafdeling;
      }
      $afd_koepel = vind_grotere_groep($afdeling);
      $user = $current_user->ID;
	$vandaag = date('Y-m-d',time());
    if ($toon != 'datum' && $toon !='wijzig' && $toon!='delete'){
	$query = "SELECT id,afdeling,datum,programma,user FROM ". $table_name . " WHERE (afdeling LIKE '".$afdeling."' OR afdeling LIKE '13' OR afdeling LIKE '17' OR afdeling LIKE '$afd_koepel')  AND datum >= '$vandaag' ORDER BY datum ASC ";
	if ($afdeling == 15 ){ //muziekkapel
		$query = "SELECT id,afdeling,datum,programma,user FROM ". $table_name . " WHERE (afdeling LIKE '".$afdeling."')  AND datum >= '$vandaag' ORDER BY datum ASC ";
	}

    $result = $wpdb->get_results($query);
	?>

<h1 class="programmaafdeling"><?php echo maaknummerafdeling($afdeling); ?></h1>
<table class='programma_table' cellspacing='0' >
<thead>
  <tr class="thead">
    <th colspan="3" >Datum</th>
    <th colspan="4">Programma</th>
    <th colspan="2" class="noprint"></th>
  </tr>
</thead>
<tfoot>
  <tr class="tfoot">
    <th colspan="3">Datum</th>
    <th colspan="4">Programma</th>
    <th class="noprint" colspan="2"></th>
  </tr>
</tfoot>
<tbody>
  <?php
	$k = 0;
	 foreach ($result as $row){
	 	if ($k%2==0){
	 		$class='programmaodd';
	 	}else {
	 		$class='programmaeven';
	 	}
	 	$k++;
		?>
  <tr class="<?php echo $class; ?>">
    <td colspan="3" class="programmadatum"><?php
                //echo date('l j',strtotime($row ->datum));
                echo strftime("%A %e", strtotime($row ->datum));
            ?>
      <br/>
      <?php
            	//echo date('F Y',strtotime($row ->datum));
            	echo strftime("%B %Y", strtotime($row ->datum));
			?></td>
    <td colspan="4" class="programmainhoud"><p class="wordwrap"><?php echo nl2br($row->programma); ?></p></td>
    <td class="noprint"><?php  if (($current_user->afdeling==$row->afdeling || current_user_can('manage_programma')) && current_user_can('add_programma')){echo '<a href="?toon=wijzig&ID='.$row->id.'"><img src="'.get_bloginfo('url').'/wp-content/plugins/programma/images/edit.png" alt="edit" title="wijzig dit programma" class="no-border"/></a>'; }?></td>
    <td class="noprint"><?php  if (($current_user->afdeling==$row->afdeling || current_user_can('manage_programma')) && current_user_can('add_programma')){
			echo '<a href="?toon=delete&ID='. $row ->id . '"><img src="'.get_bloginfo('url').'/wp-content/plugins/programma/images/delete.png" alt="delete" title="verwijder dit programma" class="no-border"/></a>'; }?></td>
  </tr>
  <?php
	}
	echo "</table>";
    }elseif ($toon == 'wijzig'){
    	if (current_user_can('add_programma')&& ($afdeling==$current_user->afdeling || current_user_can('manage_programma'))){

    		if (isset($_POST['wijzig'])){
    			$id = $_POST['ID'];
    			$mtxprogramma = trim($_POST['mtxprogramma']);

			   #foutafhandeling

			   if ($mtxprogramma == "") {
					echo '<div class="error>Je hebt geen programma ingevuld!</div>';
					$error = true;
			   }
			   if(!get_magic_quotes_gpc())
			   {
			      $mtxprogramma = addslashes($mtxprogramma);
			   }
				 if ($error != true) {


				//$query = "UPDATE $table_name SET programma ='$mtxprogramma' WHERE id = $id";
				$query = "UPDATE $table_name SET `programma` = '$mtxprogramma' WHERE `id` =$id LIMIT 1 ;";


		   		$wpdb->query($query) or die('<div class="error">Error, query failed. Dit is niet jouw schuld, maar laat wel de <a href="'.get_bloginfo('url').'/contact/?contact=site">webmasters</a> iets weten!</div>');
		   		echo '<div class="succes">Programma succesvol Gewijzigd</div>';
				}
    		}


			$datum =mktime(0,0,0,$maand,$dag,$jaar);
			$datum = date("Y-m-d",$datum);

			$query = "SELECT programma, id, datum, afdeling FROM $table_name WHERE id =".$_GET['ID']." LIMIT 1";
			$result = $wpdb->get_results($query);
			if (!$result){
				echo '<div class="error>Je hebt geen programma voor deze dag</div>';
			}else{


				?>
  <?php

				foreach ($result as $row)
				$formdatum = date('d M Y',strtotime($row->datum));
				$programma = htmlspecialchars($row->programma);
					$txtafdeling = maaknummerafdeling($row->afdeling);
					$id = $row->id;
					?>
<form id="wijzig" action="" method="POST">
  <table id="programma" cellspacing="0" summary="Het programma">
    <!--<caption>programma voor <?php echo $formdatum ; ?> </caption> -->
    <tr>
      <th class="nobg"><?php echo $formdatum; ?></th>
      <th>programma</th>
    </tr>
    <tr>
      <th class="spec"><input type="hidden" name="ID" value="<?php echo $id; ?>" />
        <?php echo $txtafdeling; ?></th>
      <td><textarea name="mtxprogramma" cols="50" rows="5"><?php echo $programma; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Wijzig Programma" name="wijzig" />
        <a href="javascript:history.back()">
        <input type="button" value="Anuleren" name="anuleer" />
        </a></td>
    </tr>
  </table>
</form>
<?php
			}
			?>
<?php

    	}else {
    		echo '<div class="error>Je hebt geen machtigingen om dit programma aan te passen</div>';
    	}
    	}elseif ($toon == 'delete'){
    		$query = "SELECT programma, id, afdeling, datum FROM $table_name WHERE id = {$_GET['ID']}";
			$result = $wpdb->get_results($query);
			foreach ($result as $row){
				$afdeling = $row->afdeling;

			}


    	if (current_user_can('add_programma')&& ($afdeling==$current_user->afdeling || current_user_can('manage_programma'))){

    		if (isset($_POST['delete'])){
    			$id = $_POST['ID'];

				 if ($error != true) {


				//$query = "UPDATE $table_name SET programma ='$mtxprogramma' WHERE id = $id";
				$query = "DELETE FROM `$table_name` WHERE `id` = $id LIMIT 1";


		   		$wpdb->query($query) or die('<div class="error">Error, query failed. Dit is niet jouw schuld, maar laat wel de <a href="'.get_bloginfo('url').'/contact/?contact=site">webmasters</a> iets weten!</div>');
		   		echo '<div class="succes">Programma succesvol verwijderd</div>';
				}
    		}



$query = "SELECT programma, id, afdeling, datum FROM $table_name WHERE id = {$_GET['ID']}";
			$result = $wpdb->get_results($query);

			if (!$result){
				echo '<div class="error>Je hebt geen programma voor deze dag</div>';
			}else{

				?>
<?php

				foreach ($result as $row)
				$datumform = date('d M Y',strtotime($row->datum));
					$programma = htmlspecialchars($row->programma);
					$txtafdeling = maaknummerafdeling($row->afdeling);
					$id = $row->id;
					?>
<form id="delete" action="" method="POST">
  <table id="programma" cellspacing="0" summary="Het programma">
    <!--<caption>programma voor <?php echo  $datumform; ?> </caption> -->
    <tr>
      <th class="nobg"><?php echo $datumform ?></th>
      <th>programma</th>
    </tr>
    <tr>
      <th class="spec"><input type="hidden" name="ID" value="<?php echo $id; ?>" />
        <?php echo $txtafdeling; ?></th>
      <td><?php echo $programma; ?>
        </textarea></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Verwijder Programma" name="delete" />
        <a href="javascript:history.back()">
        <input type="button" value="Anuleren" name="anuleer" />
        </a></td>
    </tr>
  </table>
</form>
<?php

			}
			?>
<?php

    	}else {
    		echo '<div class="error>Je hebt geen machtigingen om dit programma aan te passen</div>';
    	}
    }else { //$toon == datum
	#haal programma uit database


	$query = "SELECT DISTINCT datum FROM " . $table_name . " where afdeling !='14' AND afdeling !='17' ORDER BY datum ASC ";


	$result = $wpdb->get_results($query)		  ;
	$i = 0;
	foreach ($result as $row){
		$data[$i] = $row->datum;
		$i++;
	}

	#zoek de vorige en volgende datum
	for ($n=0;$n<=$i;$n++){
		if ($data[$n] == $jaar.'-'.$maand.'-'.$dag){
			$pdatum = $data[$n-1];
			$ndatum = $data[$n+1];
		}
	}

	$splits = explode("-",$pdatum);
	$pjaar = $splits[0];
	$pmaand = $splits[1];
	$pdag = $splits[2];
	$splits = explode("-",$ndatum);
	$njaar = $splits[0];
	$nmaand = $splits[1];
	$ndag = $splits[2];
	$dag = maaktweecijfer($dag);
	if ($dag != ""){
		echo '<p class="noprint" >';
			if ($pdag!=""){
				echo '<span class="datumleft" ><a href ="?toon=datum&jaar='.$pjaar.'&maand='.$pmaand.'&dag='.$pdag.'">'.$pdag.'/'.$pmaand.'/'.$pjaar.'</a> &lt;&lt;</span> ';
			}
			echo '<span class="datumcenter" >'.$dag.'/'.$maand.'/'.$jaar . '</span>';
			if ($ndag!=""){
				echo '<span class="datumright"> &gt;&gt; <a href ="?toon=datum&jaar='.$njaar.'&maand='.$nmaand.'&dag='.$ndag.'">'.$ndag.'/'.$nmaand.'/'.$njaar.'</a></span>';
			}
			echo '</p>';
	}else{
		echo '<div class="error">Kies een dag</div>';
	}
	echo '<hr  class="noprint" />';

	$query = "SELECT id,afdeling,datum,programma,user FROM " . $table_name ." WHERE datum LIKE '".$jaar."-".$maand."-".$dag."' AND afdeling != '14'  ORDER BY (afdeling+0) ASC ";

	$result = $wpdb->get_results($query);

	# Geef een bericht als de de db leeg is

	?>
<table id="programma" cellspacing="0" summary="Het programma">
  <!--<caption>programma voor <?php echo $dag.'/'.$maand.'/'.$jaar ; ?> </caption> -->
  <tr>
    <th class="nobg"><?php echo $dag.'/'.$maand.'/'.$jaar; ?></th>
    <th>programma</th>
    <th class="noprint"></th>
    <th class="noprint"></th>
  </tr>
  <?php
		$even = false;
		foreach ($result as $row){
			$programma = htmlspecialchars($row->programma);
			$programma = nl2br($programma);
			$afdeling = $row->afdeling;
			$txtafdeling = maaknummerafdeling($afdeling);
			if ($k%2==0){
	 		$class='programmaodd';
	 	}else {
	 		$class='programmaeven';
	 	}
	 	$k++;

			if ($even == false){
				$classtd = 'spec';
				$even = true;
			}else {
				$classtd  = 'specalt';
				$even = false;
			}
				?>
  <tr class="<?php echo $class; ?>">
    <th class="<?php echo $classtd; ?>"><?php echo $txtafdeling; ?></th>
    <td class="programmainhoud"><p class="wordwrap"><?php echo $programma; ?></p></td>
    <td class="noprint"><?php  if (($current_user->afdeling==$row->afdeling || current_user_can('manage_programma')) && current_user_can('add_programma')){echo '<a href="?toon=wijzig&ID='.$row->id.'"><img src="'.get_bloginfo('url').'/wp-content/plugins/programma/images/edit.png" alt="edit" title="wijzig dit programma" class="no-border"/></a>'; }?></td>
    <td class="noprint"><?php  if (($current_user->afdeling==$row->afdeling || current_user_can('manage_programma')) && current_user_can('add_programma')){
			echo '<a href="?toon=delete&ID='. $row ->id . '"><img src="'.get_bloginfo('url').'/wp-content/plugins/programma/images/delete.png" alt="delete" title="verwijder dit programma" class="no-border"/></a>'; }?></td>
  </tr>
  <?php





			}


	?>
</table>
<?php
    }


}