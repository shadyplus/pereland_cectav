<?php
$file_translate = __DIR__.'/languages/'. $language . '.php';

if (file_exists($file_translate)) {
    require_once($file_translate);
} else {
    $lang = array(
        'title' => 'Заказ принят',
        'h1' => 'Ваша заявка принята',
        'thanks' => 'Спасибо за Ваш заказ!',
        'thanks2' => 'Наш оператор свяжется с Вами в самое ближайшее время. Пожалуйста, включите ваш контактный телефон.',
        'ordered' => 'Вы заказали',
        'order' => 'Заказ №:',
        'created_at' => 'Сделан:',
        'name' => 'Имя:',
        'address' => 'Адрес доставки:',
        'email' => 'E-mail:',
        'phone' => 'Телефон для связи:',
        'comments' => 'Примечание:',
        'delivery1' => 'Стоимость доставки для Вас расчитает оператор.',
        'delivery2' => 'Доставка',
        'delivery3' => 'Итого:',
    );
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang['title']; ?></title>
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
    <h1><?php echo $lang['h1']; ?></h1>

    <p>
        <?php echo $lang['thanks']; ?><br>
        <?php echo $lang['thanks2']; ?>
    </p>

    <table style="margin: auto">

        <tr>
            <th><?php echo $lang['ordered']; ?></th>
            <td>
                <p><?= $product_name ?></p>
            </td>
        </tr>

        <tr>
            <th><?php echo $lang['order']; ?></th>
            <td><?= $order_id ?></td>
        </tr>


        <tr>
            <th><?php echo $lang['name']; ?></th>
            <td><?= $order_name; ?></td>
        </tr>


        <tr>
            <th><?php echo $lang['phone']; ?></th>
            <td><?= $order_phone; ?></td>
        </tr>


    </table>

<?php
    if (isset($tracker_pixels))
    {
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