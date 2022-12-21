<?php

$dir_name = dirname(__FILE__);

require_once($dir_name . '/config.php');
require_once($dir_name . '/lib/app.php');

global $invoice;

$dbg_mod = is_debug($_debug);

if (isset($_COOKIE["order_id"])) {
    $order_id = $_COOKIE["order_id"];
    $order_name = $_COOKIE["order_name"];
    $order_phone = $_COOKIE["order_phone"];
    $product_name = $_COOKIE["product_name"];
}

$tracker_pixels = [];
$check_pixel = false;

foreach ($pixels as $pixel_name) {
    if (isset($_COOKIE[$pixel_name])) {
        $tracker_pixels[$pixel_name] = $_COOKIE[$pixel_name];
        $check_pixel = true;
    }
}

if ($check_pixel) {
    if (isset($order_id)) {
        $lead = 1;
    }
    $product_price = $_COOKIE['product_price'];
    $product_currency = $_COOKIE['product_currency'];
}

$invoice_path = $dir_name . '/invoice2/' . $invoice;

if (!file_exists($invoice_path)) {
    $invoice_path = $dir_name . '/invoice2/index.php';
}
require_once ($invoice_path);