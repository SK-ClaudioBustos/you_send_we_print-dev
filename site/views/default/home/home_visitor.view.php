<div class="col-md-12">
	<div class="info_top">
		<div>
			<div class="row">
				<div class="col-sm-9">
					<h2><?=$info['title']?></h2>
					<h3><?=$info['subtitle']?></h3>
					<div class="row">
						<div class="col-sm-6">
							<ul>
								<?php foreach($info['col1'] as $item) { ?>
								<li><?=$item?></li>
								<?php } ?>
							</ul>
						</div>
						<div class="col-sm-6">
							<ul>
								<?php foreach($info['col2'] as $item) { ?>
								<li><?=$item?></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<form class="form-vertical signup-form no-block" action="<?=$app->go('User/register')?>" method="post">
						<div class="form-group">
							<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
							<div class="input-icon">
								<i class="fa fa-user"></i>
								<input class="form-control placeholder-no-fix" type="text" maxlength="60" placeholder="<?=$lng->text('form:name')?>" name="first_name" id="signup_name" />
							</div>
						</div>

						<div class="form-group">
							<div class="input-icon">
								<i class="fa fa-envelope"></i>
								<input class="form-control placeholder-no-fix" type="text" maxlength="100" placeholder="<?=$lng->text('form:email')?>" name="email" id="signup_email" />
							</div>
						</div>

						<div class="form-actions">
							<label class="checkbox pull-left">
								<input type="checkbox" name="newsletter" value="1" /> 
								<?=$lng->text('form:newsletter')?>
							</label>
							<input type="hidden" name="action" value="signup" />
							<button type="submit" class="btn default btn-green btn-register"><?=$lng->text('form:register')?> <i class="fa fa-chevron-right"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

