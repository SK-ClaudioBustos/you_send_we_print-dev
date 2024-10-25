<?php
$breadcrumb = json_decode($breadcrumb, true) ?: [];
?>
<?php if (!isset($breadcrumb['hide'])) { ?>
<ul class="page-breadcrumb hidden-print" vocab="https://schema.org/" typeof="BreadcrumbList">
	<?php if (!isset($breadcrumb['empty'])) { ?>
	<li property="itemListElement" typeof="ListItem">
		<i class="fa fa-home"></i>
        <meta property="position" content="1">
		<a href="<?=$app->go('Home')?>" property="item" typeof="WebPage"><span property="name"><?=$lng->text('home')?></span></a>
		<?php if (sizeof($breadcrumb)) {?>
		<i class="fa fa-angle-right"></i>
		<?php } ?>
	</li>

	<?php if ($app->group) { ?>
    <li property="itemListElement" typeof="ListItem">
        <meta property="position" content="2">
        
        <a href='/all-products' property='item' typeof="WebPage">
        <span property="name">  
        <?=$app->group?></span>
        </a>
        <i class="fa fa-angle-right"></i>
    </li>
	<?php } ?>

	<?php
	if (is_array($breadcrumb)) {
		$i = 0;
		foreach($breadcrumb as $text => $href) {
			$i++
			?>
			<li property="itemListElement" typeof="ListItem">
				<a href="<?=$href?>" property="item" typeof="WebPage"><span property="name"><?=$text?></span></a>
				<?php if ($i != sizeof($breadcrumb)) {?>
				<i class="fa fa-angle-right"></i>
				<?php } ?>
                <meta property="position" content="<?= $i+2; ?>">
			</li>
			<?php
		}
	}
	?>
	<?php } ?>
</ul>
<?php } ?>
