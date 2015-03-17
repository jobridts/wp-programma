<?php
	$icon_url = plugins_url('images/plugin-menu-icon32.png', __FILE__);
  echo '<div class="wrap">';
  echo '<div id="icon-programma" class="icon32"><img src="'. $icon_url . '"></div><h2>Welkom</h2>';

  ?><p>Welkom op de programma-pagina's.</p>

  <p>Op deze pagina vind je wat uitleg over de verschillende functies.</p>

  		 <p><strong>Goepie invullen:</strong> Op deze pagina kan je het volledig programma toevoegen voor de volgende goepie<br/>
  		 <strong>TIP:</strong> schrijf eerst je programma in een tekstverwerk/op papier/... zodat je altijd een back up hebt (dit blijft een webpagina, en er kan altijd iets mis gaan :-)</p>

  		 <p><strong>Activiteit toevoegen:</strong> Doe je iets voor alle afdelingen/ouders/... (pannenkoekenslag, aspifuif, etc)? Vul dit dan hier in, dan wordt dit automatisch aan de agenda toegevoegd. </p>

  		 <p><strong>E&eacute;n datum toevoegen:</strong> Heb je een weekendje of een activiteit die buiten de volgende goepie valt? Hier is de plaats om die in te vullen.</p>

  		 <p><strong>Archief: </strong> Hier kan je de programma's uit het verleden bekijken. Kan handig zijn als je je eigen programma in elkaar steekt ;-)</p>

  		 <?php if (current_user_can('manage_programma')){ ?>
  		 <p><strong>Opties:</strong> Op deze pagina vul je in hoeveel zondagen er in de volgende goepie zitten (inclusief zondagen waarop het geen chiro is). Je kan hier ook de uiterste datum invullen voor het binnenleveren van het programma.</p>

  		 <p><strong>Zondagen toevoegen:</strong> Hier vul je alle details in voor elke zondag:
  		 <ul>
  		 	<li><strong>datum:</strong> de datum in het formaat JJJJ-MM-DD</li>
  		 	<li><strong>instuif:</strong> duidt dit aan als het een instuif-zondag is</li>
  		 	<li><strong>niet voor:</strong>duidt hier aan welke afdelingen geen programma moeten invullen (tikeas weekend,...)</li>
  		 	<li><strong>niemand invullen:</strong> duidt dit aan als niemand een programma moet invullen (schelle jaarmarkt, planningsweekend,...)</li>
  		 	<li><strong>reden:</strong> Hier vul je in wat er bij de afdelingen die geen chiro hebben in de goepie moet verschijnen</li>
  		 	<li><strong>extra info:</strong> Is er iets dit niet in de goepie moet, maar wat handig is om te weten? Vul dit hier in (de sint komt, een verjaardag,...)</li>
  		 </ul>
  		 </p>
  		 <?php } ?>
  		 </div>
