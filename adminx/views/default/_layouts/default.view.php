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

<body class="page-header-fixed page-quick-sidebar-over-content page-style-square"<?=($body_id) ? ' id="' . $body_id . '"' : ''?>>

	<?=$tpl->get_view('_elements/header')?>

	<div class="page-container">
		<?=$tpl->get_view('_elements/sidebar')?>

		<div class="page-content-wrapper">
			<div class="page-content clearfix">

				<?php if ($subtitle) { ?>
				<h3 class="subtitle"><?=$subtitle?></h3>
				<?php } ?>
				<h3 class="page-title"><?=$title?></h3>

				<div class="content">
					<div class="page-bar">
						<?=$tpl->get_view('_elements/breadcrumb', array('breadcrumb' => $breadcrumb))?>
						<?=$page_toolbar?>
					</div>

					<div class="row">
						<div class="col-md-12">
							<?=$tpl->get_view('_output/success', array('success_msg' => $success_msg))?>
							<?=$tpl->get_view('_output/error', array('error_msg' => $error_msg))?>
						</div>
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