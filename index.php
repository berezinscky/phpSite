<?php
	mb_internal_encoding("UTF-8");
	require_once "lib/regpage_class.php";
	require_once "lib/mainpage_class.php";
	require_once "lib/calcpage_class.php";
	require_once "lib/searchpage_class.php";

	$view = $_GET["view"];
	switch ($view){
		case "":
			$page = new MainPage();
			break;
		case "termocalc":
		case "hydrocalc":
			$page = new CalcPage();
			break;
		case "reg":
			$page = new RegPage();
			break;
		case "search":
			$page = new SearchPage();
		//default: $page = new NotFoundPage($db);
	}
	echo $page->getPage();
?>