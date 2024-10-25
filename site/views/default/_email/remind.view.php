<view key="subject" value="Password reset" />

<view key="body">
	<div style="max-width: 600px;">
		<img src="<?= $_SERVER['DOCUMENT_ROOT'] ?>/data/email/PicsForRegistrationEmail_Header_v1a.jpg" alt="" style="display: block; max-width: 100%; margin-bottom: 30px;">

		<h2 style="font: 18px Arial, Helvetica, sans-serif;">Hello <?= $username ?></h2>

		<p style="font: 14px Arial, Helvetica, sans-serif;">You are receiving this notification because you have (or someone pretending to be you) has requested
			a password reset for your account on "<?= $sitename ?>". If you did not request it then please ignore this notification, if you keep receiving it
			please contact the site administrator.</p>
		<p style="font: 14px Arial, Helvetica, sans-serif;">To set a new password please click the link provided below.</p>
		<p style="font: 14px Arial, Helvetica, sans-serif;"><a href="<?= $url ?>"><?= $url ?></a></p>
		<p style="font: 14px Arial, Helvetica, sans-serif;">This link will be valid until <?= $limit ?></p>
	</div>
</view>