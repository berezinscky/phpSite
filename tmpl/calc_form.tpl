// файл не используется в проекте - временно: для создания форм и вставки в БД в поля description соответствующих таблиц
<div id="calc_form">
	<form name="calc" action="%address%calculations.php" method="post">
		<table>
			<tr>
				<td>Расстояние, м:</td>
				<td>
					<input type="text" name="distance" value=""/>
				</td>
			</tr>
			<tr>
				<td>Время, с:</td>
				<td>
					<input type="text" name="time" value=""/>
				</td>
			</tr>
			<tr>
				<td>Скорость, м/с:</td>
				<td>
					<input type="text" name="speed" value="%result%"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="hidden" name="table_calc" value="%table%">
					<input type="hidden" name="id_calc" value="%id%">
					<input type="submit" name="calculate" value="Посчитать" />
				</td>
			</tr>
		</table>
	</form>
</div>
%calcscript%