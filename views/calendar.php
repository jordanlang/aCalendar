<li>
	<div class="myCal">
		<a href="<?=BASEURL?>/index.php/calendar/add_calendar/<?php echo $id; ?>">+</a>
	</div>
	<div class="actualCal">
		<h2>
			<?php echo $title; ?>
		</h2>
		<p>
			<?php echo $content; ?>
		</p>
		<p class="text-right">
			<a href="<?=BASEURL?>/index.php/note/update_note/<?php echo $id; ?>"> Edit </a>
			<br>
			<a href="<?=BASEURL?>/index.php/note/delete_note/<?php echo $id; ?>"> Delete </a>
		</p>
		<p>
			<?php
			$jour = date("w");
			//echo 'jour courant : '.$jour;
			$heure = date("H");
			$num=0;

			$dateDebSemaine = date("Y-m-d", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
			$dateFinSemaine = date("Y-m-d", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));

			$dateDebSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
			$dateFinSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));



			$jourTexte = array('',1=>'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.', 'dim.');
			$plageH = array(1=>'00:00','01:00','02:00','03:00','04:00','05:00','06:00',
				'07:00','08:00','09:00','10:00','11:00', '12:00', '13:00', '14:00', '15:00',
				'16:00', '17:00', '18:00', '19:00', '20:00','21:00','22:00','23:00'
		 	);

			$nom_mois = date('F');

			switch($nom_mois)
			{
			    case 'Junuary' : $nom_mois = 'Janvier'; break;
			    case 'February' : $nom_mois = 'Février'; break;
			    case 'March' : $nom_mois = 'Mars'; break;
			    case 'April' : $nom_mois = 'Avril'; break;
			    case 'May' : $nom_mois = 'Mai'; break;
			    case 'June' : $nom_mois = 'Juin'; break;
			    case 'July' : $nom_mois = 'Juillet'; break;
			    case 'August' : $nom_mois = 'Août'; break;
			    case 'September' : $nom_mois = 'Septembre'; break;
			    case 'October' : $nom_mois = 'Otober'; break;
			    case 'November' : $nom_mois = 'Novembre'; break;
			    case 'December' : $nom_mois = 'Décembre'; break;

			}

			echo '<br/>
			<div id="titreMois">
			    <strong>'.$nom_mois.' '.date('Y').'</strong>
					<br/>
			</div>';
			echo '<div class="text-right">
			    <a href=""><<</a> <a href="">Aujourd\'hui</a> <a href="">>></a>
			</div> ';



			echo '<table border="1" class="cal">';

			    // en tête de colonne
			    echo '<tr>';
			    for($k = 0; $k < 8; $k++)
			    {
			        if($k==0)
			            echo '<th>'.$jourTexte[$k].'</th>';
			        else
								if($k==$jour)
			            echo '<th><div style="color: #C8F0C8;font-size: small;">'.$jourTexte[$k].' '.date("d", mktime(0,0,0,date("n"),date("d")-$jour+$k,date("y"))).'</div></th>';
									else {
										if($k==7 || $k==6)
											echo '<th><div style="color: gray;font-size: small;">'.$jourTexte[$k].' '.date("d", mktime(0,0,0,date("n"),date("d")-$jour+$k,date("y"))).'</div></th>';
										else {
											echo '<th><div style="font-size: small;">'.$jourTexte[$k].' '.date("d", mktime(0,0,0,date("n"),date("d")-$jour+$k,date("y"))).'</div></th>';
										}
									}

			    }
			    echo '</tr>';

			    // les 2 plages horaires : matin - midi
			    for ($h = 1; $h <= 24; $h++)
			    {
						if($h==$heure)
							echo '<tr>
							<th>
									<div style="color: #C8F0C8;font-size: small;">'.$plageH[$h].'</div>
							</th>';
						else
			        echo '<tr>
			        <th>
			            <div style="color: gray;font-size: small;">'.$plageH[$h].'</div>
			        </th>';

			        // les infos pour chaque jour
            for ($j = 1; $j < 8; $j++)
            {
							if($j==$jour && $h==$heure)
								echo '<td style="background-color: #C8F0C8;">
									</td>';
							else {
								if($j==6 || $j==7)
	                echo '<td style="background-color: rgb(228, 228, 228);">
	                </td>';
								else
										echo '<td>
		                </td>';
          		}
						}
						echo '</td>
						</tr>';
			    }
			echo '</table>';
			?>
		</p>
	</div>
</li>
