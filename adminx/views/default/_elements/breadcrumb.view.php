<?php
$breadcrumb = json_decode($breadcrumb, true);
?>
<?php if (!isset($breadcrumb['hide'])) { ?>
<ul class="page-breadcrumb hidden-print">
	<?php if (!isset($breadcrumb['empty'])) { ?>
	<li>
		<i class="fa fa-home"></i>
		<a href="<?=$app->go('Home')?>"><?=$lng->text('home')?></a>
		<?php if (sizeof($breadcrumb)) {?>
		<i class="fa fa-angle-right"></i>
		<?php } ?>
	</li>
	<?php
	if (is_array($breadcrumb)) {
		$i = 0;
		foreach($breadcrumb as $text => $href) {
			$i++
			?>
			<li>
				<a href="<?=$href?>"><?=$text?></a>
				<?php if ($i != sizeof($breadcrumb)) {?>
				<i class="fa fa-angle-right"></i>
				<?php } ?>
			</li>
			<?php
		}
	}
	?>
	<?php } ?>
</ul>
<?php } ?>
