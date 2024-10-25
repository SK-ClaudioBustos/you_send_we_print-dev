<div class="col-lg-3 col-md-6">
	<?=$tpl->get_view('home/home_tile', array(
			'id' => 'cp_total', 'color' => 'blue-madison', 'icon' => 'fa-calendar', 'dest' => '0', 'descr' => $lng->text('report:planned')))?>
</div>
<div class="col-lg-3 col-md-6">
	<?=$tpl->get_view('home/home_tile', array(
			'id' => 'cp_done', 'color' => 'green-haze', 'icon' => 'fa-check-square-o', 'dest' => '0', 'descr' => $lng->text('report:done') . " (<span>0</span>%)"))?>
</div>
<div class="col-lg-3 col-md-6">
	<?=$tpl->get_view('home/home_tile', array(
			'id' => 'cp_cancelled', 'color' => 'red-intense', 'icon' => 'fa-times-circle', 'dest' => '0', 'descr' => $lng->text('report:cancelled') . " (<span>0</span>%)"))?>
</div>
<div class="col-lg-3 col-md-6">
	<?=$tpl->get_view('home/home_tile', array(
			'id' => 'cp_due', 'color' => 'yellow-crusta', 'icon' => 'fa-question-circle', 'dest' => '0', 'descr' => $lng->text('report:due') . " (<span>0</span>%)"))?>
</div>
