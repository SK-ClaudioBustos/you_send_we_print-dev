<div class="clearfix">

	<div class="col-md-8">
		<?
		if (!$count = $images->list_count()) {
			?>
			<table class="table table-hover sale-table">
				<thead>
					<tr><th class="col-md-2"></th><td class="col-md-6"><?=$lng->text('sale:no_images')?></td></tr>
				</thead>
			</table>
			<?
		} else {
			?>
			<div class="col-md-3 tabs-proof">

				<ul class="nav nav-tabs tabs-left">
					<?
					$nro = 0;
					$image_id = array();
					while($images->list_paged()) {
						$url_folder = '/bgimage/sale/' . sprintf('%08s', $object->get_sale_id());
						$url_thm = $url_folder . '/120x90/' . $images->get_newname();
						$url_img = $url_folder . '/800x600/' . $images->get_newname();
						$nro++;
						$image_id[$nro] = $images->get_id();
						/* <img alt="" src="<?=$url_thm?>" /> */
						?>
						<li<?=($nro == 1) ? ' class="active"' : ''?>>
							<a href="#tab_2_<?=$nro?>" data-toggle="tab">
								<?=$images->get_newname()?>
							</a>
						</li>
						<?
					}
					?>
				</ul>
			</div>

			<div class="col-md-9 tab-content">
				<?
				for ($i = 1; $i <= $nro; $i++) {
					?>
					<div class="tab-pane<?=($i == 1) ? ' active' : ''?>" id="tab_2_<?=$i?>">

						<?=$this->get_view('sale/sale_proofs_new', array('object' => $object, 'proof' => $proof, 'nro' => $i, 'image_id' => $image_id[$i]))?>
						<?=$this->get_view('sale/sale_proofs_history', array('object' => $object, 'proofs' => $proofs, 'image_id' => $image_id[$i], 'nro' => $i))?>

					</div>
					<?
				}
				?>
			</div>

			<?
		}
		?>
	</div>

</div>
