<!DOCTYPE html>
<html>
<head>
    <title>Заказ принят</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow" />
    <link rel="stylesheet" type="text/css" href="invoice2/static/style.css" media="all">
    <style>
        body { margin-top: 50px }
    </style>
</head>

<body>
<?php if($order_id) { ?>
    <h1>Ваша заявка принята</h1>

    <p>
        Спасибо за Ваш заказ! <br>
        Наш оператор свяжется с Вами в самое ближайшее время. Пожалуйста, включите ваш контактный телефон.
    </p>

    <table style="margin: auto">

        <tr>
            <th>Вы заказали</th>
            <td>
                <p><?= $product_name ?></p>
            </td>
        </tr>

        <tr>
            <th>Заказ №:</th>
            <td><?= $order_id ?></td>
        </tr>


        <tr>
            <th>Имя:</th>
            <td><?= $order_name; ?></td>
        </tr>


        <tr>
            <th>Телефон для связи:</th>
            <td><?= $order_phone; ?></td>
        </tr>


    </table>

<?php
    if (isset($tracker_pixels)) {
        foreach($tracker_pixels as $pixel_name => $pixel_id) {
            require_once (__DIR__.'/../pieces/trackers/'.$pixel_name.'.php');
        }
    }
    require_once (__DIR__.'/../trackers_order.php');
}
else {
    echo 'Error!';
}
?>

</body>
</html>