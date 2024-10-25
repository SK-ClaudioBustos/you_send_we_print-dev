<div id="client_area">
	<div id="enter_container">
		<form action="<?=$app->go()?>" method="post" name="frm" enctype="multipart/form-data">
			<ol>
				<li>
					<label for="username">Usuario</label>
					<input type="text" class="required" name="username" id="username" maxlength="20" value="<?=$username?>" />
				</li>		
				<li>
					<label for="user_password">Contraseña</label>
					<input type="password"  class="required" name="user_password" id="user_password" maxlength="20" />
				</li>
				<li>
					<input name="save" type="submit" id="submit" class="submit_form" value="Enviar" />
					<input name="action" type="hidden" value="login" />
				</li>
			</ol>
		</form>
		<div class="clear_float"></div>
	</div>
</div>