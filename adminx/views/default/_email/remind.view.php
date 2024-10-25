<view key="subject" value="Nueva contraseña" />

<view key="body">
	<h2 style="font: 18px Arial, Helvetica, sans-serif;">Hello <?=$username?></h2>

	<p style="font: 12px Arial, Helvetica, sans-serif;">Estás recibiendo esta notificación porque tú (o alguien pretendiendo ser tú) has solicitado
			establecer una nueva contraseña. Por seguridad, la contraseña previa no puede recuperarse.

			Si tú no la solicitaste, por favor ignora esta notificación. Y si se repitiera la solicitud, informa por favor a la administración del sitio.</p>

	<p style="font: 12px Arial, Helvetica, sans-serif;">Para establecer una nueva contraseña, por favor haz clic en el siguiente enlace:</p>

	<p style="font: 12px Arial, Helvetica, sans-serif;"><?=$url?></p>

	<p style="font: 12px Arial, Helvetica, sans-serif;">Este enlace será válido hasta: <?=$limit?>.</p>

	<?=$tpl->get_view('_email/_signature')?>
</view>
