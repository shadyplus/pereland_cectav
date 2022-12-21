<?php

$dir_name = dirname(__FILE__);
require_once($dir_name . '/config.php');
require_once($dir_name . '/lib/app.php');

$dbg_mod = is_debug($_debug);

$post_data = [];
// Ключи по которым будут получены данные из $_POST
$post_keys = ['name', 'phone', 'email', 'comments', 'tech_comments', 'country', 'address', 'utm_source',
    'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'sub1', 'sub2', 'sub3', 'sub4', 'sub5',
];

foreach ($post_keys as $key) {
    $post_data[$key] = isset($_POST[$key]) ? clear_value($_POST[$key]) : '';
}
if (empty($post_data['tz'])) {
    $post_data['tz'] = '3';
}

if (!isset($post_data['phone']) || !isset($post_data['name']) || !isset($post_data['country'])) {
    $error_message = 'Получены не все данные. Вернитесь и заполните форму.';
    require($dir_name . '/error.php');
    die;
}

$request_data = [
    'id' => microtime(true), // тут лучше вставить значение, по которому вы сможете индетифицировать свой лид; можно оставить microtime если у вас нет своей crm
    'key' => $apiKey,
    'offer_id' => $offer_id,
    'stream_hid' => $stream_hid,
    'web_id' => '', // id вебмастера в вашей системе
    'ip_address' => (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']),
    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
];

$request_data = array_merge($post_data, $request_data);

display_debug_info('send data', $request_data);
$response = curl_get_contents($apiSendLeadUrl, $request_data);
display_debug_info('result', $response);
$response = json_decode($response);

$apiErrors = [
    'incorrect customer phone' => 'Не корректный телефон',
    'customer name too long' => 'Слишком длинное имя',
    'country is a required field' => 'Страна, обязательное поле',
    'offer not found' => 'оффер не найден или нет гео совпадающего с переданным в country',
    'incorrect IP-address' => 'не корректный IP-address',
    'incorrect country code; should be ISO2 or ISO3 format' => 'не корректный код страны передаваемый в поле country',
    'customer phone is a required field' => 'поле phone (телефон) обязательно для сохранения заявки',
    'incorrect timezone' => 'поле tz (таймзона) не верный формат',
];

if ($response === null || !empty($response->errmsg)) {
    $error_message = isset($apiErrors[$response->errmsg]) ? $apiErrors[$response->errmsg] : 'Ошибка в полученном ответе';
    require($dir_name . '/error.php');
    die;
}

if ($response->order_id) {

    if ($keitaro_postback) {
        $postback_url = $keitaro_postback . '?status=lead&subid=' . urlencode($post_data['sub1']);
        curl_get_contents($postback_url);
    }

    $order_id = $response->order_id;
    $order_name = $post_data['name'];
    $order_phone = $post_data['phone'];

    setcookie("order_id", $order_id);
    setcookie("order_name", $order_name);
    setcookie("order_phone", $order_phone);
    setcookie("product_name", $productName);

    $check_pixel = false;
    foreach ($pixels as $pixel_name) {
        if (isset($post_data[$pixel_name])) {
            $pixel_id = $post_data[$pixel_name];
            setcookie($pixel_name, $pixel_id);
            $check_pixel = true;
        } else {
            setcookie($pixel_name);
        }
    }
    if ($check_pixel) {
        $price = null;
        $currency = null;
        $offers = json_decode($dataOffers, true);
        foreach ($offers as $struct) {
            if ($post_data['country'] == $struct['country']['code']) {
                $price = $struct['price'];
                $currency = $struct['currency']['code'];
                setcookie("product_price", $price);
                setcookie("product_currency", $currency);
                break;
            }
        }
    }

    if (isset($response->prepayment_link)) {
        header('Location: ' . $response->prepayment_link);
        die();
    }

    header('Location: order.php');
    die();
}