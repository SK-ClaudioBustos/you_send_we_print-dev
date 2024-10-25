<?php if ($app->username) { ?>
  <li class="menu_cart hidden-xs"><a href="<?= $app->go('Cart') ?>" title="<?= $lng->text('buy:cart') ?>"><i class="fa fa-shopping-cart"></i> <span><?= $app->cart_items ?></span> <?= $lng->text('buy:items') ?> &nbsp; &nbsp; | </a></li>  
  <li class="dropdown dropdown-user">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <!--<img alt="" class="img-circle hide1" src="/data/site/avatar3_small.jpg"/>-->
            <span class="username"><b><?= $app->username ?></b></span> <i class="fa fa-angle-down"></i>
        </a>

        <ul class="dropdown-menu">
            <?php if ($app->wholesaler->get_status() == 'ws_approved') { ?>
                <li><a href="<?= $app->go('User/account') ?>"><i class="fa fa-user"></i> <?= $lng->text('menu:user') ?></a></li>
                <?php if ($app->wholesaler->get_id()) { ?>
                    <li><a href="<?= $app->go('User/account', false, '/wholesaler') ?>"><i class="fa fa-bookmark-o"></i> <?= $lng->text('menu:ws_go') ?></a></li>
                    <?php if ($app->wholesaler->get_status() == 'ws_approved') { ?>
                        <li><a href="<?= $app->go('User/account', false, '/orders') ?>"><i class="fa fa-file-o"></i> <?= $lng->text('menu:orders') ?></a></li>
                        <li><a href="<?= $app->go('User/account', false, '/addresses') ?>"><i class="fa fa-map-o"></i> <?= $lng->text('menu:addresses') ?></a></li>
                    <?php } ?>
                <?php } ?>
                <?php if ($app->user_admin) { ?>
                    <li class="divider"></li>
                    <li><a href="<?= $cfg->url->root ?>/adminx"><i class="fa fa-cogs"></i> <?= $lng->text('menu:backoffice') ?></a></li>
                <?php } ?>
                <li class="divider"></li>
            <?php } ?>
            <li><a href="<?= $app->page_full . '/logout' ?>"><i class="icon-key"></i> <?= $lng->text('menu:logout') ?></a></li>
        </ul>
    </li>

<?php } else if (!in_array($app->page_key, array('Session/login', 'Session/confirm', 'Session/reset'))) { ?>
    <li class="menu_cart hidden-xs"><a href="<?= $app->go('Cart') ?>" title="<?= $lng->text('buy:cart') ?>"><i class="fa fa-shopping-cart"></i> <span><?= $app->cart_items ?></span> <?= $lng->text('buy:items') ?> &nbsp; &nbsp; | </a></li>
    
    <li class="dropdown dropdown-user dropdown-login">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <span class="username"><b><?= $lng->text('menu:register') ?></b></span> <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-checkboxes hold-on-click">
            <li>
                <div class="login-login clearfix">
                    <h4><?= $lng->text('login:login_title') ?></h4>
                    <form class="form-vertical login-form" action="<?= $app->go('Session/login') ?>" method="post">
                        <?php if ($alert) { ?>
                            <div class="alert alert-<?= $alert ?> alert-fail">
                                <button class="close" data-dismiss="alert"></button>
                                <span><?= $msg ?></span>
                            </div>
                        <?php } ?>
                        <?php if (!$offline) { ?>
                            <div class="form-group">
                                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                <div class="input-icon">
                                    <i class="fa fa-user"></i>
                                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="<?= $lng->text('login:username') ?>" name="username" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="fa fa-lock"></i>
                                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="<?= $lng->text('login:password') ?>" name="password" />
                                </div>
                            </div>

                            <?php if ($publickey) { ?>
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="g-recaptcha" data-size="compact" data-sitekey="<?= $publickey ?>"></div>
                                        <input type="hidden" name="recaptcha_field" value="1" />
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-actions">
                                <label class="checkbox pull-left"><input type="checkbox" name="remember" value="1" />
                                    <?= $lng->text('login:remember') ?></label>
                                <?= $tpl->get_view('_elements/token', array('token' => $login_token)) ?>
                                <input type="hidden" name="action" value="login" />
                                <input type="hidden" name="target" value="<?= $app->go() ?>" />
                                <button type="submit" class="btn yswp-red btn-outline pull-right"><?= $lng->text('login:login') ?> <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                            <a href="<?= $app->go('Session/login') ?>" class="forgot-password pull-left"><?= $lng->text('login:lost_pw') ?></a>
                        <?php } ?>
                    </form>
                </div>

                <div class="login-register">
                    <h4><?= $lng->text('login:register_title') ?></h4>
                    <div class="clearfix"><?= $app->register_text ?>
                    </div>
                    <div class="register-buttons clearfix">
                        <a class="btn yswp-red btn-outline pull-right" href="<?= $app->go('User/register') ?>"><?= $lng->text('login:retail') ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </li>
        </ul>
    </li>
<?php } ?>