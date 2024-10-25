<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<title><?= (($meta_title) ? $meta_title . ' | ' : '') . $cfg->setting->site ?></title>
	<meta name="description" content="<?= $meta_description ?>" />
	<meta name="keywords" content="<?= $meta_keywords ?>" />
	
	<?= $tpl->get_view('_elements/metas') ?>
</head>

<body class="login">

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6X8NFR" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div class="logo">
		<img src="/data/site/site_logo_200.png" width="280" alt="" class="img-responsive" />
	</div>

	<div class="content">
		<?= $body ?>
	</div>

	<div class="copyright">
		&copy;<?= date('Y') ?> Grupo NetV
	</div>

	<?= $tpl->get_view('_elements/scripts') ?>
	<?= $page_scripts ?>

</body>

</html>