<?php
if (!empty($error_msg)) {?>
<div class="alert alert-danger fade in">
	<button data-dismiss="alert" class="close"></button>
	<?php 
	if (is_array($error_msg)) {
		$error_msg = implode('<br />', $error_msg);
	}
	echo $error_msg;
	?>
</div>
<script>
//setTimeout(function() { $('.alert-danger').alert('close'); }, 8000);
</script>
<?php } ?>
