<div class="clearfix">
	<div class="col-md-8">
		<table class="table table-hover sale-table">
			<thead>
				<tr>
					<th class="col-xs-2"><?=$lng->text('sale:tab:raw')?></th>
					<td class="col-xs-6">
						<form class="form form-horizontal" action="<?=$app->go()?>">
							<textarea readonly="readonly" cols="50" rows="5" class="form-control" style="height: 720px;"><?=$object->get_detail()?></textarea>
						</form>
					</td>
				</tr>
			</thead>
		</table>

	</div>
</div>
