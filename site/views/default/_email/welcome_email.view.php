<view key="subject" value="Account Activated" />

<view key="body">
    <div style="max-width: 600px;">
        <img src="<?= $_SERVER['DOCUMENT_ROOT'] ?>/data/email/PicsForRegistrationEmail_Header_v1a.jpg" alt="" style="display: block; max-width: 100%; margin-bottom: 30px;">

        <h2 style="font: 18px Arial, Helvetica, sans-serif; line-height: 1.5;">Hello <?= $name ?> <?= $lastname ?></h2>

        <p style="font: 16px Arial, Helvetica, sans-serif; line-height: 1">Congratulations!</p>
        <p style="font: 16px Arial, Helvetica, sans-serif; line-height: 1">And many thanks for activating your account at <strong><?= $sitename ?></strong>!</p>
        <p style="font: 16px Arial, Helvetica, sans-serif; font-weight: bold; line-height: 1">Now you can get full access to all our 24/7 E-Commerce Website.</p>
        <p style="font: 16px Arial, Helvetica, sans-serif; font-weight: bold; line-height: 1">Make money with our products!</p>
        <p style="font: 16px Arial, Helvetica, sans-serif; line-height: 1">Place your Order and We do it all…</p>
        <p style="font: 16px Arial, Helvetica, sans-serif; line-height: 1.5"><a href="<?= $url ?>"> <img src="<?= $_SERVER['DOCUMENT_ROOT'] ?>/data/email/StartShopping_Button_v1a.jpg" alt="" style="display: block; max-width: 50%; margin-top:20px"></a></p>
    </div>
</view>