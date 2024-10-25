<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <ul class="nav nav-tabs">
		<?php
        $i = 0;
        foreach ($categories as $key => $value) {
			?>
			<li<?=($i == 0) ? ' class="active"' : ''?>>
                <a href="#tab_<?=$key?>" data-toggle="tab"><?=$value?></a>
			</li>
			<?php
            $i++;
        }
        ?>
    </ul>

	<div class="tab-content">
		<?php
        $i = 0;
        foreach ($categories as $key => $value) {
			?>
	        <div class="tab-pane<?=($i == 0) ? ' active' : ''?>" id="tab_<?=$key?>">
                <ul class="questions">
					<?php
					$questions = $objects[$key];
					$answers = clone $objects[$key];
					for ($i = 0; $questions->list_paged(); $i++) {
						?>
						<li><a href="#a<?=$questions->get_id()?>"><?=$questions->get_title()?></a></li>
						<?php
						}
					?>
                </ul>

                <div class="answers">
					<?php
					for ($i = 0; $answers->list_paged(); $i++) {
						?>
						<blockquote>
							<h4 id="a<?=$answers->get_id()?>"><?=$answers->get_title()?></h4>
							<div class="text">
								<?=html_entity_decode($answers->get_content())?>
							</div>
						</blockquote>
						<?php
					}
					?>
                </div>
            </div>
			<?php
        }
        ?>
        </div>
</view>


<view key="page_scripts">
</view>

