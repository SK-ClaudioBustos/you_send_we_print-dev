<script src="<?= $tpl->get_lang() ?>?2023-6-13"></script>
<script src="<?= $tpl->get_lang($app->module_key) ?>?2023-6-13"></script>

<script src="<?= $tpl->get_script() ?>?2023-6-13"></script>
<script src="<?= $tpl->get_script($app->module_key) ?>?2023-6-13"></script>

<?php if (!$app->user_id) { ?>
    <script>
        Login.init();
    </script>
<?php } ?>

<script>
    let product_list = '<?= $app->go('Product', false, '/ajax_list') ?>';
    let product_search = '<?= $app->go('Product', false, '/ajax_search') ?>';
</script>