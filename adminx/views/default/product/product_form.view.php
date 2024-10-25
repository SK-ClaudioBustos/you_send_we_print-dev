<div class="form-group">
	<label class="col-sm-3 control-label lbl_form" id="lbl_form">
		<?=$lng->text('product:form')?><span class="required no_visible">*</span>
	</label>

	<div class="col-sm-8">
		<div id="form_container">
			<div class="check_list">
				<ol class="sortable" id="form_list">
					<?php
					//while($items->list_paged()) {
					foreach($product_fields as $product_field) {

						if ($count = $product_field['count']) {
							for($i = 0; $i < $count; $i++) {
								?>
								<li>
									<div class="row">
										<div class="col-sm-4">
											<input type="checkbox" value="<?=$i?>" name="form_<?=$product_field['field']?>[]" id="form_<?=$product_field['field'] . '-' . $i?>"<?=($product_field['options']) ? ' class="check_list"' : ''?> />
											<label for="form_<?=$product_field['field'] . $i?>"><?=$product_field['label'] . ' ' . ($i + 1)?></label>
										</div>

										<?php if ($product_field['options']) { ?>
										<div class="col-sm-8">
											<?=$tpl->get_view('_input/select_control', array(
													'field' => 'form_' . $product_field['field'] . '-' . $i . '_list', 
													'name' => 'form_' . $product_field['field'] . '_list[]', 
													'val' => '',
													'options' => $form_lists[$product_field['options']], 
													'is_assoc' => true,
													'none_val' => '', 
													'none_text' => '',
													'disabled' => true,
												))?>
										</div>
										<?php } ?>
									</div>
								</li>
								<?php
							}
						} else {
							?>
							<li>
								<div class="row">
									<div class="col-sm-4">
										<input type="checkbox" value="1" name="form_<?=$product_field['field']?>" id="form_<?=$product_field['field']?>"<?=($product_field['options']) ? ' class="check_list"' : ''?> />
										<label for="<?=$product_field['field']?>"><?=$product_field['label']?></label>
									</div>

									<?php if ($product_field['options']) { ?>
									<div class="col-sm-8">
									<?=$tpl->get_view('_input/select_control', array(
											'field' => 'form_' . $product_field['field'] . '_list', 
											'name' => 'form_' . $product_field['field'] . '_list' . (($product_field['multiple']) ? '[]' : ''), 
											'val' => '',
											'options' => $form_lists[$product_field['options']], 
											'is_assoc' => true,
											'none_val' => '', 
											'none_text' => '',
											'multiple' => $product_field['multiple'],
											'disabled' => true,
										))?>
									</div>
									<?php } ?>
								</div>
							</li>
							<?php
						}
					}
					?>
				</ol>
			</div>
		</div>
	</div>
</div>

<?php // readonly from parent for subproducts! ?>
<?=$tpl->get_view('_input/textarea', array('field' => 'product_form', 'label' => 'product:form', 'val' => $object->get_form(),
		'required' => true, 'error' => $object->is_missing('form'), 'class' => 'hidden'))?>

