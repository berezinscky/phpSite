<?php
require_once "templateengine_class.php";

class RegPage extends TemplateEngine{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getPage(){
		$sr["title"] = "Регистрация пользователя";
		$sr["meta_desc"] = "Регистрация на сайте";
		$sr["meta_key"] = "регистрация на сайте, регистрация";
		
		//генерация части шаблона - меню------
		$arr = $this->db->getAll("termomenu", "", "");
		$str = "";
		foreach($arr as $key => $value){
			$sr["menu"]["link"] = $value["link"];
			$sr["menu"]["link_title"] = $value["title"];
			$str .= $this->getReplacedTemplate($sr["menu"], "menu_item");
		}
		$sr["menu"] = $str;
		
		//генерация формы авторизации на стартовой странице
		$sr["auth_user"]["auth_message"] = "Дла авторизации введите имя пользователя и пароль:";
		$sr["auth_user"] = $this->getReplacedTemplate($sr["auth_user"], "auth_form");
			
		//центральная часть сайта, форма регистрации:
		$sr["center_data"]["message"] ="Введите логин и пароль:";
		$sr["center_data"]["login"] ="";
		$sr["center_data"] = $this->getReplacedTemplate($sr["center_data"],"reg_form");
		
		$sr["banners"] = "Место для Вашей рекламы";
		
		return $this->getReplacedTemplate($sr, "main");
	}
	
}
?>