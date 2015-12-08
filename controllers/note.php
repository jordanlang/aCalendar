<?php

require_once 'models/note.php';
require_once 'models/user.php';

class Controller_Note
{
	public function add_note() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				//si l'utilisateur est connecté on affiche la page de création d'une note
				if(isset($_SESSION['user'])) {
					include 'views/create.php';
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "You aren't connected";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				//si l'utilisateur est connecté et que tous les champs ont bien été remplis, on crée la note en l'ajoutant à la base de données
				if(isset($_SESSION['user'])) {
					if(isset($_POST['title']) && isset($_POST['content'])) {
						$n = new Note(1, $_POST['title'], $_POST['content'], $_SESSION['user'], $_SESSION['user'], date('Y-m-d H:i:s'));
						$n->add();
						$_SESSION['message']['type'] = 'success';
						$_SESSION['message']['text'] = 'Note '.$_POST['title'].' successfully added';
						$this->mine();
					}
					else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Posted data incomplete';
						$this->mine();
					}
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "You aren't connected";
					include 'views/connexion.php';
				}
				break;
		}	
	}

	public function update_note($id_note) {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if(isset($_SESSION['user'])) {
					if(isset($id_note)) {
						//on affiche la page d'édition de note en envoyant les informations nécessaires
						$n = Note::get_by_id($id_note);
						$idNote = $id_note;
						$title = $n->title();
						$text = $n->content();
						$autor = $n->autor();
						//création de la liste des utilisateurs avec lesquels la note a été partagée
						$sharedWith = "";
						$data = Note::listUsersShared($idNote);
						if($data) {
							$user = User::get_by_id($data[0]['idUser']);
							$userLogin = $user->login();
							$sharedWith = $userLogin;
							for($i=1; $i<count($data); $i++) {
								$user = User::get_by_id($data[$i]['idUser']);
								$userLogin = $user->login();
								$sharedWith = $sharedWith . ', ' . $userLogin;
							}
						}					
						include 'views/edit.php';
					}
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "You aren't connected";
					include 'views/connexion.php';
				}
				break;

			case 'POST' :
				if(isset($_SESSION['user'])) {
					if(isset($_POST['title']) || isset($_POST['content'])) {
						//on met à jour les informations de la note
						$n = Note::get_by_id($id_note);
						$n->set_title($_POST['title']);
						$n->set_content($_POST['content']);
						$n->set_lastEditer($_SESSION['user']);
						$n->set_addDate(date('Y-m-d H:i'));
						$n->save();
						$_SESSION['message']['type'] = 'success';
						$_SESSION['message']['text'] = 'Note successfully updated';
						$this->mine();
					}
					else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'No edits';
						$this->mine();
					}
				}
				else {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = "You aren't connected";
					include 'views/connexion.php';
				}
				break;
		}
	}

	public function share_note($id_note) {
		if(isset($_SESSION['user'])) {
			if(isset($_POST['sharedWith'])) {
				//on traite la chaîne des utilisateurs à qui partager la note
				$userList = str_replace(' ', '', $_POST['sharedWith']); //suppression des espaces dans la chaîne
				$users = explode(',', $userList);
				$nbUsers = count($users);
				$usersDontExist = ""; 
				$usersShareAdd = "";
				$usersShareUpdate = "";
				for($i=0; $i<$nbUsers; $i++) {
					if(User::exist($users[$i])) {
						$user = User::get_by_login($users[$i]);
						$idUser = $user->id();
						if(isset($_POST['updateChoice'])) {
							$update = 1;
						}
						else {
							$update = 0;
						}
						if(isset($_POST['deleteChoice'])) {
							$delete = 1;
						}
						else {
							$delete = 0;
						}
						//si le partage existe on l'édite, sinon on le crée
						if(!(Note::shareExist($id_note, $idUser))) {
							Note::shareAdd($id_note, $idUser, $update, $delete);
							$usersShareAdd = $usersShareAdd . ', ' . $users[$i];
						}
						else {
							Note::shareUpdate($id_note, $idUser, $update, $delete);
							$usersShareUpdate = $usersShareUpdate . ', ' . $users[$i];
						}
					}
					else {
						$usersDontExist = $usersDontExist . ', ' . $users[$i];
					}
				}
				$usersDontExist = substr($usersDontExist, 2);
				$usersShareAdd = substr($usersShareAdd, 2);
				$usersShareUpdate = substr($usersShareUpdate, 2);

				//récupérer la liste des utilisateurs avec lesquels la note est partagée
				$data = Note::listUsersShared($id_note);
				$nbData = count($data);

				//tester les utilisateurs qui n'apparaissent pas dans le champ sharedWith
				$usersToDelete = "";
				for($i=0; $i<$nbData; $i++) {
					$found=false;
					$user = User::get_by_id($data[$i]['idUser']);
					$userLogin = $user->login();
					for($j=0; $j<$nbUsers; $j++) {
						if(User::exist($users[$j])) {
							if($users[$j] == $userLogin) {
								$found=true;
							}
						}
					}
					//supprimer ces derniers
					if(!$found) {
						Note::shareDelete($id_note, $user->id());
						$usersToDelete = $usersToDelete . ', ' . $userLogin;
					}
				}
				$usersToDelete = substr($usersToDelete, 2);

				//affichage des modifications après un update des personnes à qui on partage une note
				$message_text = "";
				if($usersDontExist != "") {
					$message_text = $message_text . "User(s) " . $usersDontExist . " doesn't exists<br>";
				}
				if($usersShareAdd != "") {
					$message_text = $message_text . "Share with " . $usersShareAdd . " successfully added<br>";
				}
				if($usersShareUpdate != "") {
					$message_text = $message_text . "Share with " . $usersShareUpdate . " successfully updated<br>";
				}
				if($usersToDelete != "") {
					$message_text = $message_text . "Share with " . $usersToDelete . " successfully deleted";
				}
				if($message_text != "") {
					$_SESSION['message']['type'] = 'success';
					$_SESSION['message']['text'] = $message_text;
				}
				$this->mine();
			}
			else {
				//si aucun utilisateur n'est en partage après un update, on supprime tous les partages en relation avec cette note
				$_SESSION['message']['type'] = 'error';
				$_SESSION['message']['text'] = 'No user for sharing';
				$data = Note::listUsersShared($id_note);
				$nbData = count($data);
				for($i=0; $i<$nbData; $i++) {
					Note::shareDelete($id_note, $data[$i]['idUser']);
				}
				$this->mine();
			}
		}
		else {
			$_SESSION['message']['type'] = 'error';
			$_SESSION['message']['text'] = "You aren't connected";
			include 'views/connexion.php';
		}
	}

	public function delete_note($id_note) {
		if(isset($_SESSION['user'])) {
			$n = Note::get_by_id($id_note);
			if($n->autor() == $_SESSION['user']) {
				$n->delete();
			}
			$this->mine();
		}
		else {
			$_SESSION['message']['type'] = 'error';
			$_SESSION['message']['text'] = "You aren't connected";
			include 'views/connexion.php';
		}
	}

	public function delete_note_shared($id_note) {
		if(isset($_SESSION['user'])) {
			$u = User::get_by_login($_SESSION['user']);
			Note::shareDelete($id_note, $u->id());
			$this->shared();
		}
		else {
			$_SESSION['message']['type'] = 'error';
			$_SESSION['message']['text'] = "You aren't connected";
			include 'views/connexion.php';
		}
	}

	public function mine() {
		if(isset($_SESSION['user'])) {
			$data = Note::listNotes($_SESSION['user']);
			$nbNotes = count($data);
			include 'views/notesHeader.php';
			if($nbNotes == 0) {
				$error_message = "Aucune note n'a encore été créée";
				include 'views/error.php';
			}
			else {
				for($i=0; $i < $nbNotes; $i++) {
					$id = $data[$i]['id'];
					$title = $data[$i]['title'];
					$content = $data[$i]['content'];
					$lastEditer = $data[$i]['lastEditer'];
					$addDate = $data[$i]['addDate'];
					include 'views/notes.php';
				}
			}
			include 'views/notesFooter.php';
		}
		else {
			$_SESSION['message']['type'] = 'error';
			$_SESSION['message']['text'] = "You aren't connected";
			include 'views/connexion.php';
		}
	}

	public function shared() {
		if(isset($_SESSION['user'])) {
			$data = Note::listSharedWithUser($_SESSION['user']);
			$nbNotes = count($data);
			include 'views/sharedHeader.php';
			if($nbNotes == 0) {
				$error_message = "Aucune note n'a été partagée avec vous...";
				include 'views/error.php';
			}
			else {
				for($i=0; $i < $nbNotes; $i++) {
					$note = Note::get_by_id($data[$i]['idNote']);
					$user = User::get_by_login($_SESSION['user']);
					$idUser = $user->id();
					$id = $note->id();
					$title = $note->title();
					$autor = $note->autor();
					$content = $note->content();
					$lastEditer = $note->lastEditer();
					$addDate = $note->addDate();

					$share = Note::listShare($id, $idUser);
					$editRight = false;
					if($share['up'] == 1) {
						$editRight = true;
					}
					$deleteRight = false;
					if($share['del'] == 1) {
						$deleteRight = true;
					}
					
					include 'views/shared.php';
				}
			}
			include 'views/sharedFooter.php';
		}
		else {
			$_SESSION['message']['type'] = 'error';
			$_SESSION['message']['text'] = "You aren't connected";
			include 'views/connexion.php';
		}
	}
}

