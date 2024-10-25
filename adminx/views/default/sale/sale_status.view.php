<div class="clearfix">
	<div class="col-md-8">
		<table class="table table-hover sale-table">
			<thead>
				<tr>
					<th class="col-md-2"><b><?=$lng->text('sale:cur_status')?></b></th>
					<td class="col-md-6">
						<span class="label label-sm <?=$object->get_status()?>"><?=$lng->text($object->get_status())?></span>

						<?=$this->get_view('sale/sale_actions', array('object' => $object))?>
					</td>
				</tr>
			</thead>
		</table>

		<table class="table table-hover sale-table" id="history">
			<thead>
				<tr class="labels">
					<th class="col-md-2 black"><b><?=$lng->text('sale:status_history')?></b></th>
					<td class="col-md-1 black"><b><?=$lng->text('sale:user')?></b></td>
					<td class="col-md-5 black"><b><?=$lng->text('sale:status')?></b></td>
				</tr>
			</thead>
		</table>
	</div>
</div>
