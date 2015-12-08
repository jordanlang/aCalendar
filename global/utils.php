<?php

function user_connected() {
		if(isset($_SESSION['user'])) {
			return $_SESSION['user'];
		}
}

function message() {
	$_SESSION['message'] = array(
			'type' => $type,
			'text' => $text
	);
}