<?php
require_once "templateengine_class.php";

class MainPage extends TemplateEngine{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getPage(){
		session_start();
		$sr["title"] = "Тепло-гидро расчёты";
		$sr["meta_desc"] = "Расчёт тепловой и гидродинамический";
		$sr["meta_key"] = "тепловой расчёт, гидродинамический расчёт";
		
		//генерация части шаблона - меню------
		$arr = $this->db->getAll("termomenu", "", "");
		$str = "";
		foreach($arr as $key => $value){
			$sr["menu"]["link"] = $value["link"];
			$sr["menu"]["link_title"] = $value["title"];
			$str .= $this->getReplacedTemplate($sr["menu"], "menu_item");
		}
		$sr["menu"] = $str;
		
		//если пользователь авторизован, то выводим панель пользователя:
		if ($this->isAuth()){
			$sr["auth_user"]["username"] = $_SESSION["user_login"];
			$sr["auth_user"] = $this->getReplacedTemplate($sr["auth_user"], "user_panel");
		}
		else{//иначе генерация формы авторизации на стартовой странице:
			$sr["auth_user"]["auth_message"] = "Дла авторизации введите имя пользователя и пароль:";
			$sr["auth_user"] = $this->getReplacedTemplate($sr["auth_user"], "auth_form");
		}
		
		//Генерация формы расчёта в центральной части окна (пока выводим просто описательные данные из соответствующей ячейки таблицы):
		$sr["center_data"] = "<p>Центральная часть основной страницы</p>";
		
		$sr["banners"] = "Место для Вашей рекламы";
		
		return $this->getReplacedTemplate($sr, "main");
	}
	
}
?>