<div class="<?= $css_uniq_classes['form_root'] ?>"
     style="width: <?= $width ?>; height: <?= $height ?>;">

    <div class="<?= $css_uniq_classes['app'] ?>">
        <div class="<?= $css_uniq_classes['wrapper-form'] ?>">

            <?php if (!$hide_price): ?>

                <p class="<?= $css_uniq_classes['old_price'] ?>" style="text-decoration: line-through; font-size: 3.7em;">
                    <?= $oldPriceHtml ?>
                </p>

                <p class="<?= $css_uniq_classes['new_price'] ?>" style="padding-bottom: 20px; font-size: 4rem">
                    <?= $newPriceHtml ?> <?= $currencyDisplayHtml ?>
                </p>

            <?php endif ?>

            <form action="" method="post" class="<?= $css_uniq_classes['order_form'] ?>" autocomplete="on">

                <fieldset class="<?= $css_uniq_classes['fieldset-row-list'] ?>">

                    <div class="<?= $css_uniq_classes['row'] ?>">
                        <?= $showCountry() ?>
                    </div>

                    <div class="<?= $css_uniq_classes['row'] ?>">
                        <input type="text"
                               name="name"
                               placeholder="<?= $lang['name']; ?>"
                               autocomplete="off"
                               style="font-size: 2rem; padding: 20px 5px; margin-top: 20px; margin-bottom: 0;"
                        >
                    </div>

                    <div class="<?= $css_uniq_classes['row'] ?>">
                        <input type="text"
                               name="phone"
                               placeholder="<?= $lang['phone']; ?>"
                               autocomplete="off"
                               style="font-size: 2rem; padding: 20px 5px; margin-top: 20px; margin-bottom: 0"
                        >
                    </div>

                    <div class="<?= $css_uniq_classes['row'] ?>">
                        <input type="submit"
                               value="<?= $lang['btn-send']; ?>"
                               style="color: white; font-size: 2rem; margin-top: 20px;"
                        >
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>
