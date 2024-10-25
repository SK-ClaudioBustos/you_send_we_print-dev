<?php
$url = $app->go('Product/fine-art');
?>
<h1><?=$title?></h1>
<div class="compare">
	<table class="features" cellspacing="0">
		<thead>
			<tr>
				<th><h2><?=$lng->text('product:specialty')?></h2></th>
				<td><a href="<?=$url . '/photoacrylic/intro'?>"><span><?=$lng->text('product:photo_acrylic')?></span><img width="99" height="128" alt="" src="/image/product.fine-art.compare/compare.01/" /></a></td>
				<td><a href="<?=$url . '/photoinfoam/intro'?>"><span><?=$lng->text('product:photo_in_foam')?></span><img width="99" height="128" alt="" src="/image/product.fine-art.compare/compare.02/" /></a></td>
				<td><a href="<?=$url . '/photomounted/intro'?>"><span><?=$lng->text('product:photo_mounted')?></span><img width="99" height="128" alt="" src="/image/product.fine-art.compare/compare.03/" /></a></td>
				<td><a href="<?=$url . '/photoincanvas/intro'?>"><span><?=$lng->text('product:photo_in_canvas')?></span><img width="99" height="128" alt="" src="/image/product.fine-art.compare/compare.04/" /></a></td>
			</tr>
		</thead>
		
		<tbody>
			<tr class="row_a">
				<th><?=$lng->text('product:feat:photo')?></th>
				<td class="true"></td>
				<td class="true"></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row_a">
				<th><?=$lng->text('product:feat:high')?></th>
				<td></td>
				<td></td>
				<td class="true"></td>
				<td></td>
			</tr>
			<tr class="row_a">
				<th><?=$lng->text('product:feat:long')?></th>
				<td class="true"></td>
				<td class="true"></td>
				<td class="true"></td>
				<td class="true"></td>
			</tr>
	
			<tr class="row_b">
				<th colspan="5">&nbsp;</th>
			</tr>
	
			<tr class="row_a">
				<th><?=$lng->text('product:feat:ready')?></th>
				<td class="true"></td>
				<td class="true"></td>
				<td class="true"></td>
				<td class="true"></td>
			</tr>
			<tr class="row_a">
				<th><?=$lng->text('product:feat:float')?></th>
				<td class="true"></td>
				<td class="true"></td>
				<td class="true"></td>
				<td></td>
			</tr>
			<tr class="row_a">
				<th><?=$lng->text('product:feat:back')?></th>
				<td class="true"></td>
				<td class="true"></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row_a">
				<th><?=$lng->text('product:feat:option')?></th>
				<td class="true"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
	
			<tr class="row_b">
				<th colspan="5">&nbsp;</th>
			</tr>
	
			<tr class="row_a surface">
				<th><?=$lng->text('product:feat:surface')?></th>
				<td><?=$lng->text('product:feat:gloss')?></td>
				<td><?=$lng->text('product:feat:gloss')?></td>
				<td><?=$lng->text('product:feat:matte')?></td>
				<td><?=$lng->text('product:feat:matte')?></td>
			</tr>
	
			<tr class="row_b">
				<th colspan="5">&nbsp;</th>
			</tr>
	
			<tr class="row_a price">
				<th><?=$lng->text('product:feat:price')?></th>
				<td><span class="star5"></span></td>
				<td><span class="star3"></span></td>
				<td><span class="star2"></span></td>
				<td><span class="star3"></span></td>
			</tr>
	
			<tr class="row_b">
				<th colspan="5">&nbsp;</th>
			</tr>
		</tbody>
	</table>



	<table class="sizes" cellspacing="0">
		<thead>
			<tr>
				<th><?=$lng->text('product:size:sizes')?></th>
				<td colspan="2"><a href="<?=$url . '/photoacrylic/intro'?>"><span><?=$lng->text('product:photo_acrylic')?></span></a></td>
				<td><a href="<?=$url . '/photoinfoam/intro'?>"><span><?=$lng->text('product:photo_in_foam')?></span></a></td>
				<td><a href="<?=$url . '/photomounted/intro'?>"><span><?=$lng->text('product:photo_mounted')?></span></a></td>
				<td><a href="<?=$url . '/photoincanvas/intro'?>"><span><?=$lng->text('product:photo_in_canvas')?></span></a></td>
				<td><b><?=$lng->text('product:size:optional')?></b></td>
			</tr>
			<tr>
				<th style="width: 77px;"></th>
				<td style="width: 96px;"><?=$lng->text('product:size:back')?></td>
				<td style="width: 96px;"><?=$lng->text('product:size:stand')?></td>
				<td style="width: 104px;"><?=$lng->text('product:size:back')?></td>
				<td style="width: 104px;"><?=$lng->text('product:size:foam')?></td>
				<td style="width: 104px;"><?=$lng->text('product:size:strech')?></td>
				<td style="width: 85px;" class="opt"><?=$lng->text('product:size:reinforced')?></td>
			</tr>
		</thead>
		<tbody>
			<tr class="sub">
				<th colspan="7"></th>
			</tr>
			<tr class="row_a">
				<th></th>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row_b">
				<th></th>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row_a">
				<th></th>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
$(function() {
    $('.slideshow').cycle();
});
</script>
