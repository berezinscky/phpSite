<?php
	session_start();
	require_once "lib/database_class.php";
	$db = new DataBase();
	$data = secureData($_POST);
	if (regUser()) redirect($db->config->address);
	
	function regUser(){
		global $db, $data;
		$captcha = $data["captcha"];
		if (($_SESSION["rand"] != $captcha) || ($_SESSION["rand"] == "")) {//Если неправильно введена каптча
			echo "Что-то с каптчей";
			return false;
		};
		$login = $data["login"];
		if ($db->isExists("users", "login", $login)){//Если пользователь с данным ником уже существует
			echo "Что-то с логином";
			return false;
		};
		$password = $data["password"];
		if ($password == ""){//Если не введен пароль
			echo "Что-то с паролем";
			return false;
		};
		$password = hashPassword($password);
		//добавляем пользователя
		addUser($login, $password);
		//Если всё ок, сохраняем id и login пользователя в сессии:
		$_SESSION["user_id"]=$db->getField("users", "id", "login", $login);
		$_SESSION["user_login"]=$login;
		return true;
	}
	
	function addUser($login, $password){
		global $db;
		$db->insert("users", array("login" => $login, "password" => $password));
	}
	
	function redirect($link){
		header("Location: $link");
		exit;
	}
	
	//Функция корректного замещения спецсимволов:
	function secureData($data) {
		global $db;
		foreach($data as $key => $value){
			if (is_array($value)) $db->secureData($value);
			else $data[$key] = htmlspecialchars($value);
		}
		return $data;
	}
	
	//Функция хэширования пароля с сдобавлением секретного слова в конце пароля
	function hashPassword($password){
		global $db;
		return md5($password.$db->config->secret);
	}
	
?>