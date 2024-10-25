<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?= $lng->text('user_confirm_title') ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
    <div class="row">
        <div class="col-xs-12 clearfix">
            <h2><?= $lng->text('user:welcome') ?></h2>
            <p><?= $object->get_username() ?> <?= $lng->text('user:activated') ?></p>
        </div>
    </div>
</view>


<view key="page_scripts">
</view>