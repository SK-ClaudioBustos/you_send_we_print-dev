<div class = "main-wrapper">
    <nav class = "navbarmega">
        <div class = "navbarmega-collapse">
          <ul class = "navbarmega-nav">
<?php 
$limite_corte = 10; //para marcar el quiebre entre el nivel 1 y nivel 2 del menu mega
$cant = ""; //contador para iterar

$item_key = explode('/', $app->page_args);
$item_key = $item_key[0];
foreach ($app->menu_groups as $group_key_pp => $group_pp) { 
    $i = 0;
    $cant++;
	$active_mega = false;
	if ($items = $app->menu_items[$group_key_pp]) {
	    //var_dump($items['vinyl-banners']);
		$active_mega = (array_key_exists($item_key, $items));
	}
	if ($item_key == $group_key_pp || array_key_exists($item_key, $group_pp["groups"])) {
		$active_mega = true;
	}
 if ($cant > $limite_corte) continue; //saco de ciclo si es menor a la cantidad de elemntos para el 2do nivel

//print_r($group_pp);
$groups = $app->menu_groups[$group_key_pp]['groups'];
$items_menu = $app->menu_items;
//var_dump($items_menu);
$vl_section = str_replace(array("&",","),"",$group_key_pp);
$count_category++;
$vl_class_revert = "";
    $vl_class_revert = "sub-menumega-reverse".$count_category;
  
    
    
?>
<li id ="<?= $vl_section ?>" class="<?= ($active_mega) ? ' active_mega' : '' ?> category-<?= $count_category ?>">
    <a class = "menumega-link"><?= $group_pp['title'] ?> </a>
  <div class = "sub-menumega <?= $vl_class_revert; ?>">
<?php
	$html_columna0="";
 	$html_columna1=""; 	
 	$html_columna2="";
 	$html_columna3="";
foreach ($groups as $group_key => $title) {
	if (is_numeric($group_key)) {
		continue;
	}
	$active = false;
	$group_home = $app->menu_group_homes[$group_key];
	$group_home_link = "";
	if ($group_home) {
		$group_home_link = "onclick = \"smooth_reload('{$app->go('Product/group', false, '/' . $group_key)}')\""; 
	}
	//var_dump($items);
	if ($items = $app->menu_items[$group_key_pp][$group_key]) {
		$active = (array_key_exists($item_key, $items));
	}
	if ($item_key == $group_key) {
		$active = true;
	}
    $columna = $i%4; //posicion de columna (de 0 a 3) encolumno los elementos
 	$i++; //incremento el contador de columnas / elementos
 
   ?>
<?php ob_start(); //todo lo que viene acontinuaciÃ³n lo meto en una variable $html_columna$columna; ?>
<div class = "sub-menumega-item <?= ($active) ? ' active' : '' ?>" <?php echo $group_home_link ?>>
   		<h4>
			<?= $title ?>
		</h4>
		<ul>
		<?php
			if ($items) {
				foreach ($items as $key => $item) {
					$active = ($item_key && $item_key == $key);
			?>
		    <li>
						<a id="prod_<?= $key ?>" href="<?= $app->go('Product', false, '/' . $key . $intro) ?>">
							<?= $item['title'] ?>
							<?php if ($item['featured']) { ?>
								<span class="badge badge-<?= $item['class'] ?>"><?= $item['featured'] ?></span>
							<?php } ?>
						</a>
			</li>
			<?php
			    }?>
</ul></div>
<?php 
$html_columna = "html_columna".$columna;
$$html_columna .= ob_get_clean(); 
?>	
<?php
}
?>
<?php
} //fin iteracion columnas menu

if ($html_columna0 !="") echo "<div class='column0'>".$html_columna0."</div>";
if ($html_columna1 !="") echo "<div class='column1'>".$html_columna1."</div>";
if ($html_columna2 !="") echo "<div class='column2'>".$html_columna2."</div>";
if ($html_columna3 !="") echo "<div class='column3'>".$html_columna3."</div>"; //por cada menu arrojo las 4 columnas   
$vl_menu_section = "menu_featured".$count_category;
       if (trim($app->$vl_menu_section) != "0"){
       echo '<div class="bloque_destacado"> <h4>Featured Products</h4>';
       foreach ($app->$vl_menu_section as $tag => $value) { ?>
				 	<a class="mid-menu-link" href="/<?= $value[link] ?>" style='overflow:hidden'>
				 	<img src="<?= $value[image] ?>" class="img-responsive" style='max-width:208px' >   
				 	</a>
				 	<a class="mid-menu-link" href="/<?= $value[link] ?>">
					<?= $value[title] ?>
					</a><br>
					<?php } 
	   echo '</div>';	
                  }
		?>
</li>
<?php 
}
?>
          </ul>
        </div>
      </nav>
    </div>
<!-- comienza segunda linea del men¨² mega -->    
<div class = "main-wrapper">
    <nav class = "navbarmega navbarmega2">
        <div class = "navbarmega-collapse">
          <ul class = "navbarmega-nav navbarmega-nav2">
<?php 
$cant = "";
$item_key = explode('/', $app->page_args);
$item_key = $item_key[0];
foreach ($app->menu_groups as $group_key_pp => $group_pp) { 
    $i = 0;
    $cant++;
    $active_mega = false;

   	if ($items = $app->menu_items[$group_key_pp]) {
	    //var_dump($items['vinyl-banners']);
	   // var_dump($items);
		$active_mega = (array_key_exists($item_key, $items));
	}
	if ($item_key == $group_key_pp || array_key_exists($item_key, $group_pp["groups"])) {
	   $active_mega = true;
	}
 if ($cant <= $limite_corte) continue; //saco de ciclo si es menor a la cantidad de elemntos para el 2do nivel
	
//print_r($group_pp);
$groups = $app->menu_groups[$group_key_pp]['groups'];
$items_menu = $app->menu_items;
//var_dump($items_menu);
$vl_section = str_replace(array("&",","),"",$group_key_pp);
$count_category++;
//echo $vl_section;
$vl_class_revert = "";
/*if ($count_category > 2)
    $vl_class_revert = "sub-menumega-reverse1";
if ($count_category > 7)
    $vl_class_revert = "sub-menumega-reverse2";
if ($count_category > 9)
    $vl_class_revert = "sub-menumega-reverse3";
    */
        $vl_class_revert = "sub-menumega-reverse".$count_category;

    
?>
<li id ="<?= $vl_section ?>" class="<?= ($active_mega) ? ' active_mega' : '' ?>">
    <a class = "menumega-link"><?= $group_pp['title'] ?> </a>
  <div class = "sub-menumega <?= $vl_class_revert; ?>">
<?php
	$html_columna0="";
 	$html_columna1=""; 	
 	$html_columna2="";
 	$html_columna3="";
foreach ($groups as $group_key => $title) {
	if (is_numeric($group_key)) {
		continue;
	}
	$active = false;
	$group_home = $app->menu_group_homes[$group_key];
	$group_home_link = "";
	if ($group_home) {
		$group_home_link = "onclick = \"smooth_reload('{$app->go('Product/group', false, '/' . $group_key)}')\""; 
	}
	//var_dump($items);
	if ($items = $app->menu_items[$group_key_pp][$group_key]) {
		$active = (array_key_exists($item_key, $items));
	}
	if ($item_key == $group_key) {
		$active = true;
	}
    $columna = $i%4; //posicion de columna (de 0 a 3) encolumno los elementos
 	$i++; //incremento el contador de columnas / elementos
 
   ?>
<?php ob_start(); //todo lo que viene acontinuaciÃ³n lo meto en una variable $html_columna$columna; ?>
<div class = "sub-menumega-item <?= ($active) ? ' active' : '' ?>" <?php echo $group_home_link ?>>
   		<h4>
			<?= $title ?>
		</h4>
		<ul>
		<?php
			if ($items) {
				foreach ($items as $key => $item) {
					$active = ($item_key && $item_key == $key);
			?>
		    <li>
						<a id="prod_<?= $key ?>" href="<?= $app->go('Product', false, '/' . $key . $intro) ?>">
							<?= $item['title'] ?>
							<?php if ($item['featured']) { ?>
								<span class="badge badge-<?= $item['class'] ?>"><?= $item['featured'] ?></span>
							<?php } ?>
						</a>
			</li>
			<?php
			    }?>
</ul></div>
<?php 
$html_columna = "html_columna".$columna;
$$html_columna .= ob_get_clean(); 
?>	
<?php
}
?>
<?php
} //fin iteraciÃ³n columnas menu

if ($html_columna0 !="") echo "<div class='column0'>".$html_columna0."</div>";
if ($html_columna1 !="") echo "<div class='column1'>".$html_columna1."</div>";
if ($html_columna2 !="") echo "<div class='column2'>".$html_columna2."</div>";
if ($html_columna3 !="") echo "<div class='column3'>".$html_columna3."</div>"; //por cada menu arrojo las 4 columnas   
$vl_menu_section = "menu_featured".$count_category;
        echo '<div class="bloque_destacado">'; 
       if (trim($app->$vl_menu_section) != "0"){
       echo '<h4>Featured Products</h4>';
       foreach ($app->$vl_menu_section as $tag => $value) { ?>
				 	<a class="mid-menu-link" href="/<?= $value[link] ?>" style='overflow:hidden'>
				 	<img src="<?= $value[image] ?>" class="img-responsive" style='max-width:208px' >   
				 	</a>
				 	<a class="mid-menu-link" href="/<?= $value[link] ?>">
					<?= $value[title] ?>
					</a><br>
					<?php } 
                  }
        echo '</div>';          
		?>
</li>
<?php 
}
?>
          </ul>
        </div>
      </nav>
    </div>
