<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title><?= $meta_title ?></title>
	<meta name="description" content="<?php $meta_description ?> <?= (($meta_title) ? $meta_title . ' | ' : '') . $cfg->setting->site ?> We are a highly experienced Trade Only Large Format Printer with a broad. Printing technologies with our experience in order to give you the best graphic" />
	<meta name="keywords" content="<?= $meta_keywords ?> <?= (($meta_title) ? $meta_title . ' | ' : '') . $cfg->setting->site ?> printing,provider,printer,print,specialty,expertise,photo,products,format,displays,yousendweprint, wholesale, large format printer, board, graphic" />
<?php     	$fullurl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); ?>
    <link rel="canonical" href="<?= $fullurl?>" />
	<?= $tpl->get_view('_elements/metas') ?>
	<?= $page_metas ?>
</head>
<body class="page-header-fixed page-quick-sidebar-open <?= $cfg->setting->language . (($body_class) ? ' ' . $body_class : '') ?>" <?= ($body_id) ? ' id="' . $body_id . '"' : '' ?>>
	<div class="page-bar page-bar-top hidden-xs search-container">
				<center><?= $tpl->get_view('_input/search_gral') ?></center>
		</div>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6X8NFR" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<?= $tpl->get_view('_elements/header') ?>

	<div class="page-container">
		<?= $tpl->get_view('_elements/sidebar') ?>

		<div class="page-content-wrapper">
			<div class="page-content">

			
				<div class="page-bar page-bar-top hidden-xs">
					<?= $tpl->get_view('_elements/header_steps', array('step' => $step, 'how_to_text' => $how_to_text)) ?>
				</div>


				<?php if ($app->warning) { ?>
					<div class="warning">
						<?= $app->warning ?>
					</div>
				<?php } ?>
				<?php if ($app->warning2) { ?>
					<div class="warning2">
						<?= $app->warning2 ?>
					</div>
				<?php } ?>

				<div class="content">
					<div class="row">
						<div class="col-sm-12">
							<?= $tpl->get_view('_output/success', array('success_msg' => $success_msg)) ?>
							<?= $tpl->get_view('_output/error', array('error_msg' => $error_msg)) ?>
						</div>
					</div>

					<?= $body ?>
				</div>
			</div>

		</div>

		<div class="page-quick-sidebar-wrapper hidden-print">
			<div class="page-quick-sidebar">
				<?= $tpl->get_view('_elements/ad_right') ?>
			</div>
		</div>
	</div>

	<?= $tpl->get_view('_elements/footer') ?>
	<?= $tpl->get_view('_elements/scripts') ?>
	<?= $tpl->get_view('_elements/stats'); ?>

	<?= $page_scripts ?>

</body>

</html>