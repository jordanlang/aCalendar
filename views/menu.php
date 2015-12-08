<nav>
	<ul>
		<li><a href="<?=BASEURL?>">Home</a></li>
		<?php if(user_connected()) { ?>
			<li><a href="<?=BASEURL?>/index.php/note/mine">My Calendars</a></li>
			<li><a href="<?=BASEURL?>/index.php/note/shared">Shared with me</a></li>
			<?php if(isset($_SESSION['cas']) && $_SESSION['cas']=="yes") { ?>
				<li><a href="<?=BASEURL?>/Connexion/index.php?logout=">Sign out</a></li>
			<?php } else { ?>
				<li><a href="<?=BASEURL?>/index.php/user/signout">Sign out</a></li>
		<?php } } else { ?>
			<li><a href="<?=BASEURL?>/index.php/user/signin">Sign in</a></li>
		<?php }	?>
	</ul>
</nav>
