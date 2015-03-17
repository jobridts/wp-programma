<?php
 $icon_url = plugins_url('images/plugin-menu-icon32.png', __FILE__);
 global $wpdb;
 $table_name = $wpdb->prefix . 'programma';  # assigns name to database table.
  echo '<div class="wrap">';
  echo '<div id="icon-programma" class="icon32"><img src="'. $icon_url . '"></div><h2>Sublevel Page 5</h2>';
  echo '<p>Welcome to sublevel page 5.  You can place HTML code, include/require a PHP file, or call a function function from this area.</p>';
  echo '</div>';
?>
  <form action="" method="post" name="archief">
<h3>Zoek in het archief (vanaf 2008-2009)</h3>
<table>
<tr><td>Afdeling</td><td>
<select name="afdeling">
  <option>Kies een afdeling</option>
  <option value="1">ribbel jongens</option>
  <option value="2">ribbel meisjes</option>
  <option value="3">speelclub jongens</option>
  <option value="4">speelclub meisjes</option>
  <option value="5">rakkers</option>
  <option value="6">kwiks</option>
  <option value="7">toppers</option>
  <option value="8">tippers</option>
  <option value="9">kerels</option>
  <option value="10">tiptiens</option>
  <option value="11">aspi jongens</option>
  <option value="12">aspi meisjes</option>
  <option value="13">iedereen</option>
  <option value="14">leiding</option>
  <option value="15">muziekkapel</option>
  <option value="16">tikeas</option>
  <option value="17">activiteiten</option>
</select></td></tr>
<tr><td>begin datum (YYYY-MM-DD)</td><td><input name="start" type="text" maxlength="10" /></td></tr>
<tr><td>eind datum (YYYY-MM-DD)</td><td><input name="stop" type="text" maxlength="10" /></td></tr>
<tr><td colspan="2"><input name="submit" type="submit" value="Archief Bekijken" /></td></tr>
</table>
<p style="text-align:left"><a href="http://www.chiroschelle.net/chirolalala/Programma.htm">programma 2007- 2008 (chirolalala)</a><br />
  <a href="http://www.chiroschelle.net/geksentriek/Programma.htm">programma 2006 - 2007 (geksentriek)</a><br />
  <a href="http://www.chiroschelle.net/verdraaidewereld/Programma.htm">programma 2005 - 2006 (verdraai de wereld)</a><br />
  <a href="http://www.chiroschelle.net/natuurleuk/Programma.htm">programma 2004 - 2005 (natuurleuk)</a><br />
  <a href="http://www.chiroschelle.net/plays2b/Programma.htm">programma 2003 - 2004 (play's 2 b)</a><br />
  <a href="http://www.chiroschelle.net/Speelgoed/Programma.htm">programma 2002 - 2003 (speelgoed)</a><br />
  <a href="http://www.chiroschelle.net/Zindering/Programma.htm">programma 2001 - 2002 (zindering)</a><br />
</p>
</form>
<br /><hr /><br />
<?php

$velden = array ("start","stop","afdeling");
	foreach($velden as $waarde)
	{
		if(array_key_exists($waarde, $_POST))
			$data[$waarde] = trim($_POST[$waarde]);
		else
			$data[$waarde] = "";
	}


if (isset($_POST['submit'])){
	if ($data['afdeling']) {$afdeling = "afdeling = '".$data['afdeling']."'";
		if ($data['start']) {$start = "AND datum >= '".$data['start']."'";}
		if ($data['stop']) {$stop = "AND datum <= '".$data['stop']."'";}
		$query = "SELECT * FROM $table_name WHERE $afdeling $start $stop";
	} else {
		if ($data['start']) {
			$start = "WHERE datum >= '".$data['start']."'";
			if ($data['stop']) {$stop = "AND datum <= '".$data['stop']."'";}
			$query = "SELECT * FROM $table_name $start $stop";
		} else{
			if ($data['stop']) {$stop = "WHERE datum <= '".$data['stop']."'";}
			$query = "SELECT * FROM $table_name $stop";
		}
	}
		$result = $wpdb->get_results($query);
	echo "<h3> Programma voor ".maaknummerafdeling($data['afdeling'])." van ".$data['start']." tot ".$data['stop']."</h3>";
	?><table class='widefat fixed' cellspacing='0' >
	<thead>
	<tr class="thead"><th colspan="2" >Datum</th><th colspan="4">Programma</th></tr>
</thead>
<tfoot>
<tr class="tfoot"><th colspan="2">Datum</th><th colspan="4">Programma</th></tr>
</tfoot>
<tbody>

	<?php foreach ($result as $row){
		?><tr><td colspan="2"><?php echo date('d-m-Y',strtotime($row ->datum)); ?></td><td colspan="4"><?php echo nl2br($row->programma); ?></td></tr><?php
	}
	echo "</table>";
}


  ?>