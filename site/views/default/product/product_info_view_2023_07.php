<?php 
$main = $image_path . '/0/' . sprintf('%06d', $product->get_id());
//echo $main;
//exit;
?>
<div class="product_info">

    <div class="popup_info">
		<a class="close_info">[x]</a>
		<h4></h4>
        <div></div>
    </div>

    <div class="panel-group accordion" id="accordion3">

		<?php // gallery ------------------------------------------------- ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" href="#collapse_3_1">
                        <?=$lng->text('product:gallery')?>
                    </a>
                </h4>
            </div>
            <div id="collapse_3_1" class="panel-collapse in">
                <div class="panel-body">
					<?=$tpl->get_view('product/product_info_gallery', array('gallery' => $gallery))?>
                </div>
            </div>
        </div>

		<?php if (trim($product->get_description()) != "") {// overview ------------------------------------------------- ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" href="#collapse_3_2">
                        <?=$lng->text('product:overview')?>
					</a>
                </h4>
            </div>
            <div id="collapse_3_2" class="panel-collapse in">
                <div class="panel-body">
                    <?=html_entity_decode($product->get_description())?>
                </div>
            </div>
        </div>
        
		<?php } // specs --------------------------------------------------- ?>
 		<div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" href="#collapse_3_3">
                        <?=$lng->text('product:specs')?>
					</a>
                </h4>
            </div>
            <div id="collapse_3_3" class="panel-collapse in">
                <div class="panel-body">
					<?=html_entity_decode($product->get_specs())?>
                </div>
            </div>
        </div>

		<?php // datasheets ---------------------------------------------- ?>
		<?php if ($product->get_details()) { ?>
       <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" href="#collapse_3_4">
                        <?=$lng->text('product:datasheets')?>
					</a>
                </h4>
            </div>
            <div id="collapse_3_4" class="panel-collapse collapse">
                <div class="panel-body">
                    <?=html_entity_decode($product->get_details())?>
                </div>
            </div>
        </div>
		<?php } ?>
        
		<?php // marketing ----------------------------------------------- ?>
		<?php if ($product->get_attachment()) { ?>
		<div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" href="#collapse_3_5">
                        <?=$lng->text('product:marketing')?>
					</a>
                </h4>
            </div>
            <div id="collapse_3_5" class="panel-collapse collapse">
                <div class="panel-body">
					<?=html_entity_decode($product->get_attachment())?>
                </div>
            </div>
        </div>
		<?php } ?>
        
    </div>
</div>

