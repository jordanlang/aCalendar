<?php

require_once 'base.php';

class User extends Model_Base
{
	private $_id;

	private $_login;

	private $_password;

	public function __construct($id, $login, $password) {
		$this->set_id($id);
		$this->set_login($login);
		$this->set_password($password);
	}

	//get

	public function id() {
		return $this->_id;
	}

	public function login() {
		return $this->_login;
	}

	public function password() {
		return $this->_password;
	}

	//set

	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_login($v) {
		$this->_login = strval($v);
	}

	public function set_password($v) {
		$this->_password = strval($v);
	}

	public function add() {
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('INSERT INTO users (login, mdp) VALUES (:login, :password)');
			$q->bindValue(':login', $this->_login, PDO::PARAM_STR);
			$q->bindValue(':password', $this->_password, PDO::PARAM_STR);
			$q->execute();
		}
	}

	public function save()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('UPDATE users SET login=:login, mdp=:password WHERE id = :id');
			$q->bindValue(':id', $this->_id, PDO::PARAM_INT);
			$q->bindValue(':login', $this->_login, PDO::PARAM_STR);
			$q->bindValue(':password', $this->_password, PDO::PARAM_STR);
			$q->execute();
		}
	}

	public function delete()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('DELETE FROM users WHERE id = :id');
			$q->bindValue(':id', $this->_id);
			$q->execute();
			$this->_id = null;
		}
	}

	public static function get_by_login($login) {
		$s = self::$_db->prepare('SELECT * FROM users where login = :l');
		$s->bindValue(':l', $login, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new User($data['id'], $data['login'], $data['mdp']);
		} else {
			return null;
		}
	}

	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM users where id = :i');
		$s->bindValue(':i', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new User($data['id'], $data['login'], $data['mdp']);
		} else {
			return null;
		}
	}

	public static function exist($login) {
		$s = self::$_db->prepare('SELECT * FROM users where login = :l');
		$s->bindValue(':l', $login, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if($data) {
			return true;
		}
		else {
			return false;
		}
	}
}
