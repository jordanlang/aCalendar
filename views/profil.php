<p> Login : <?php echo $login; ?></p>
<p> Mot de passe : <?php echo $password; ?></p>

<form method="post" action="index.php?action=profil">
	<h1>Modifier le profil</h1> <br>
	<label for="pwA">Mot de passe actuel</label>
	<input type="password" id="pwA" name="pwA">
	<br>
	<label for="login">Login</label>
	<input type="text" id="login" name="login">
	<label for="pwN">Nouveau mot de passe</label>
	<input type="password" id="pwN" name="pwN">
	<input type="submit">
</form>

<br><a href="http://iin-etu.u-strasbg.fr/~jordan.lang/W31/index.php" title="accueil"><img src="views/accueil.png"/></a>