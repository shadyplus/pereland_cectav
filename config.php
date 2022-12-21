<?php

define('LANDING_DIR', '');

$apiKey = 'nDv1PUMEa4RSYgip1b4dJApyantgwhj2rTjzjIUduRDxGQOYu7QrI4cSGw';
$offer_id = '9834';         // для каждого оффера свой айди, надо уточнять его в админке или у суппортов
$stream_hid = 'WxlcmJJQ';     // id потока

$landKey = 'cc0d351a77570133ec7c3fbcc8be36bc';

$redirectUrl = 'http://google.com';
$push_link = '';

$newPrice = '749';
$oldPrice = '1498';
$currencyDisplay = 'الجنيه المصرى';

$default_main_site = 'http://api.cpa.tl';
//$default_main_site = 'http://api.tradeblg.ru';
$apiSendLeadUrl = 'http://api.cpa.tl/api/lead/send_archive';
//$apiSendLeadUrl = 'http://api.tradeblg.ru/api/lead/send_archive';
$apiGetLeadUrl = 'http://api.cpa.tl/api/lead/feed';
//$apiGetLeadUrl = 'http://api.tradeblg.ru/api/lead/feed';

$dataOffers = '{"33205":{"id":33205,"name":"Iavomasaga","country":{"code":"EG","name":"\u0415\u0433\u0438\u043f\u0435\u0442"},"price":"749","price2":"1498","currency":{"code":"EGP","name":"\u0627\u0644\u062c\u0646\u064a\u0647 \u0627\u0644\u0645\u0635\u0631\u0649"}}}';
$dataOffer = '{"id":33205,"name":"Iavomasaga","country":{"code":"EG","name":"\u0415\u0433\u0438\u043f\u0435\u0442"},"price":"749","price2":"1498","currency":{"code":"EGP","name":"\u0627\u0644\u062c\u0646\u064a\u0647 \u0627\u0644\u0645\u0635\u0631\u0649"}}';
$is_geo_detect = '1';
$productName = 'Iavomasaga';
$invoice = 'index.php';
$language = 'ar';
$push_link = '';
$fb_verification = '';
$showcase_url = '';

$_debug = false; // установите True для вывода дополнительной информации для отладки и поиска ошибок

$pixels = [
    'fb_pixel', 'fb_verify', 'google_pixel', 'google_adw_pixel', 'tiktok_pixel', 'topmail_pixel', 'vk_pixel', 'yandex_metrika'
];

if (!$apiKey) {
    echo 'Ключ доступа к API не определен. Получите в личном кабинете или обратитесь в службу поддержки';
    die;
}

if (!$offer_id) {
    echo 'ID оффера не определен';
    die;
}
