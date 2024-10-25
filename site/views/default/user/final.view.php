<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
    <div class="row">
        <div class="col-sm-6 clearfix">
            <div id='mail_confirmed' style="width:205%;text-align:left;padding-left:10px;">
                <h2><?= $header ?></h2>
            </div>
            <h4 style="font-size:20px !important"><?= $subheader1 ?></h4>
            <h4 style="font-size:20px !important"><?= $subheader2 ?></h4>

            <div class=" form-group group-buttons clearfix">
                <a href="<?= $app->go('Home') ?>" class="pull-left" style="margin-right:18px">
                    <button type="button" class="btn yswp-red btn-outline pull-right">
                        <?= $lng->text('form:shop') ?> <i class="fa fa-home"></i>
                    </button>
                </a>

            </div>
        </div>

    </div>
</view>

<view key="page_scripts">
</view>