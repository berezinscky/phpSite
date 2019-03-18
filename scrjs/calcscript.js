//jsRepl["keys"] = "values" - объект со значениями из сессии или пустой объект если их нет.
var calcForm = document.getElementById('calc_form');

for (var key in jsRepl){
	var inputTextValues = calcForm.querySelector('input[name="'+ key +'"]');
	inputTextValues.value = jsRepl[key];
}