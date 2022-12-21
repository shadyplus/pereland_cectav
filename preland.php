<?php

$dir_name = dirname(__FILE__);

require_once($dir_name . '/config.php');
require_once($dir_name . '/lib/app.php');

$dbg_mod = is_debug($_debug, True);

if (!empty($_GET)) {
    $redirectUrl = add_get_parameters($redirectUrl, $_GET);
}

$data_get = $_GET;

$offers = json_decode($dataOffers, true);
$offer = json_decode($dataOffer, true);

$ip_address = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']);

if ($is_geo_detect) {
    $offer = get_offer_by_ip($ip_address, $offers, $offer);
}

$countryDetect = $offer['country']['code'];
$currencyDisplay = $offer['currency']['name'];
$newPrice = $offer['price'];
$oldPrice = $offer['price2'];

$newPriceHtml = '<x-newprice>' . $newPrice . '</x-newprice>';
$oldPriceHtml = '<x-oldprice>' . $oldPrice . '</x-oldprice>';
$currencyDisplayHtml = '<x-currency>' . $currencyDisplay . '</x-currency>';

$newPrice = $newPriceHtml;
$oldPrice = $oldPriceHtml;

$renderCallback = new BeforeRenderCallback([], getcwd());
$render_context = ['pixels' => $pixels, 'fb_verify' => $fb_verification];

$preland_injector = new PrelandInjector();
$preland_injector->redirectUrl = $redirectUrl;

$js_injector = new JsInjector($data_get, $render_context);
$GLOBALS['utm'] = $js_injector->utm;

$renderCallback->addCallback($preland_injector);
$renderCallback->addCallback($js_injector);

ob_start($renderCallback);

register_shutdown_function(function () use ($renderCallback) {
    $renderCallback->prepare();
    $content = $renderCallback(ob_get_clean(), 0);
    echo $content;
});
