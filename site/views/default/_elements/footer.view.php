<div class="page-footer2 hidden-print">
	<div class="foot-right-wrapper">
		<div class="foot-right">
		</div>
	</div>
	<div class="foot-content-wrapper">
		<div class="foot-content">
		<div class="row foot-certify">
		            <div class="col-xs-12 col-md-4 col-lg-2">
                        <div class="foot-social">
			    	    <h5 class="uppercase"><?= $lng->text('menu:follow') ?></h5>
				        <a href="<?= $app->social['facebook'] ?>" target="_blank" class="social-facebook"></a>
				        <a href="<?= $app->social['instagram'] ?>" target="_blank" class="social-instagram"></a>
			            </div>
			        </div>
			        <div class="col-lg-10">
			        <div class="col-xs-6 col-md-4 col-lg-2">
						<div class="foot-line1 line1-logo1"></div>
					</div>
					<div class="col-xs-6 col-md-4 col-lg-2">
						<div class="foot-line1 line1-logo2"></div>
					</div>
					<div class="col-xs-6 col-md-4 col-lg-2">
						<div class="foot-line1 line1-logo3"></div>
					</div>
					<div class="col-xs-6 col-md-4 col-lg-2">
						<div class="foot-line1 line1-logo4"></div>
					</div>
					<div class="col-xs-6 col-md-4 col-lg-2">
						<div class="foot-line1 line1-logo5"></div>
					</div>
					<div class="col-xs-6 col-md-4 col-lg-2 last">
						<div class="foot-line1 line1-logo6"></div>
					</div>
					</div>
				</div>
</div>
</div>
<div  class="foot-content-wraper" style='background-color:#f8f8f8'>
<div class="foot-content">
				<div class="row foot-brands">
					<div class="col-xs-12 col-md-4">
						<img src="/data/site/footer/3m_avery_dennison.jpg" alt="Brands" class="img-responsive" />
					</div>
					<div class="col-xs-12 col-md-4">
						<img src="/data/site/footer/orafol_arlon_starflex.jpg" alt="Brands" class="img-responsive" />
					</div>
					<div class="col-xs-12 col-md-4 last">
						<img src="/data/site/footer/ultraboard_ultraflex.jpg" alt="Brands" class="img-responsive" />
					</div>
				</div>
			</a>
			</div>
</div>			
<div class="foot-content-wraper">
    <div class="foot-content">

	<div class="row foot-certify">
		  <div class="col-xs-12 col-md-4 col-lg-2">
                      	<div class="foot-newsletter">
				<form action="<?= $app->go('Contact', false, '/ajax_subscribe') ?>" class="subscribe-box no-block">
					<h5 class="uppercase"><?= $lng->text('menu:newsletter') ?></h5>
					<div class="input-group">
						<input type="hidden" name="action" id="action" value="subscribe" />
						<input type="hidden" name="target" id="target" value="<?= $app->page_full ?>" />
						<input type="text" class="form-control" placeholder="<?= $lng->text('footer:newsletter') ?>" name="subscribe" id="subscribe" maxlength="100" />
						<span class="input-group-btn lemma-btn" title="<?= $lng->text('form:subscribe') ?>">
							<button type="button" class="btn btn-subscribe" name="send"><i class="fa fa-chevron-right"></i></button>
						</span>
					</div>
				</form>
			</div><br>
			<div class="foot-feedback">
				<a href="<?= $app->go('Contact') ?>" class="btn btn-feedback uppercase"><?= $lng->text('footer:feedback') ?>&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
			</div>
			        </div>
			        <div class="col-lg-10">
			            	<div class="col-xs-12">

				    <div class="product-prods">
						<ul class="clearfix">
							<li><a id="foot_home" class="sep" href="<?= $app->go('Home') ?>"><b><?= $lng->text('home') ?></b></a></li>
							<li> | <a class="foot_sitemap" href="<?= $app->go('Home/sitemap') ?>"><?= $lng->text('home:sitemap') ?></a></li>
							<li> | <a class="foot_portfolio" href="<?= $app->go('Portfolio') ?>"><?= $lng->text('menu:portfolio') ?></a></li>
							<?php if ($app->articles->list_count()) { ?>
								<li> | <a class="foot_article" href="<?= $app->go('Article') ?>"><?= $lng->text('menu:news') ?></a></li>
							<?php } ?>
							<li> | <a class="foot_faq" href="<?= $app->go('Faq') ?>"><?= $lng->text('menu:faq') ?></a></li>
							<li> | <a class="foot_artspec" href="<?= $app->go('Artspec') ?>"><?= $lng->text('menu:artspec') ?></a></li>
							<li> | <a class="foot_utilities sep" href="<?= $app->go('Utilities') ?>"><?= $lng->text('menu:utilities') ?></a></li>
							<li> | <a class="foot_about" href="<?= $app->go('Section/about') ?>"><?= $lng->text('menu:about') ?></a></li>
							<li> | <a class="foot_contact" href="<?= $app->go('Contact') ?>"><?= $lng->text('contact') ?></a></li>
							<li> | <a class="foot_privacy sep" href="<?= $app->go('Section/privacy') ?>"><?= $lng->text('menu:privacy') ?></a></li>
							<li> | <a class="foot_cart" href="<?= $app->go('Cart') ?>" title="<?= $lng->text('buy:cart') ?>"><i class="fa fa-shopping-cart"></i> <span><?= $app->cart_items ?></span> <?= $lng->text('buy:items') ?></a></li>
						</ul>
					</div>
			        <div class="col-xs-6 col-md-4 col-lg-2">
		                <img src="/data/site/footer/YSWP_Website_PaymentMethodsPics_Visa.png" alt="Visa" class="img-responsive" />
					</div>
					<div class="col-xs-6 col-md-4 col-lg-2">
                        <img src="/data/site/footer/YSWP_Website_PaymentMethodsPics_AmEx.png" alt="Master"  class="img-responsive" />
					</div>
					<div class="col-xs-6 col-md-4 col-lg-2">
						<img src="/data/site/footer/YSWP_Website_PaymentMethodsPics_Discover.png" alt="Discover" class="img-responsive" />
					</div>
				
					<div class="col-xs-6 col-md-4 col-lg-2">
						<img src="/data/site/footer/YSWP_Website_PaymentMethodsPics_PayPal.png" alt="paypal" class="img-responsive" />
					</div>
					<div class="col-xs-6 col-md-4 col-lg-2">
					    <center>
						<img src="/data/site/footer/YSWP_Website_PaymentMethodsPics_UPS.png" alt="ups" class="img-responsive" />
						</center>
					</div>
						<div class="col-xs-6 col-md-4 col-lg-2">
						<img src="/data/site/footer/YSWP_Website_PaymentMethodsPics_Master.png" alt="Amex" class="img-responsive" />
					</div>
					<div class="col-xs-12">
				<span class="copyright"><?= $lng->text('footer:copyright') ?></span>
				 <span class="sep"></span>
			
				<span class="trademarks"><?= $lng->text('footer:trademarks') ?></span>
			    </div>
					</div>
		</div>	
	</div>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
	
</div>