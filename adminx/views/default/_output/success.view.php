<?php if (!empty($success_msg)) {?>
<div class="alert alert-success fade in">
	<button data-dismiss="alert" class="close"></button>
	<?=$success_msg?>
</div>
<script>
setTimeout(function() { $('.alert-success').alert('close'); }, 8000);
</script>
<?php } ?>
