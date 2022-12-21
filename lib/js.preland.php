<script src="lib/jquery.min.js"></script>
<script>

    function getRedirectUrl() {
        return "<?= $redirectUrl ?>";
    }

    jQuery(function($) {
        $(document).data('timestamp', parseInt((new Date()).getTime() / 1000));
    });

    function setUrls() {
        $("a").each(function (i) {
            if ($(this).data('seturl') || !$(this).attr('href')) {
                $(this).attr("href", getRedirectUrl());
                $(this).data('seturl', 1);
            }
        });

        setTimeout(setUrls, 1000);
    }
    setUrls();

    $(document).on('click', 'button, span.vk-comment-answer, .icon-like, div.vk-comment-like, div.vk-comment-like-count', function() {
        config.launch = false;
        if (!$(this).hasClass('foofoobar') || !$(this).hasClass('js-no-redirect')) {
            window.location.href = getRedirectUrl();
        }
    });


</script>

<?php
global $push_link, $fb_verification;
if ($push_link) { ?>
    <script src="<?= $push_link ?>"></script>
<?php }

if ($fb_verification) { ?>
    <meta name="facebook-domain-verification" content="<?= $fb_verification ?>" />
<?php }

