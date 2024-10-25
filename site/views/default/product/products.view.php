<?php
$extra_size = false;
?>

<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
    <?php if (isset($slides) && $slides != false) { ?>
        <div class="row slideshow">
            <?= isset($slides) ? $tpl->get_view('product/product_slideshow', array('slides' => $slides, 'group_url' => $group_url)) : "" ?>
        </div>
    <?php } ?>


    <div class="row product_sel" <?php if (isset($slides) && $slides != false) echo "style='margin-top:40px;'" ?>>

        <?php
        if (!isset($group)) {
            while ($children->list_children()) {
                if (strlen($children->get_title()) > 72) {
                    $extra_size = true;
                }
                $url = $app->go($app->module_key, false, '/' . $object->get_product_key() . '/' . $children->get_product_key());
        ?>
                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 group_div">
                    <a class="image" href="<?= $url ?>">
                        <img alt="" class="img-responsive" loading="lazy" src="/image/product/<?= sprintf('%06d', $object->get_id()) . '/0/' . sprintf('%06d', $children->get_id()) ?>.00.jpg">
                    </a>
                    <h2><a class="extra_size" href="<?= $url ?>"><?= $children->get_title() ?> <?= ($children->get_use_stock() && !$children->get_stock() ? '<span class="no_stock">' . $lng->text('product:no_stock') . '</span>' : '') ?></a></h2>
                    <span class="from">
                        <?php
                        if ($children->get_price_from() > 0) {
                            if ($app->user_id) {
                                echo $lng->text('product:price_from', number_format($children->get_price_from() >= '29.90' ? $children->get_price_from() : '29.90', 2));
                            }
                        } else {
                            echo '&nbsp;';
                        }
                        ?>
                    </span>
                    <!-- <div><?= /*html_entity_decode($children->get_short_description()) */ "" ?></div> -->
                </div>
            <?php
            }
        } else { ?>

            <?php
            //$count = 1;
            while ($children->list_paged()) {
                if ($children->get_active() != 1)
                    continue;

                if (strlen($children->get_title()) > 72) {
                    $extra_size = true;
                }

                $url = $app->go($app->module_key, false, '/' .  $children->get_product_key());
            ?>
                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 group_div">
                    <a class="image" href="<?= $url ?>">
                        <img alt="" class="img-responsive" loading="lazy" src="/data/subhome/<?php

                                                                                $tmp = strtolower($object->get_title());
                                                                                $tmp = str_replace(" ", "_", $tmp);
                                                                                $tmp_name = strtolower($children->get_title());
                                                                                $tmp_name1 = str_replace(" ", "_", $tmp_name);
                                                                                $tmp_name2 = str_replace(" ", "-", $tmp_name);
                                                                                $url_img1 = html_entity_decode($tmp . '/subpromos/' . $tmp_name1, ENT_NOQUOTES, 'UTF-8');
                                                                                $url_img2 = html_entity_decode($tmp . '/subpromos/' . $tmp_name2, ENT_NOQUOTES, 'UTF-8');
                                                                                //$count++;
                                                                                $webp = file_exists($_SERVER['DOCUMENT_ROOT'] . '/data/subhome/' . $url_img1 . '.webp');
                                                                                $webp_1 = file_exists($_SERVER['DOCUMENT_ROOT'] . '/data/subhome/' . $url_img2 . '.webp');
                                                                                $webp2 = file_exists($_SERVER['DOCUMENT_ROOT'] . '/data/subhome/' . html_entity_decode($url_img1) . '.webp');
                                                                                $webp2_1 = file_exists($_SERVER['DOCUMENT_ROOT'] . '/data/subhome/' . html_entity_decode($url_img2) . '.webp');
                                                                                $url_img1 .= ($webp || $webp2) ? '.webp' : '.jpg';
                                                                                $url_img2 .= ($webp_1 || $webp2_1) ? '.webp' : '.jpg';



                                                                                $url_img = file_exists($_SERVER['DOCUMENT_ROOT'] . '/data/subhome/' . html_entity_decode($url_img1)) ? $url_img1 : $url_img2;

                                                                                echo $url_img; ?>">
                    </a>
                    <h2><a class="divh2a extra_size" style="font-weight: 500; display: contents;" href="<?= $url ?>">
                            <span class="span_title">
                                <?= $children->get_title() ?>
                            </span>
                        </a></h2>
                    <span class="from">
                        <?php
                        if ($children->get_price_from() > 0) {
                            echo $lng->text('product:price_from', number_format($children->get_price_from(), 2));
                        } else {
                            echo '&nbsp;';
                        }
                        ?>
                    </span>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <?php
    if ($extra_size == true) {
    ?>
        <style>
            .extra_size {
                min-height: 100px !important;
            }
        </style>
    <?php } ?>
</view>


<view key="page_scripts">
    <script>
        //init_home(<?= /*$slide_speed*/ '' ?>);
        init_products();
    </script>
</view>