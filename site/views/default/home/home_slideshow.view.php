<div class="col-md-12">
	<div class="rev_slider_wrapper">
		<img src="<?= $slides[0]['image'] ?>" alt="Sky" class="slide-dummy" style="width: 100%;">

		<div id="rev_slider_1" class="rev_slider" data-version="5.4.5">

			<ul>
				<?php foreach ($slides as $slide) { ?>
					<li data-transition="fade">
						<?php if ($slide['link']) { ?>
							<a href="<?= $slide['link'] ?>" target="<?= $slide['target'] ?>">
							<?php } ?>
							<img src="<?= $slide['image'] ?>" alt="Sky" class="rev-slidebg" <?php if ($slide['link']) { ?> style="width:100%;" <?php } ?>>

							<?php if ($slide['text']) { ?>
								<div class="tp-caption tp-resizeme rpp-caption" data-frames='[{"delay":500,"speed":1000,"frame":"0","from":"x:left;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":400,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' data-x="left" data-y="top" data-hoffset="120" data-voffset="100" data-visibility="['on', 'on', 'on', 'off']" data-fontsize="['42', '36', '24', '18']" data-lineheight="['56', '46', '32', '24']">
									<?= $slide['text'] ?>
								</div>
							<?php } ?>
							<?php if ($slide['link']) { ?>
							</a>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>

		</div>
		<div id="rev_slider_m" class="rev_slider" data-version="5.4.5">
			<ul>
				<?php foreach ($slides_mobile as $slide) { ?>
					<li data-transition="fade">
						<?php if ($slide['link']) { ?>
							<a href="<?= $slide['link'] ?>" target="<?= $slide['target'] ?>">
							<?php } ?>
							<img src="<?= $slide['image'] ?>" alt="Sky" class="rev-slidebg" <?php if ($slide['link']) { ?> style="width:100%;" <?php } ?>>

							<?php if ($slide['text']) { ?>
								<div class="tp-caption tp-resizeme rpp-caption" data-frames='[{"delay":500,"speed":1000,"frame":"0","from":"x:left;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":400,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' data-x="left" data-y="top" data-hoffset="120" data-voffset="100" data-visibility="['on', 'on', 'on', 'off']" data-fontsize="['42', '36', '24', '18']" data-lineheight="['56', '46', '32', '24']">
									<?= $slide['text'] ?>
								</div>
							<?php } ?>
							<?php if ($slide['link']) { ?>
							</a>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>

		</div>
	</div>
</div>