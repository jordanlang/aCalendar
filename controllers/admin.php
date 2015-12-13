<?php

require_once 'models/agenda.php';
require_once 'models/activite.php';
require_once 'models/categorie.php';
require_once 'models/abonnement.php';
require_once 'models/utilisateur.php';

class Controller_Admin
{

	public function show_modules() {

    if(isset($_SESSION['user'])) {
      include 'views/administrationModules.php';
    }
    else {
      $_SESSION['message']['type'] = 'error';
      $_SESSION['message']['text'] = "You aren't connected";
      include 'views/connexion.php';
    }


  }

  public function users() {

    if(isset($_SESSION['user'])) {
      $u=Utilisateur::get_all();
      include 'views/adminUser.php';
    }
    else {
      $_SESSION['message']['type'] = 'error';
      $_SESSION['message']['text'] = "You aren't connected";
      include 'views/connexion.php';
    }
  }

  public function agendas() {

    if(isset($_SESSION['user'])) {
      $a=Agenda::get_all();
      include 'views/adminAgenda.php';
    }
    else {
      $_SESSION['message']['type'] = 'error';
      $_SESSION['message']['text'] = "You aren't connected";
      include 'views/connexion.php';
    }
  }

  public function commentaires() {

    if(isset($_SESSION['user'])) {
      $c=Commentaire::get_all();
      include 'views/adminComm.php';
    }
    else {
      $_SESSION['message']['type'] = 'error';
      $_SESSION['message']['text'] = "You aren't connected";
      include 'views/connexion.php';
    }
  }

  





}
