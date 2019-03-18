<?php
require_once "templateengine_class.php";

class SearchPage extends TemplateEngine{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getPage(){
		session_start();
		$data = $this->secureData($_GET);
		$sr["title"] = "Результаты поиска:";
		$sr["meta_desc"] = $data["words"];
		$sr["meta_key"] = mb_strtolower($data["words"]);
		
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
		
		//Генерация найденных статей в таблице терморасчётов:
		$search_results_array = $this->db->search("termocalc", $data["words"], array("description"));//2-ый массив найденных статей по содержимому (descrition) статьи
		$str = "";
		for ($i=0; $i<count($search_results_array); $i++){
			$id = $search_results_array[$i]["id"];//id в таблице меню равен id в таблице расчётов
			$link = $this->db->getFieldOnID("termomenu", $id, "link");//ссылка из таблицы termomenu по id из termocalc
			$title = $this->db->getFieldOnID("termomenu", $id, "title");//название из таблицы termomenu по id из termocalc
			$sr["search_items"]["title"] = $title;
			$sr["search_items"]["link"] = $link;
			$str .= $this->getReplacedTemplate($sr["search_items"], "search_item");
		}
		//$sr["search_items"] = $str;//по дебильному пишу кривой код - пофиг, НАДО СДЕЛАТЬ ЗАНОВО ПО СВОЕЙ КОНЦЕПЦИИ!!!!
		//заменяем ключевое слово %center_data% в main.tpl на шаблон из search_result.tpl, в котором уже заменены соответствующие ключевые слова link и title
		$sr["center_data"] = "<ol>".$str."</ol>";
		
		$sr["banners"] = "Место для Вашей рекламы";
		
		return $this->getReplacedTemplate($sr, "main");
	}
	
	//Функция корректного замещения спецсимволов:
	private function secureData($data) {
		foreach($data as $key => $value){
			if (is_array($value)) $this->$db->secureData($value);
			else $data[$key] = htmlspecialchars($value);
		}
		return $data;
	}
}
?>