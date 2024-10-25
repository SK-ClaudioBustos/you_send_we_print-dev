<ul class="page-breadcrumb">
    <li class="buy_label"><?=$lng->text('buy:label')?></li>
    <li class="buy_step" id="step_1"><span class="badge badge-default">1</span> <span><?=$lng->text('buy:select')?></span></li>
    <li class="buy_step" id="step_2"><span class="badge badge-default">2</span> <span><?=$lng->text('buy:checkout')?></span></li>
    <li class="buy_step" id="step_3"><span class="badge badge-default">3</span> <span><?=$lng->text('buy:upload')?></span></li>
    <li class="buy_step">
        <a class="how_to_title" href="#"><?=$lng->text('form:more')?></a>
	</li>
	<li>
		<div class="how_to_text">
			<?=$app->how_to_text?>
		</div>
	</li>
</ul>
