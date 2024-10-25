<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
    <div class="row">
        <div class="col-md-6 col-text">
            <?= $content ?>
        </div>
        <div class="col-md-6">
            <?php if ($img_tiles) { ?>
                <div class="back_about_sep">
                    <?php foreach ($img_tiles as $tile) { ?>
                        <div class="inner_tile">
                            <a href="<?= $tile['link'] ?: "#" ?>">
                                <img src="/data/about/<?= $tile['name'] ?>" alt="">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="back_about">
                    <img src="/data/site/back_about.jpg" alt="" class="img-responsive" width="100%" title="" />
                </div>
            <?php } ?>
        </div>
    </div>
</view>


<view key="page_scripts">
</view>