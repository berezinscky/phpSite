<?php
require_once "templateengine_class.php";

class CalcPage extends TemplateEngine{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getPage(){
		session_start();
		//выбираем таблицу для гидро или термо расчётов из GET параметра:
		$table = $_GET["view"];
		//id расчёта для выборки из таблицы из GET параметра:
		$id = $_GET["id"];
		//Название расчёта из таблицы:
		$sr["title"] = $this->db->getFieldOnID($table, $id, "title");
		//Мета-описание страницы расчёта из таблицы:
		$sr["meta_desc"] = $this->db->getFieldOnID($table, $id, "meta_desc");
		//Мета-ключи страницы расчёта из таблицы:
		$sr["meta_key"] = $this->db->getFieldOnID($table, $id, "meta_key");
		//выбираем таблицу для гидро или термо меню согласно GET параметру:
		if ($table=="termocalc") $tableMenu = "termomenu";
		else $tableMenu = "hydromenu";
		
		//генерация части шаблона - меню------
		$arr = $this->db->getAll($tableMenu, "", "");
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
		
		//Генерация формы расчёта в центральной части окна:
		//$sr["center_data"] = $this->db->getFieldOnID($table, $id, "description");
		$center_content = $this->db->getFieldOnID($table, $id, "description");
		$repl = $this->getResultFromSession();//массив данных для формы расчета из сессии (если есть)	
		if ($repl === false) $repl["result"] = "";
		// мы не используем .tpl-файл шаблона, а выводим всё из ячейки таблицы расчётов
		// $sr["center_data"] = str_replace("%table%", $table, $sr["center_data"]);//заменяем %table%
		// $sr["center_data"] = str_replace("%id%", $id, $sr["center_data"]);//заменяем %id%
		// $sr["center_data"] = str_replace("%address%", $this->config->address, $sr["center_data"]);//заменяем %address%
		// $sr["center_data"] = str_replace("%result%", $repl["result"], $sr["center_data"]);//заменяем %result%
		$sr["center_data"]["table"] = $table;
		$sr["center_data"]["id"] = $id;
		$sr["center_data"]["address"] = $this->config->address;
		$sr["center_data"]["result"] = $repl["result"];
		
		//передаём переменные из сессии на php в js-объект:
		$jsScriptStr = "<script> var jsRepl = {};\n";
		foreach($repl as $key => $value){
			$jsScriptStr .= "jsRepl['".$key."'] = '".$value."';\n";
		}
		$jsScriptStr .= "</script>";
		//скрипт обработки формы расчета, и сразу после него текст скрипта по созданию js объекта данных из сессии jsRepl:
		$sr["center_data"]["calcscript"] = $jsScriptStr."\n<script src = ".$this->config->address.$this->config->dir_js."calcscript.js></script>";

		$sr["center_data"] = $this->getReplacedContent($sr["center_data"], $center_content);//заменяем все ключевые слова %между% в форме расчета

		//-------------------------------------
		
		$sr["banners"] = "Место для Вашей рекламы";
		
		//Теперь нужно сохранить $repl в формате json и передать это скрипту в js, а в js все данные запишем в соответствующие
		//поля формы (которая разная для разных расчетов!!!), ну или пустую строку если json объект пустой (при старте страницы с расчётом
		//когда поля должны быть пустыми и нет сессионных переменных из БД таблицы расчёта
		//echo $json_repl = json_encode($repl);
		//примерно так: {"distance":2.2,"time":0.5,"result":4.4}
		
		return $this->getReplacedTemplate($sr, "main");
	}
	
}
?>