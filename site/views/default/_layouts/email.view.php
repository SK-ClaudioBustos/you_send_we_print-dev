<!DOCTYPE html>
<html lang="en">
<body>
	<div style="width: 600px;">
		<div>
			<img alt="YouSendWePrint.com Logo" src="<?=$cfg->url->root?>/data/email/yswp_email_header.jpg" />
		</div>

		<div style="width: 600px; margin: 20px 0;">
			<?=$body?>
		</div>

		<?=$tpl->get_view('_email/_signature')?>
	</div>
</body>
</html>
