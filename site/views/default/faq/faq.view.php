<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <ul class="spp_tabs">
		<?php
        $i = 0;
        foreach ($categories as $key => $value) {
			?>
			<li<?=($i == 0) ? ' class="first"' : ''?>>
				<a<?=($i == 0) ? ' class="current"' : ''?> href="#"><?=$value?></a></li>
			<?php
            $i++;
        }
        ?>
    </ul>

    <div class="clear_float"></div>

    <div class="spp_panes">
		<?php
        foreach ($categories as $key => $value) {
			?>
			<div>
				<ul class="questions"><?php
					$questions = $objects[$key];
					$answers = clone $objects[$key];
					for ($i = 0; $questions->list_paged(); $i++) {
					?>
					<li><a href="#a<?=$questions->get_id()?>"><?=$questions->get_title()?></a></li><?php
					}
					?>
				</ul>

				<ul class="answers"><?php
					for ($i = 0; $answers->list_paged(); $i++) {
					?>
					<li>
						<a name="a<?=$answers->get_id()?>"></a>
						<h4><?=$answers->get_title()?></h4>
						<div class="text"><?=html_entity_decode($answers->get_content())?>
						</div>
					</li><?php
					}
					?>
				</ul>
			</div>
			<?php
        }
        ?>
    </div>
</view>


<view key="page_scripts">
    <script type="text/javascript">
		$(function () {
			//$("ul.spp_tabs").tabs("div.spp_panes > div");
		});
    </script>
</view>

