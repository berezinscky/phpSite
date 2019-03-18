<?php
require_once "lib/database_class.php";
$db = new DataBase();
$data = secureData($_POST);
$tableCalc = $data["table_calc"];//Таблица расчета (термо или гидро)
$idCalc = $data["id_calc"];//id расчета из соответствующей таблицы

switch ($tableCalc){//по заданной таблице и номеру id-расчета, запускаем соответствующую функцию расчёта (реализация каждой ниже switch-a)
	case "termocalc":
		switch ($idCalc){
			case "1":
				t1($data);
				break;
			case "2":
				t2($data);
				break;
		}
		break;
	case "hydrocalc":
		switch ($idCalc){
			case "1":
				h1($data);
				break;
			case "2":
				h2($data);
				break;
		}
		break;
	default:;//если не найдены таблицы в будущем надо это реализовать...
}

//возвращаемся к текущему расчету (сохранив данные в сессии)
redirect($db->config->address."?view=".$data["table_calc"]."&id=".$data["id_calc"]);


//-------------------------Тела функций:-----------------------------------------

//----------Функции тепловых расчётов:----------
function t1($data){
	$session_arr["distance"] = $data["distance"];
	$session_arr["time"] = $data["time"];
	settype($session_arr["distance"], "float");
	settype($session_arr["time"], "float");
	$session_arr["result"] = $session_arr["distance"] / $session_arr["time"];
	session_start();
	$_SESSION["result_arr"] = $session_arr;//сохраним в сессии весь массив с полями ввода в форму и полем результата вычислений
}

function t2($data){
	
}

//---------Функции гидравлических расчётов:----------
function h1($data){
	
}

function h2($data){
	
}

//Вспомогательные функции:
//Функция корректного замещения спецсимволов:
function secureData($data) {
	global $db;
	foreach($data as $key => $value){
		if (is_array($value)) $db->secureData($value);
		else $data[$key] = htmlspecialchars($value);
	}
	return $data;
}
//редирект по адресу:
function redirect($link){
		header("Location: $link");
		exit;
	}
	
	
//Это пример вычисления скорости, для проверки как работает - удалить как закончу реализацию
//производим расчеты и формируем результирующий массив для сохранения в сессии:
/* 
$session_arr["distance"] = $data["distance"];
$session_arr["time"] = $data["time"];
settype($session_arr["distance"], "float");
settype($session_arr["time"], "float");
$session_arr["result"] = $session_arr["distance"] / $session_arr["time"];
session_start();
$_SESSION["result_arr"] = $session_arr;//сохраним в сессии весь массив с полями ввода в форму и полем результата вычислений
 */
//------------------------------

?>