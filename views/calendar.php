<li>
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
		echo 'jour courant : '.$jour;
		 
		$num=0;
		 
		$dateDebSemaine = date("Y-m-d", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
		$dateFinSemaine = date("Y-m-d", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));
		     
		$dateDebSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+1,date("y")));
		$dateFinSemaineFr = date("d/m/Y", mktime(0,0,0,date("n"),date("d")-$jour+7,date("y")));
		 
		echo '<div id="titreMois">
		    <a href=""><<</a> Semaine du  : '.$dateDebSemaineFr.' au '.$dateFinSemaineFr.' <a href="">>></a>
		</div> ';
		 
		 
		$jourTexte = array('',1=>'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'Samedi', 'Dimanche');
		$plageH = array(1=>'10:00','11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00');
		 
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
		</div>';
		 
		echo '<table border="1">';
		 
		    // en tête de colonne
		    echo '<tr>';
		    for($k = 0; $k < 8; $k++)
		    {
		        if($k==0)
		            echo '<th>'.$jourTexte[$k].'</th>';
		        else
		            echo '<th><div>'.$jourTexte[$k].' '.date("d", mktime(0,0,0,date("n"),date("d")-$jour+$k,date("y"))).'</div></th>';
		         
		    }
		    echo '</tr>';
		 
		    // les 2 plages horaires : matin - midi
		    for ($h = 1; $h <= 11; $h++)
		    {
		        echo '<tr>
		        <th>
		            <div>'.$plageH[$h].'</div>
		        </th>';
		 
		        // les infos pour chaque jour
		            for ($j = 1; $j < 8; $j++)
		            {
		                echo '<td>
		                </td>';
		            }
		            echo '</td>
		            </tr>';
		    }
		echo '</table>';
		?>
	</p>
</li>