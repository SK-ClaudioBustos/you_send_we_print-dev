<div class="form-group<?= (!empty($class)) ? ' ' . $class : '' ?><?= (!empty($disabled)) ? ' disabled' : '' ?><?= (!empty($error)) ? ' has-error' : '' ?>">
    <label class="lbl_<?= $field ?>" for="<?= $field ?>" id="lbl_<?= $field ?>"><?= ($label) ? $lng->text($label) : ' ' ?><?= ($required) ? '<span class="required">*</span>' : '' ?></label>
    <div class="col-sm-<?= (!empty($width)) ? $width : '6' ?>">
        <a href="<?= $url ?>" class="" id="<?= $field ?>"><?= $val ?></a>
    </div>
</div>