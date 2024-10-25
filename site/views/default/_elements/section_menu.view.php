<li class="menu_home"><a href="<?= $app->go('Home') ?>"><?= $lng->text('home') ?></a></li>

<li class="menu_portfolio"><a href="<?= $app->go('Portfolio') ?>"><?= $lng->text('menu:portfolio') ?></a></li>

<?php if ($app->articles->list_count()) { ?>
    <li class="menu_article"><a href="<?= $app->go('Article') ?>"><?= $lng->text('menu:news') ?></a></li>
<?php } ?>

<li class="menu_faq"><a href="<?= $app->go('Faq') ?>"><?= $lng->text('menu:faq') ?></a></li>
<li class="menu_artspec"><a href="<?= $app->go('Artspec') ?>"><?= $lng->text('menu:artspec') ?></a></li>
<li class="menu_utilities"><a href="<?= $app->go('Utilities') ?>"><?= $lng->text('menu:utilities') ?></a></li>
<li class="menu_about"><a href="<?= $app->go('Section/about') ?>"><?= $lng->text('menu:about') ?></a></li>
<li class="menu_contact"><a href="<?= $app->go('Contact') ?>"><?= $lng->text('contact') ?></a></li>
