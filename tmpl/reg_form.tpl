
%message%
<div id="reg">
	<form name="reg" action="%address%reg.php" method="post">
		<table>
			<tr>
				<td>Логин:</td>
				<td>
					<input type="text" name="login" value="%login%"/>
				</td>
			</tr>
			<tr>
				<td>Пароль:</td>
				<td>
					<input type="password" name="password"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<img src="captcha.php" alt="Каптча" />
				</td>
			</tr>
			<tr>
				<td>Проверочный код:</td>
				<td>
					<input type="text" name="captcha" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="submit" name="reg" value="Зарегистрироваться" />
				</td>
			</tr>
		</table>
	</form>
</div>