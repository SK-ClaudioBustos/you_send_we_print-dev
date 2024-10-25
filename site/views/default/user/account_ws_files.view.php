<?php
$permit_images = $wholesaler->get_wholesaler_image();
$certificate_images = $wholesaler->get_certificate_image();
$last = $fiscal_years[sizeof($fiscal_years) - 1];
?>
<div class="ws_files"<?=($wholesaler->get_bill_country() != 44) ? ' style="display: none;"' : ''?>>
	<h4><?=$permit->get_title()?></h4>
	<p><?=html_entity_decode($permit->get_content())?></p>

	<div>
		<?=$tpl->get_view('_input/text', array('field' => 'wholesaler_number', 'label' => 'wholesaler:wholesaler_number',
				'val' => $wholesaler->get_wholesaler_number(), 'width' => 'full', 'class' => 'short',
				'required' => true, 'error' => $wholesaler->is_missing('wholesaler_number'), 'attr' => 'maxlength="24"'))?>
		<?=$tpl->get_view('_input/select', array('field' => 'wholesaler_image', 'label' => 'wholesaler:wholesaler_image', 'val' => $last,
				'required' => false, 'error' => $wholesaler->is_missing('wholesaler_image'), 'width' => 'full', 'class' => 'short',
				'options' => $fiscal_years))?>

		<?php
		foreach($fiscal_years as $year) {
			$file = ($img = $permit_images[$year]) ? '<span>' . $lng->text('wholesaler:uploaded') . '</span>' : $lng->text('wholesaler:no_file');
			?>
			<div class="permit permit_block permit_<?=$year?> clear_fix"<?=($year != $last) ? ' style="display: none;"' : ''?>>
				<label class="file_note"><b><?=$year?></b>: <?=$file?></label>
				<?=$tpl->get_view('_input/file', array('field' => 'wholesaler_image_' . $year, 'label' => 'wholesaler:upload', 'val' => '',
						'required' => false, 'error' => $wholesaler->is_missing($field), 'width' => 'full'))?>
			</div>
			<?php
		}
		?>
	</div>

	<h4><?=$certificate->get_title()?></h4>
	<h5><?=$lng->text('wholesaler:permit')?></h5>
	<p><?=html_entity_decode($certificate->get_content())?></p>

	<div>
		<?=$tpl->get_view('_input/select', array('field' => 'certificate_image', 'label' => 'wholesaler:certificate_image', 'val' => $last,
				'required' => false, 'error' => $wholesaler->is_missing('certificate_image'), 'width' => 'full', 'class' => 'short',
				'options' => $fiscal_years))?>

		<?php
		foreach($fiscal_years as $year) {
			$file = ($img = $certificate_images[$year]) ? '<span>' . $lng->text('wholesaler:uploaded') . '</span>' : $lng->text('wholesaler:no_file');
			?>
			<div class="permit certificate_block certificate_<?=$year?> clear_fix"<?=($year != $last) ? ' style="display: none;"' : ''?>>
				<label class="file_note"><b><?=$year?>:</b> <?=$file?></label>

				<?=$tpl->get_view('_input/file', array('field' => 'certificate_image_' . $year, 'label' => 'wholesaler:upload', 'val' => '',
						'required' => false, 'error' => $wholesaler->is_missing($field), 'width' => 'full'))?>
			</div>
			<?php
		}
		?>
	</div>
</div>