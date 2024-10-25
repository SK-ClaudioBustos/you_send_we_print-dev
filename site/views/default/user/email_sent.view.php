<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?= $lng->text('user_confirm_title') ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
    <div class="row">
        <div class="col-xs-12 clearfix">
            <div id="mail_sent">
                <h2><?= $lng->text('mail:sent:header') ?></h2>
            </div>
            <p>
            <h3 id="mail_sent_1"><?= $lng->text('mail:sent:body1') ?></h3> <span id="mail_sent_2"><?= $lng->text('mail:sent:body2') ?></span></p>
        </div>
    </div>
</view>


<view key="page_scripts">
</view>