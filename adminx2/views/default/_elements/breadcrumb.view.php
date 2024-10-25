<?php
$out = '';
foreach($breadcrumb as $text => $href) {
	$out .= '<a href="' . $href . '">' . $text . '</a> » ';
}
echo substr($out, 0, -3);
?>
