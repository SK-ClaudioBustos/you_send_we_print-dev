<?php
if (!empty($error_msg)) {?>
<div class="alert alert-danger fade in">
	<button data-dismiss="alert" class="close"></button>
	<?=$error_msg?>
</div>
<script>
setTimeout(function() { $('.alert-danger').alert('close'); }, 8000);
</script>
<?php } ?>
