<!DOCTYPE html>
<html>
<head>
	<title>%title%</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="%meta_desc%" />
	<meta name="keywords" content="%meta_key%" />
	<link rel="stylesheet" href="%address%css/main.css" type="text/css" />
</head>
<body>

	<div id="header">
		<h2>Тепловые и гидравлические расчеты</h2>
	</div>
	<hr />
		
	<div id="header_menu">
		<ul>
			<li>
				<a href="%address%?view=termocalc&id=1">Тепловые расчеты</a>
			</li>
			<li>
				<a href="%address%?view=hydrocalc&id=1">Гидравлические расчеты</a>
			</li>
			<li>
				<a href="%address%">О сайте</a>
			</li>
		</ul>
	</div>
	
	<div class="clear"></div>
	<hr />
		
	<div id="main_content">
	
		<div id="left">
			<ul>%menu%</ul>
			<div id="authorization">
				%auth_user%
			</div>
		</div>
		
		<div id="right">
			<form name="searchForm" action="%address%" method="get">
				<p>
					Поиск: <input type="text" name="words" />
				</p>
				<p>
					<input type="hidden" name="view" value="search" />
					<input type="submit" name="search" value="Искать" />
				</p>
			</form>
			<h2>Реклама</h2>
			%banners%
		</div>
		
		<div id="center">
			<h1>%title%</h1>
			%center_data%
		</div>
		
	</div>

	<div class="clear"></div>
	<hr />
	
	<div id="footer">
		<p>Все права защищены &copy; 2018</p>
	</div>
</body>
</html>