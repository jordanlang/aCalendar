<?php

require_once 'models/agenda.php';
require_once 'models/activite.php';
require_once 'models/categorie.php';
require_once 'models/utilisateur.php';
require_once 'models/commentaire.php';
require_once 'models/aimecomm.php';

class Controller_Commentaire
{

  public static function doCommentaire($idActivite,$idParent,$descriptif)
  {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
        if(isset($_SESSION['user'])) {
          $activite=Activite::get_by_id($id);
					include 'views/activite.php';
          $commentaires=Commentaire::get_by_activite($id);
          for($j=0;$j<count($commentaires);$j++){
            self::doTree($commentaires[$j],0);
          }
          include 'views/endActivite.php';
  			}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "You aren't connected";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if(isset($_SESSION['user'])) {
          $c= new Commentaire(1,$idActivite,$idParent,$_SESSION['idUser'],'',$descriptif);
          $c->add();
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
}
