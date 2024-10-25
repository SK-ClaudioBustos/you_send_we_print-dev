<view key="body">
    <p><b><?= $lng->text('email:name') ?>:</b> <?= $name ?></p>

    <p><b><?= $lng->text('email:email') ?>:</b> <?= $email ?></p>

    <p><b><?= $lng->text('email:comment') ?>:</b> <?= $comment ?></p>

    <?= $tpl->get_view('_email/_signature') ?>
</view>