<style>
    .<?= $css_uniq_classes['form_root'] ?> * {
        all: unset;
        margin: 0;
        padding: 0;
        outline: none;
        border: 0;
        box-sizing: border-box;
    }

    .<?= $css_uniq_classes['app'] ?> {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 100%;
    }

    .<?= $css_uniq_classes['wrapper-form'] ?> {
        padding: 5px;
        border-radius: 5px;
        max-width: 525px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: center;
    }

    .<?= $css_uniq_classes['fieldset-row-list'] ?> {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .<?= $css_uniq_classes['order_form'] ?> div.<?= $css_uniq_classes['row'] ?> {
        padding: 4px 0;
        width: 100%;
    }

    .<?= $css_uniq_classes['order_form'] ?> {
        all: initial;
        width: 100%;
        font-family: sans-serif;
    }

    .<?= $css_uniq_classes['order_form'] ?> p {
        font-size: 1rem;
        color: #1D1D1D;
        text-align: center;
        width: 100%;
    }

    .<?= $css_uniq_classes['order_form'] ?> input[type=text],
    .<?= $css_uniq_classes['order_form'] ?> select {
        display: block;
        width: 100%;
        padding: 20px 5px;
        border: #888 1px solid;
        font-size: 2rem;
        border-radius: 5px;
        background: #fff;
    }

    .<?= $css_uniq_classes['order_form'] ?> select {
        -webkit-appearance: auto;
    }

    .<?= $css_uniq_classes['order_form'] ?> input[type=submit] {
        border: none;
        background: <?= $colors_schemes[$color]['background'] ?>;
        max-width: 334px;
        width: 100%;
        border-radius: 5px;
        height: 72px;
        line-height: 32px;
        color: white;
        font-size: 2rem;
        overflow: hidden;
        cursor: pointer;
        margin: 5px auto 5px;
        padding: 0;
        text-align: center;
        display: block;
    }

    .<?= $css_uniq_classes['order_form'] ?> input[type=submit]:hover {
        background: <?= $colors_schemes[$color]['background:hover'] ?>;
    }

    .<?= $css_uniq_classes['wrapper-form'] ?> p {
        all: initial;
        text-align: center;
        font-weight: 700;
    }

    p.<?= $css_uniq_classes['old_price'] ?> {
        text-decoration: line-through;
        font-size: 3.7em;
    }

    p.<?= $css_uniq_classes['new_price'] ?> {
        font-size: 4rem;
    }

    <?php if ($color === 'dark'): ?>
    .<?= $css_uniq_classes['order_form'] ?> input::placeholder {
        color: white;
    }

    .<?= $css_uniq_classes['order_form'] ?> input::-webkit-input-placeholder {
        color: white;
    }

    .<?= $css_uniq_classes['order_form'] ?> input::-moz-placeholder {
        color: white;
    }

    .<?= $css_uniq_classes['order_form'] ?> input:-moz-placeholder {
        color: white;
    }

    .<?= $css_uniq_classes['order_form'] ?> input:-ms-input-placeholder {
        color: white;
    }

    .<?= $css_uniq_classes['app'] ?> {
        background: #4a4a4a;
    }

    .<?= $css_uniq_classes['order_form'] ?> input[type=text],
    .<?= $css_uniq_classes['order_form'] ?> select {
        color: #fff;
        background: #6f6f6f;
    }

    .<?= $css_uniq_classes['wrapper-form'] ?> p {
        color: #fff;
    }

    <?php endif ?>
</style>
