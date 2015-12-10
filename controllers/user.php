<?php

/**
* \file      controllers/user.php
* \author    Jérémy Spieldenner
* \version   1.0
* \date      20 Octobre 2014
* \brief     Contrôle la correction
*
* \details   Cette classe permet la création d'un utilisateur de part son inscription, et gère également sa connexion ainsi que sa déconnexion.
*/

require_once 'models/utilisateur.php';

class Controller_User
{
	/**
	* \brief     Affiche la page de connexion et gère la connexion d'un utilisateur.
	*/
	public function signin() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					$_SESSION['user'] = $u->pseudo();
					show_message('message_success',"You're already connected as ".$_SESSION['user']);
					include 'views/calendar.php';
				}
				else {
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['pw'])) {
					
					$u = Utilisateur::get_by_login(htmlspecialchars($_POST['login']));
					if (!is_null($u)) {
						if ($u->mdp() == sha1($_POST['pw']))
						{
							$_SESSION['user'] = $u->pseudo();
							show_message('message_success',"Vous êtes connecté");
							include 'views/calendar.php';
						}
						else {
							show_message('message_error',"Echec de connexion : login ou mot de passe incorrect");
							include 'views/connexion.php';
						}
					}
					else {
						show_message('message_error',"Echec de connexion : login ou mot de passe incorrect");
						include 'views/connexion.php';
					}
				}
				else {
						show_message('message_error',"Données incompletes!");
						include 'views/connexion.php';
				}
				break;
		}
	}

	/**
	* \brief     Affiche la page d'inscription et gère la création d'un nouvel utilisateur d'après les données réceptionnées.
	*/
	public function signup() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					show_message('message_success',"Déjà connecté en tant que ".$_SESSION['user']);
					include 'views/home.php';
				}
				else {
					include 'views/inscription.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['pw']) && isset($_POST['pwConfirm'])) {
					$exist = Utilisateur::exist(htmlspecialchars($_POST['login']));
					if (!$exist) {
						if($_POST['pw'] == $_POST['pwConfirm']) {
							//Fonction sha1 permet crypté le mot de passe
							$u = new Utilisateur(1, NULL, NULL, NULL, htmlspecialchars($_POST['login']), sha1($_POST['pw']), NULL, NULL);
							/*$_POST['nom'] = "Jordan";
							$_POST['prenom'] = "Coucou";
							$_POST['adresse'] = "sgifren";
							$_POST['email'] = "hcueiuc";*/
							if(isset($_POST['nom'])) {
								$u->set_nom(htmlspecialchars($_POST['nom']));
							}
							if(isset($_POST['prenom'])) {
								$u->set_prenom(htmlspecialchars($_POST['prenom']));
							}
							if(isset($_POST['adresse'])) {
								$u->set_adresse(htmlspecialchars($_POST['adresse']));
							}
							if(isset($_POST['email'])) {
								$u->set_email(htmlspecialchars($_POST['email']));
							}
							$u->add();
							show_message('message_success',"Inscription de ".$_POST['login'].' !');
							include 'views/home.php';
						}
						else {
							show_message('message_error',"Pas le même mot de passe");
							include 'views/inscription.php';
						}
					}
					else {
						show_message('message_error',"Entrer d'autres informations");
						include 'views/inscription.php';
					}
				}
				else {
						show_message('message_error',"Données incomplètes");
						include 'views/inscription.php';
				}
				break;
		}
	}

	/**
	* \brief     Gère la deconnexion d'un utilisateur et le redirige sur la page d'acceuil.
	*/
	public function signout() {
		unset($_SESSION['user']);
		header('Location: '.BASEURL.'/index.php');
	}
}
/*
require_once 'models/utilisateur.php';

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
}*/
