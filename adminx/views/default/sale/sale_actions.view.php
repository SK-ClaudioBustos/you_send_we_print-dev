<div class="btn-group actions">

	<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
	<?=$lng->text('sale:actions')?> <i class="fa fa-angle-down"></i>
	</button>

	<ul class="dropdown-menu" role="menu">
		<?
		foreach($app->actions[$object->get_status()] as $action) {
			if ($action == 'ac_sep') {
				?>
				<li class="divider"></li>
				<?
			} else {
				?>
				<li><a data-field="<?=$action?>" href="javascript:;"><?=$lng->text($action)?></a></li>
				<?
			}
		}
		?>
	</ul>
</div>
