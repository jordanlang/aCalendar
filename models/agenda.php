<?php

require_once 'base.php';

class Note extends Model_Base
{
	private $_id;

	private $_title;

	private $_content;

	private $_autor;

	private $_lastEditer;

	private $_addDate;

	public function __construct($id, $title, $content, $autor, $lastEditer, $addDate) {
		$this->set_id($id);
		$this->set_title($title);
		$this->set_content($content);
		$this->set_autor($autor);
		$this->set_lastEditer($lastEditer);
		$this->set_addDate($addDate);
	}

	//get

	public function id() {
		return $this->_id;
	}

	public function title() {
		return $this->_title;
	}

	public function content() {
		return $this->_content;
	}

	public function autor() {
		return $this->_autor;
	}

	public function lastEditer() {
		return $this->_lastEditer;
	}

	public function addDate() {
		return $this->_addDate;
	} 

	//set

	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_title($v) {
		$this->_title = strval($v);
	}

	public function set_content($v) {
		$this->_content = strval($v);
	}

	public function set_autor($v) {
		$this->_autor = strval($v);
	}

	public function set_lastEditer($v) {
		$this->_lastEditer = strval($v);
	}

	public function set_addDate($v) {
		$this->_addDate = strval($v);
	}

	public function add() {
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('INSERT INTO notes (title, content, autor, lastEditer, addDate) VALUES (:title, :content, :autor, :lastEditer, :addDate)');
			$q->bindValue(':title', $this->_title, PDO::PARAM_STR);
			$q->bindValue(':content', $this->_content, PDO::PARAM_STR);
			$q->bindValue(':autor', $this->_autor, PDO::PARAM_STR);
			$q->bindValue(':lastEditer', $this->_lastEditer, PDO::PARAM_STR);
			$q->bindValue(':addDate', $this->_addDate, PDO::PARAM_STR);
			$q->execute();
		}
	}

	public function save()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('UPDATE notes SET title=:title, content=:content, autor=:autor, lastEditer=:lastEditer, addDate=:addDate WHERE id = :id');
			$q->bindValue(':id', $this->_id, PDO::PARAM_INT);
			$q->bindValue(':title', $this->_title, PDO::PARAM_STR);
			$q->bindValue(':content', $this->_content, PDO::PARAM_STR);
			$q->bindValue(':autor', $this->_autor, PDO::PARAM_STR);
			$q->bindValue(':lastEditer', $this->_lastEditer, PDO::PARAM_STR);
			$q->bindValue(':addDate', $this->_addDate, PDO::PARAM_STR);
			$q->execute();
		}
	}

	public function delete()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('DELETE FROM notes WHERE id = :id');
			$q->bindValue(':id', $this->_id);
			$q->execute();
			
			$s = self::$_db->prepare('DELETE FROM shared WHERE idNote=:idNote');
			$s->bindValue(':idNote', $this->_id, PDO::PARAM_INT);
			$s->execute();

			$this->_id = null;
		}
	}

	public static function get_by_title($title) {
		$s = self::$_db->prepare('SELECT * FROM notes where title = :t');
		$s->bindValue(':t', $title, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Note($data['id'], $data['title'], $data['content'], $data['autor'], $data['lastEditer'], $data['addDate']);
		} else {
			return null;
		}
	}

	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM notes where id = :i');
		$s->bindValue(':i', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Note($data['id'], $data['title'], $data['content'], $data['autor'], $data['lastEditer'], $data['addDate']);
		} else {
			return null;
		}
	}

	public static function exist($title) {
		$s = self::$_db->prepare('SELECT * FROM notes where title = :t');
		$s->bindValue(':t', $title, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if($data) {
			return true;
		}
		else {
			return false;
		}
	}

	public static function shareExist($idNote, $idUser) {
		$s = self::$_db->prepare('SELECT * FROM shared where idNote=:idNote and idUser=:idUser');
		$s->bindValue(':idNote', $idNote, PDO::PARAM_INT);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if($data) {
			return true;
		}
		else {
			return false;
		}
	}

	public static function shareAdd($idNote, $idUser, $update, $delete) {
		if(!(self::shareExist($idNote, $idUser))) {
			$s = self::$_db->prepare('INSERT INTO shared (idNote, idUser, up, del) VALUES (:idNote, :idUser, :up, :del)');
			$s->bindValue(':idNote', $idNote, PDO::PARAM_INT);
			$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
			$s->bindValue(':up', $update, PDO::PARAM_INT);
			$s->bindValue(':del', $delete, PDO::PARAM_INT);
			$s->execute();
		}
	}

	public static function shareUpdate($idNote, $idUser, $update, $delete) {
		if(self::shareExist($idNote, $idUser)) {
			$s = self::$_db->prepare('UPDATE shared SET up=:up, del=:del WHERE idUser=:idUser and idNote=:idNote');
			$s->bindValue(':idNote', $idNote, PDO::PARAM_INT);
			$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
			$s->bindValue(':up', $update, PDO::PARAM_INT);
			$s->bindValue(':del', $delete, PDO::PARAM_INT);
			$s->execute();
		}
	}

	public static function shareDelete($idNote, $idUser) {
		if(self::shareExist($idNote, $idUser)) {
			$s = self::$_db->prepare('DELETE FROM shared WHERE idUser=:idUser and idNote=:idNote');
			$s->bindValue(':idNote', $idNote, PDO::PARAM_INT);
			$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
			$s->execute();
		}
	}

	public static function listNotes($user) {
		$s = self::$_db->prepare('SELECT * FROM notes where autor = :a');
		$s->bindValue(':a', $user, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	public static function listSharedWithUser($user) {
		$s = self::$_db->prepare('SELECT * FROM shared where idUser = (SELECT id FROM users WHERE login = :l)');
		$s->bindValue(':l', $user, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	public static function listUsersShared($idNote) {
		$s = self::$_db->prepare('SELECT * FROM shared where idNote=:idNote');
		$s->bindValue(':idNote', $idNote, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	public static function listShare($idNote, $idUser) {
		$s = self::$_db->prepare('SELECT * FROM shared where idNote=:idNote and idUser=:idUser');
		$s->bindValue(':idNote', $idNote, PDO::PARAM_INT);
		$s->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if($data) {
			return $data;
		}
		else {
			return 0;
		}
		
	}
}