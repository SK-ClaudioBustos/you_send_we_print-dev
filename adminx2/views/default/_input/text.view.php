<?php
$required = (!isset($required)) ? false : $required;
$maxlength = (!isset($maxlength)) ? '' : ' maxlength="' . $maxlength . '"';
if (isset($label)) {
	?>
	<label for="<?=$id?>"<?=($required) ? ' class="required' . $object->is_missing($id) . '"' : ''?>><?=$label?></label>
	<?php
}
?>
<input<?=$maxlength?> type="text" name="<?=$id?>" id="<?=$id?>" value="<?=$object->{'get_' . $id}()?>" />
