<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->

<head>
<meta charset="utf-8"/>
	<title><?=(($meta_title) ? $meta_title . ' | ' : '') . $cfg->setting->site?></title>
	<meta name="description" content="<?=$meta_description?>" />
	<meta name="keywords" content="<?=$meta_keywords?>" />

	<?=$tpl->get_view('_elements/metas')?>
	<?=$page_metas?>
</head>

<body class="page-header-fixed page-style-square"<?=($body_id) ? ' id="' . $body_id . '"' : ''?>>

	<?=$tpl->get_view('_elements/header', array('menu' => false, 'user' => false))?>

	<div class="page-container">
		<div class="page-content-wrapper">
			<div class="page-content full">

				<?php if ($subtitle) { ?>
				<h3 class="subtitle"><?=$subtitle?></h3>
				<?php } ?>
				<h3 class="page-title"><?=$title?></h3>

				<div class="content">
					<div class="page-bar">
						<?=$tpl->get_view('_elements/breadcrumb', array('breadcrumb' => $breadcrumb))?>
					</div>

					<?=$body?>
				</div>
			</div>
		</div>
	</div>

	<?=$tpl->get_view('_elements/footer')?>
	<?=$tpl->get_view('_elements/scripts')?>
	<?=$page_scripts?>

</body>
</html>