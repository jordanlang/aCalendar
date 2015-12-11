<?php 
require_once 'models/agenda.php'; 
require_once 'models/abonnement.php'; 
require_once 'models/utilisateur.php';
?>
<div class="create">
<h2 class="text-center">Mes abonnements</h2>

<form method="post" action="<?=BASEURL?>/index.php/share/search">
	<label for="recherche">Rechercher les agendas d'un autre utilisateur</label>
	<input type="text" id="recherche" name="recherche">
	<input type="submit" value="Rechercher">
</form>


<ul>
<?php for($i=0; $i<count($agendas); $i++) { ?>
	<li>
		<h3><?=$agendas[$i]->nom()?></h3>
		<p><?=$agendas[$i]->description()?></p>
			<?php if(Abonnement::exist($moi->idUtilisateur(), $agendas[$i]->idAgenda())) { ?>
			<form method="post" action="<?=BASEURL?>/index.php/share/desabonnement/<?=$agendas[$i]->idAgenda()?>/<?=$agendas[$i]->nom()?>">
				<input type="submit" value="Je me désabonne">
			</form>
			<?php } else { ?>
			<form method="post" action="<?=BASEURL?>/index.php/share/abonnement/<?=$agendas[$i]->idAgenda()?>/<?=$agendas[$i]->nom()?>">
				<input type="submit" value="Je m'abonne">
			</form>
			<?php } ?>
	</li>
<?php } ?>
</ul>
</div>