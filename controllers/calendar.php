<?php

require_once 'models/agenda.php';
require_once 'models/activite.php';
require_once 'models/categorie.php';
require_once 'models/utilisateur.php';

class Controller_Calendar
{
	public function show_calendar() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				//si l'utilisateur est connecté on affiche la page de création d'une note
				if(isset($_SESSION['user'])) {
					include 'views/calendar.php';
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "You aren't connected";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if(isset($_SESSION['user'])) {
					include 'views/calendar.php';
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "You aren't connected";
					include 'views/connexion.php';
				}
				break;
		}	
	}

	public function add_calendar() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				//si l'utilisateur est connecté on affiche la page de création d'une note
				if(isset($_SESSION['user'])) {
					include 'views/createAgenda.php';
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if(isset($_SESSION['user'])) {
					$u = Utilisateur::get_by_login($_SESSION['user']);

					if(isset($_POST['title']) && isset($_POST['content'])) {
						if(isset($_POST['intersection'])) {
							$intersection = 1;
						} else {
							$intersection = 0;
						}
						if(isset($_POST['prive'])) {
							$prive = 1;
						} else {
							$prive = 0;
						}
						if(isset($_POST['partage'])) {
							$partage = 1;
						} else {
							$partage = 0;
						}
						$n = new Agenda(1, $u->idUtilisateur(), $_POST['title'], $_POST['content'], '0', '0', $intersection, $prive, $partage);
						$n->add();
						$_SESSION['message']['type'] = 'success';
						$_SESSION['message']['text'] = "L'agenda ".$_POST['title']." a bien été créé.";
						$this->show_calendar();
					}
					else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Données postées incomplètes';
						$this->show_calendar();
					}
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;
		}	
	}

	public function add_activite() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				//si l'utilisateur est connecté on affiche la page de création d'une note
				if(isset($_SESSION['user'])) {
					$cat = Categorie::get_all_name();
					$u = Utilisateur::get_by_login($_SESSION['user']);
					$agendas = Agenda::get_by_user_name($u->idUtilisateur());
					include 'views/createActivite.php';
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if(isset($_SESSION['user'])) {
					$u = Utilisateur::get_by_login($_SESSION['user']);

					if(isset($_POST['title']) && isset($_POST['content'])) {
						if(isset($_POST['intersection'])) {
							$intersection = 1;
						} else {
							$intersection = 0;
						}
						if(isset($_POST['prive'])) {
							$prive = 1;
						} else {
							$prive = 0;
						}
						if(isset($_POST['partage'])) {
							$partage = 1;
						} else {
							$partage = 0;
						}
						$n = new Agenda(1, $u->idUtilisateur(), $_POST['title'], $_POST['content'], '0', '0', $intersection, $prive, $partage);
						$n->add();
						$_SESSION['message']['type'] = 'success';
						$_SESSION['message']['text'] = "L'agenda ".$_POST['title']." a bien été créé.";
						$this->show_calendar();
					}
					else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Données postées incomplètes';
						$this->show_calendar();
					}
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;
		}	
	}

	public function actualise_date_plus() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				//si l'utilisateur est connecté on affiche la page de création d'une note
				if(isset($_SESSION['user'])) {
					$jour = date("w");

					$datePrecise_ts = date("U", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour'],$_SESSION['annee']));

					$nb_jours = date("t", $datePrecise_ts);
					if($_SESSION['jour']+7 > $nb_jours) {
						if($_SESSION['mois'] >= 12) {
							$_SESSION['mois'] = 1;
							$_SESSION['annee'] = $_SESSION['annee'] + 1;
						} else {
							$_SESSION['mois'] = $_SESSION['mois'] + 1;
						}
						$_SESSION['jour'] = ($_SESSION['jour']+7) - $nb_jours;
					} else {
						$_SESSION['jour'] = $_SESSION['jour']+7;
					}
					
					$dateDebSemaineFr = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour']-$jour+1,$_SESSION['annee']));
					$datePrecise = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour'],$_SESSION['annee']));
					$dateFinSemaineFr = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour']-$jour+7,$_SESSION['annee']));
					include 'views/calendar.php';
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if(isset($_SESSION['user'])) {
					
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;
		}	
	}

	public function actualise_date_moins() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				//si l'utilisateur est connecté on affiche la page de création d'une note
				if(isset($_SESSION['user'])) {
					$jour = date("w");
					
					$datePrecise_ts = date("U", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour'],$_SESSION['annee']));

					$nb_jours = date("t", $datePrecise_ts);
					if($_SESSION['jour']-7 < 0) {
						if($_SESSION['mois'] <= 1) {
							$_SESSION['mois'] = 12;
							$_SESSION['annee'] = $_SESSION['annee'] - 1;
						} else {
							$_SESSION['mois'] = $_SESSION['mois'] - 1;
						}
						$_SESSION['jour'] = ($nb_jours+$_SESSION['jour']) - 8;
					} else {
						$_SESSION['jour'] = $_SESSION['jour'] - 7;
					}

					$dateDebSemaineFr = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour']-$jour+1,$_SESSION['annee']));
					$datePrecise = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour'],$_SESSION['annee']));
					$dateFinSemaineFr = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour']-$jour+7,$_SESSION['annee']));

					include 'views/calendar.php';
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if(isset($_SESSION['user'])) {
					
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;
		}	
	}

	public function actualise_date_maintenant() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				//si l'utilisateur est connecté on affiche la page de création d'une note
				if(isset($_SESSION['user'])) {
					$jour = date("w");

					$_SESSION['mois'] = date("n");
					$_SESSION['jour'] = date("j");
					$_SESSION['annee'] = date("y");

					$dateDebSemaineFr = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour']-$jour+1,$_SESSION['annee']));
					$datePrecise = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour'],$_SESSION['annee']));
					$dateFinSemaineFr = date("d/m/Y", mktime(0,0,0,$_SESSION['mois'],$_SESSION['jour']-$jour+7,$_SESSION['annee']));

					include 'views/calendar.php';
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if(isset($_SESSION['user'])) {
					
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "Vous n'êtes pas connecté";
					include 'views/connexion.php';
				}
				break;
		}	
	}
}

