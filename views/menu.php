<nav>
	<ul>
		<li><a href="<?=BASEURL?>">Home</a></li>
		<?php if(user_connected()) { ?>
			<li><a href="<?=BASEURL?>/index.php/calendar/show_calendar">Mes agendas</a></li>
			<li><a href="<?=BASEURL?>/index.php/share/show_share">Mes abonnements</a></li>
			<?php if(isset($_SESSION['cas']) && $_SESSION['cas']=="yes") { ?>
				<li><a href="<?=BASEURL?>/Connexion/index.php?logout=">Déconnexion</a></li>
			<?php } else { ?>
				<li><a href="<?=BASEURL?>/index.php/user/signout">Déconnexion</a></li>
		<?php } } else { ?>
			<li><a href="<?=BASEURL?>/index.php/user/signin">Connexion</a></li>
		<?php }	?>
	</ul>
</nav>
