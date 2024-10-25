<div class="col-md-12">

	<div class="rev_slider_wrapper">
		<!-- <div id="rev_slider_1" class="rev_slider" data-version="5.4.5"> -->

			<!-- <ul> -->
				<?php foreach ($slides as $slide) { ?>
					<!-- <li data-transition="fade">		 -->			
						<a href="<?= $group_url ?: '#' ?>" class="group_slider <?= $group_url == "" ? 'no-pointer' : "" ?>">
							<img src="<?= $slide ?>" alt="Sky" class="rev-slidebg">						
						</a>
					<!-- </li> -->
				<?php } ?>
			<!-- </ul> -->

		<!-- </div> -->
	</div>
</div>