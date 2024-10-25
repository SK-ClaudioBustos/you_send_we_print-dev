<div class="control-group">
	<label class="control-label" for="<?=$field?>"><?=$lng->text($label)?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="controls">
		<input type="text" class="span6 m-wrap" autocomplete="off" name="<?=$field?>" id="<?=$field?>" value="<?=$text?>" data-url="<?=$url?>" />
		<p class="help-block">Ingrese los primeros caracteres para buscar</p>
		<input type="hidden" name="<?=$field?>_id" id="<?=$field?>_id" value="<?=$val?>">
	</div>
</div>


<script>
	$(function() {
		$('#city').typeahead({
				source: function (query, process) {
					var $this = this;							// get a reference to the typeahead object
//console.log($(this).attr('data-url'));
					return $.get($('#city').attr('data-url') + '?query=' + query, function(data){
						var options = [];
						$this["map"] = {}; 						//replace any existing map attr with an empty object
						$.each(data,function(i, val) {
						options.push(val.txt);
						$this.map[val.txt] = val.id; 			//keep reference from txt -> id
					});
					return process(options);
				});
			},
			updater: function (item) {
				console.log(this.map[item], item); 				//access it here
				return item;
			}
		});
	});
</script>