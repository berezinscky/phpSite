<?php
	session_start();
	require_once "lib/database_class.php";
	$db = new DataBase();
	$data = secureData($_POST);
	if (authUser()) redirect($db->config->address);
	
	function authUser(){
		global $db, $data;
		$login = $data["login"];
		if (!$db->isExists("users", "login", $login)){//Проверяем есть ли такой логин
			echo "Такого логина нет";
			return false;
		};
		$password = $data["password"];
		if ($password == ""){//Если не введен пароль
			echo "Пароль не введён";
			return false;
		};
		$password = hashPassword($password);
		//Проверка правильности хэша пароля в таблице с данным логином:
		if ($password != $db->getField("users", "password", "login", $login)){
			echo "Неправильный пароль";
			return false;
		};
		//Если всё ок, сохраняем id и login пользователя в сессии:
		$_SESSION["user_id"]=$db->getField("users", "id", "login", $login);
		$_SESSION["user_login"]=$login;
		return true;
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