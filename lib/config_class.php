<?php

class Config{
	
	var $sitename = "TermoHydroCalculator";
	//var $address = "http://TermoHydroCalculator/"; по окончании удалить нижний а этот раскомментить
	var $address = "http://site.local/";
	var $secret = "make secret word";
	var $host = "localhost";
	var $db = "termohidrocalc";
	var $db_prefix = "firstsite_";
	var $user = "root";
	var $password = "";
	var $admname = "Николай Березинский";
	var $admemail = "berezinn@mail.ru";
	var $dir_tmpl = "tmpl/";
	var $dir_js = "scrjs/";
	
	var $min_login = 3;
	var $max_login = 255;
}

?>