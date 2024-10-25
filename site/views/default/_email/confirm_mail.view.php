<view key="subject" value="Confirm Your Email" />

<view key="body">
    <div style="max-width: 600px;">
        <img src="<?= $_SERVER['DOCUMENT_ROOT'] ?>/data/email/PicsForRegistrationEmail_Header_v1a.jpg" alt="" style="display: block; max-width: 100%; margin-bottom: 30px;">

        <h2 style="font: 18px Arial, Helvetica, sans-serif; line-height: 1.5;">Hello <?= $name ?> <?= $lastname ?></h2>

        <p style="font: 16px Arial, Helvetica, sans-serif; line-height: 1.5">Thanks for beginning your registration at <strong><?= $sitename ?></strong>!</p>
        <p style="font: 16px Arial, Helvetica, sans-serif; font-weight: bold; line-height: 1.5">Please click on the button below to confirm your email with us and get full access to our e-commerce website: </p>
        <p style="font: 16px Arial, Helvetica, sans-serif; line-height: 1.5"><a href="<?= $url ?>"> <img src="<?= $_SERVER['DOCUMENT_ROOT'] ?>/data/email/ConfirmYourEmail_Button_02_v1a.jpg" alt="" style="display: block; max-width: 50%; margin-top:20px"></a></p>
    </div>
</view>