<?php

require_once 'models/user.php';

class Controller_User
{
	public function signin() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				//si l'utilisateur n'est pas connecté on affiche la page de connexion
				if (isset($_SESSION['user'])) {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = 'You are already connected as '.$_SESSION['user'];
				} else {
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['pw'])) {
					if(User::exist($_POST['login'])) {
						$u = User::get_by_login($_POST['login']);
						//pour savoir que l'utilisateur est connecté, on fait en sorte que isset($_SESSION['user']) retourne true
						if (!is_null($u)) {
							if($u->password() == $_POST['pw']) {
								$_SESSION['user'] = $u->login();
								$_SESSION['message']['type'] = 'success';
								$_SESSION['message']['text'] = 'User '.$_SESSION['user'].' successfully signed in';
								include 'views/home.php';
							}
							else {
								$_SESSION['message']['type'] = 'error';
								$_SESSION['message']['text'] = 'Wrong login or password';
								include 'views/connexion.php';
							}
						}
					}
					else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Wrong login or password';
						include 'views/connexion.php';
					}
				} else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = 'Posted data incomplete';
					include 'views/connexion.php';
				}
				break;
		}	
	}

	public function signup() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = 'You are already connected as '.$_SESSION['user'];
					include 'views/home.php';
				} else {
					include 'views/inscription.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['pw']) && isset($_POST['pwConfirm'])) {
					if(User::exist($_POST['login'])) {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Login already exists';
						include 'views/inscription.php';
					}
					else {
						//on compare les mots de passe pour valider l'inscription
						if($_POST['pw'] == $_POST['pwConfirm']) {
							$u = new User(1, $_POST['login'], $_POST['pw']);
							$u->add();
							$_SESSION['user'] = $_POST['login'];
							$_SESSION['message']['type'] = 'success';
							$_SESSION['message']['text'] = 'User '.$_SESSION['user'].' successfully signed up';
							include 'views/home.php';
						}
						else {
							$_SESSION['message']['type'] = 'error';
							$_SESSION['message']['text'] = 'Passwords do not match';
							include 'views/inscription.php';
						}
					}
				} else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = 'Posted data incomplete';
					include 'views/inscription.php';
				}
				break;
		}
	}

	public function signout() {
		unset($_SESSION['user']);
		include 'views/home.php';
	}

	public function profil() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					$u = User::get_by_login($_SESSION['user']);
					$login = $u->login();
					$password = $u->password();
					include 'views/profil.php';
				} else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "You aren't connected";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				$u = User::get_by_login($_SESSION['user']);
				if (!is_null($u)) {
					if($u->password() == $_POST['pwA']) {
						if (isset($_POST['login'])) {
							$u->set_login($_POST['login']);
						}
						if(isset($_POST['pwN'])) {
							$u->set_password($_POST['pwN']);
						}
						$u->save();
						session_destroy();
					}
					else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Wrong password';
					}
				}
				$login = $u->login();
				$password = $u->password();
				include 'views/profil.php';
				break;
		}
	}
}
