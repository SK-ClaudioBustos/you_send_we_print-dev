<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?=(($meta_title) ? $meta_title . ' | ' : '') . $cfg->setting->site?></title>
	<?=$tpl->get_view('_elements/metas');?>
</head>

<body<?=(isset($body_id)) ? ' id="' . $body_id . '"' : ''?>>

	<div class="back_header">
		<?=$tpl->get_view('_elements/header');?>
	</div>

	<div class="body">
		<div class="sidebar">
			<?=$tpl->get_view('_elements/sidebar');?>
		</div>
		<div class="content">
			<?=$body?>
		</div>
		<div class="clear_float"></div>
	</div>

	<div class="back_footer">
		<?=$tpl->get_view('_elements/footer');?>
	</div>

	<script type="text/javascript">
		success_msg = '<?=(isset($success_msg)) ? $success_msg : ''?>';
		error_msg = '<?=(isset($error_msg)) ? $error_msg : ''?>';
	</script>
</body>

</html>
