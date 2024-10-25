<div class="form-group">
    <div class="radio-list clearfix">
        <label class="col-xs-4"><?=$lng->text('product:sides')?></label>

		<div class="col-xs-4 col-sm-3">
			<label>
				<input type="radio" name="sides" id="single" class="sides" value="1" <?=($object->get_sides() < 2) ? ' checked="checked"' : ''?> />
				<?=$lng->text('product:single')?>
			</label>
		</div>
        
		<div class="col-xs-4 col-sm-5">
			<label>
				<input type="radio" name="sides" id="double" class="sides" value="2" <?=($object->get_sides() == 2) ? ' checked="checked"' : ''?> />
				<?=$lng->text('product:double')?>
			</label>
		</div>

		<label class="col-sm-offset-4 col-xs-8" id="double_side">
			<em><?=$lng->text('product:double_side')?></em>
		</label>
		<div class="col-xs-12"><div class="sep-bottom"></div></div>
    </div>
</div>
