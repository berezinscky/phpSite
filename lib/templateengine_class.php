<?php
require_once "database_class.php";

abstract class TemplateEngine{
	
	public function __construct(){
		$this->db = new DataBase();
		$this->config = new Config();
	}
	//обязательная функция в наследниках - собирает шаблоны и выдает в виде html текста
	abstract public function getPage();
	
	//Функция возврата таблицы с результирующими данными из сессии
	public function getResultFromSession(){
		session_start();
		if (!$_SESSION["result_arr"]) return false;
		$res = $_SESSION["result_arr"];
		//unset($_SESSION["result_arr"]);//удаляем сессионную переменную после того как получили результат
		return $res;
	}
	
	//Функция проверяющая авторизован ли пользователь при открытии всех наследующих классов
	public function isAuth(){
		session_start();
		if (!$_SESSION["user_id"] || !$_SESSION["user_login"]) return false;
		return true;
	}
	
	//Основная функция выдачи шаблона:
	//getReplacedTemplate в полученной строке шаблона из getTemplate при помощи getReplaceContent заменяет все ключевые слова
	//ключевые слова являются ключами массива $sr
	public function getReplacedTemplate($sr, $template){
		return $this->getReplacedContent($sr, $this->getTemplate($template));
	}
	
	//Start Вспомогательные функции для генерации шаблона--------------------------------------------------------------------------------------------
	// getTemplate - на входе название шаблона, на выходе строка шаблона $name с замененными %address - используется далее в getReplaceTemplate
	public function getTemplate($name){
		$text = file_get_contents($this->config->dir_tmpl.$name.".tpl");
		return str_replace("%address%", $this->config->address, $text);
	}
	//getReplaceContent	заменяет все ключевые слова между % в строке $content, полученной из шаблона из функции getTemplate
	//$sr - асс. массив где ключи это то что надо найти, а значения их - на что заменить
	//на выходе строка с замещенными ключевыми словами - т.е. готовый шаблон
	public function getReplacedContent($sr, $content){
		$search = array();
		$replace = array();
		$i = 0;
		foreach($sr as $key => $value){
			$search[$i] = "%".$key."%";
			$replace[$i] = $value;
			$i++;
		}
		return str_replace($search, $replace, $content);
	}
	//End Вспомогательные функции для генерации шаблона--------------------------------------------------------------------------------------------
}
?>