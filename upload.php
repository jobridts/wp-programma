<?php
global $current_user;
      get_currentuserinfo();
      $afdeling =$current_user->afdeling;
      $uid = $current_user->ID;

// Where the file is going to be placed
$target_path = WP_CONTENT_DIR . '/uploads/goepie/';



if (isset($_POST['submit'])){
	/* Add the original filename to our target path.
	Result is "uploads/filename.extension" */




	$bestandsnaam = maaknummerafdeling($afdeling) . '-' . basename( $_FILES['uploadedfile']['name']);
	$target_path = $target_path . $bestandsnaam;

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	    //echo '<div id="message" class="updated fade" The file '.  basename( $_FILES['uploadedfile']['name'])." has been uploaded</div>";
	   $to = 'goepie@chiroschelle.be';
	$subject = "[ChiroSchelle.be] Artikel van " . maaknummerafdeling($afdeling);
	$opmerkingen = $_POST['opm'];
	$bericht =
"Geüpload door: ".$current_user->first_name . " ". $current_user->last_name . "
Afdeling: " . maaknummerafdeling($afdeling) . "
Verzonden op: " . date("d-m-Y H:i:s",time()) . "
Bestandsnaam : $bestandsnaam
------------Opmerkingen------------
$opmerkingen
------------Opmerkingen------------




--
verzonden via chiroschelle.be";
	$from = $current_user->user_email;
	$fromname = $current_user->first_name . ' ' . $current_user->last_name;
	$headers = "From: $fromname <$from> \r\n";
	$headers .= "Reply-To: $from \r\n";
	if ($_POST['medeleiding']== 1){
		$afdelingemail = strtolower(str_replace(" ", "", maaknummerafdeling($afdeling)) . '@chiroschelle.be');
		$headers .= "CC: $afdelingemail";
	}
	elseif ($_POST['cc'] == 1){
		$headers .= "CC: $from \r\n";
	}

	$attachments = array($target_path);

	wp_mail($to, $subject, $bericht, $headers, $attachments);
	unlink($target_path);

	    ?><div id="message" class="updated fade">Gelukt!</h1></div><?php

	} else{
	    echo '<div class="error" >There was an error uploading the file, please try again!</div>';
	}
}

//mail de file


?>
<div class="wrap">
<h2>Artikel Uploaden</h2>
<form enctype="multipart/form-data"  method="POST">

<table>
	<tr><td>Kies artikel</td><td><input name="uploadedfile" type="file" /></td></tr>
	<tr><td>Stuur mezelf een kopie: </td><td><input type="checkbox" name="cc" value="1" /></td></tr>
	<tr><td>Stuur mijn medeleiding een kopie:</td><td><input type="checkbox" name="medeleiding" value="1" /></td></tr>
	<tr><td>Opmerkingen: </td><td><textarea name="opm" ></textarea></td></tr>
</table>
<p class="submit">
<input class="button-primary" type="submit" value="Upload File" name="submit" />
</p>
</form>
</div>