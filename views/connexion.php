<h2 class="text-center">Sign in</h2>

<form method="post" action="<?=BASEURL?>/index.php/user/signin">
	<div class="formline">
		<label for="login">Login</label>
		<input type="text" id="login" name="login">
	</div>
	<div class="formline">
		<label for="pw">Password</label>
		<input type="password" id="pw" name="pw">
	</div>
	<div class="formline">
		<input type="submit" value="Validate">
	</div>
</form>

<p>No account yet ? -> <a href="<?=BASEURL?>/index.php/user/signup">Sign up !</a><p>