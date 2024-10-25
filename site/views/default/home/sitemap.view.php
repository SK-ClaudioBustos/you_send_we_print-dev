<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
    <div class="foot-content-wrapper sm-wp">
        <div class="sitemap-container">
            <div class="row">
                <div class="col-xs-12">
                    <?php foreach ($app->menu_groups as $group_key => $group) { ?>
                        <div class="product-title">
                            <h3 class="uppercase sm-h3"><?= $group['title'] ?></h3>
                        </div>
                        <?= $tpl->get_view('_elements/footer_products', array('group' => $group_key)) //, 'intro' => '/intro'))
                        ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</view>

<view key="page_scripts">
</view>